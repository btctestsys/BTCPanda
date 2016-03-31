<?php
namespace App\Http\Controllers;
use Auth;
use App\User;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Crypt;
class WalletController extends Controller
{	    
    private $user;
    public function __construct()
    {    	
    	$this->user = Auth::user();
    }
    public function getIndex()
    {
    	$available_balance = Self::checkAvailableBalance();
        Self::updateWallet();
		//---------------------------------------
        $wallet = DB::table('wallets')
            ->where('user_id',$this->user->id)->first();
        $available_balance = $wallet->current_balance + ($wallet->pending_balance);

		$walletqueue_history = DB::select('select created_at,`from`,`to`,amt,match_id,if(match_id=0,\'SEND\',\'GH\') typ,`status`,json from wallet_queues where `from`=\'' . $wallet->wallet_address . '\' or `to`=\'' . $wallet->wallet_address . '\' order by id desc limit 100');

		$walletqueue = DB::select('select sum(amt) amt from wallet_queues where `status`=0 and `from`=\'' . $wallet->wallet_address . '\' ');
		$wallet_queue = 0;
        foreach($walletqueue as $output)
        {
            $wallet_queue = $output->amt;            
        }
        $available_balance_final = $available_balance - $wallet_queue - (app('App\Http\Controllers\PhController')->sumPhActive() - app('App\Http\Controllers\PhController')->sumPhActiveDistributed());
		//---------------------------------------

        return view('wallet')
           ->with('user',$this->user)
           ->with('current_balance',$wallet->current_balance)
           ->with('pending_balance',$wallet->pending_balance)
           ->with('available_balance',$available_balance)
           ->with('wallet_queue',$wallet_queue)
           ->with('walletqueue_history',$walletqueue_history)
           ->with('available_balance_final',$available_balance_final)
           ->with('sumPhActive',app('App\Http\Controllers\PhController')->sumPhActive())
           ->with('sumPhActiveDistributed',app('App\Http\Controllers\PhController')->sumPhActiveDistributed())
           ->with('available_balance',$available_balance_final);
    }

    public function updateMainWallet($current_user,$current_address)
    {
		//--------------------------------------------------------
    	//update main wallet
		//--------------------------------------------------------
        $address = $current_address;
    	
        //block.io - active
        try
        {
            $json = json_decode(file_get_contents("https://block.io/api/v2/get_address_balance/?api_key=".$_ENV['BLOCKIO_KEY']."&addresses=$address"));
        }
        catch(\Exception $e)
        {
            abort(500,'Too many sync requests to Blockchain (block.io)');
        }
        if($json)
        {
            DB::table('wallets')
                ->where('user_id',$current_user)
                ->update([
                    'current_balance' => $json->data->available_balance,
                    'pending_balance' => 0,
                    'available_balance' => $json->data->pending_received_balance,
                ]);
			return $address . " updated.<br>";
        }


    }


    public function updateWallet()
    {
		//--------------------------------------------------------
    	//update main wallet
		//--------------------------------------------------------
        $address = $this->user->wallet->wallet_address;
    	
        //chain.so - not used
        /*try
        {
            $json = json_decode(file_get_contents("https://chain.so/api/v2/get_address_balance/BTC/$address/0"));
        }
        catch(\Exception $e)
        {
            abort(500,'Too many sync requests');
        }
        */
        //blockchain.info - not used
        /*
        try
        {
            $blockchain_current_balance = file_get_contents("https://blockchain.info/q/addressbalance/$address/confirmations=3")/100000000;
        }
        catch(\Exception $e)
        {
            abort(500,'Too many sync requests to Blockchain (blockchain.info)');
        }
    	
    	if($blockchain_current_balance)
    	{
    		DB::table('wallets')
				->where('user_id',$this->user->id)
    			->update([
	    			//'current_balance' => $json->data->confirmed_balance,
                    'current_balance' => $blockchain_current_balance,
	    			'pending_balance' => 0,
	    			'available_balance' => $blockchain_current_balance,
    			]);
    	}
        */
        //block.io - active
        try
        {
            $json = json_decode(file_get_contents("https://block.io/api/v2/get_address_balance/?api_key=".$_ENV['BLOCKIO_KEY']."&addresses=$address"));
        }
        catch(\Exception $e)
        {
            abort(500,'Too many sync requests to Blockchain (block.io)');
        }
        if($json)
        {
            DB::table('wallets')
                ->where('user_id',$this->user->id)
                ->update([
                    'current_balance' => $json->data->available_balance,
                    'pending_balance' => 0,
                    'available_balance' => $json->data->pending_received_balance,
                ]);
        }

		//--------------------------------------------------------
    	//update main wallet
		//--------------------------------------------------------
        $address = $this->user->walletBamboo->wallet_address;
        
        /*
        try
        {
            $json = json_decode(file_get_contents("https://chain.so/api/v2/get_address_balance/BTC/$address/0"));    
        }
        catch(\Exception $e)
        {
            abort(500,'Too many sync requests (chain.so)');
        }
        
        if($json)
        {
            $available_balance = $json->data->confirmed_balance;
            DB::table('wallet_bamboos')
                ->where('user_id',$this->user->id)
                ->update([
                    'current_balance' => $json->data->confirmed_balance,
                    'pending_balance' => $json->data->unconfirmed_balance,
                    'available_balance' => $available_balance,
                ]);
        }
        */
        //block.io
        try
        {
            $json = json_decode(file_get_contents("https://block.io/api/v2/get_address_balance/?api_key=".$_ENV['BLOCKIO_KEY']."&addresses=$address"));
        }
        catch(\Exception $e)
        {
            abort(500,'Too many sync requests to Blockchain (block.io)');
        }
        if($json)
        {
			//return $json;
            DB::table('wallet_bamboos')
                ->where('user_id',$this->user->id)
                ->update([
                    'current_balance' => $json->data->available_balance,
                    'pending_balance' => $json->data->pending_received_balance,
                    'available_balance' => $json->data->available_balance,
                ]);
        }
    }

    public function postSend_old(Request $request)
    {
        //update wallet first
        Self::updateWallet();
        //check minimum
        if($request->amt > Self::checkAvailableBalance()- $_ENV['MIN_BALANCE'])
        {
            abort(500,"Must leave 0.01 BTC minimum");
        }
        //check otp
        if($this->user->otp == $request->otp)
        {
            $wallet_id = Crypt::decrypt($request->hidden);
            $address = $request->address;
            $amt = $request->amt;
            
            if($request->fee) $fee = $request->fee;
            else $fee = 0;
            if($request->fee == -1) $fee = -1;

			//return "/" . $wallet_id . "/" . $address . "/" . $amt . "/" . $fee;

            try 
            {
                $json = file_get_contents("http://btcpanda.info/bitcoin/send/".$wallet_id."/".$address."/".$amt."/".$fee);        
            } 
            catch (\Exception $e) 
            {
                abort(500,"Unable to reach Blockchain");
            }
            
            if($json)
            {
                $object = json_decode($json);
                if(@$object->tx_hash) return redirect("http://blockchain.info/tx/".$object->tx_hash);
                else return $json;
            }
            else
            {
                return abort(500,"Error");
            }
        }
        else
        {
            abort(500,"Wrong OTP");
        }
    }

    public function postSend(Request $request)
    {
		$next_trans = Self::get_next_trans_inmin_inwallet();
		if ($next_trans > 0)
        {
            abort(500,"Please wait " . $next_trans . " minutes before making next transaction.");
        }
		else
		{
			//update wallet first
			Self::updateWallet();
			//check minimum
			if($request->amt < 0.01)
			{
				abort(500,"Must specify at least 0.01 BTC");
			}
			else
			{
				if($request->amt > Self::checkAvailableBalance()- $_ENV['MIN_BALANCE'])
				{
					abort(500,"Must leave 0.01 BTC minimum");
				}
				//check otp
				if($this->user->otp == $request->otp)
				{
					$wallet_address = $this->user->wallet->wallet_address;

					$wallet_id = Crypt::decrypt($request->hidden);
					$address = $request->address;
					$amt = $request->amt;
					
					if(is_null($address) || empty($address) || strlen($address) < 1)
					{
						abort(500,"Must specify address");
					}
					else
					{
						if($request->fee < 0.0005) {
							abort(500,"Must specify at least 0.0005 BTC minimum fee");
						}
						else {
							$fee = $request->fee;
							//DB::select('insert into wallet_queues (to,from,created_at,amt,match_id, fee) values(\'' . $address . '\',\'' . $wallet_address . '\',now(),' . $amt . ',0,' . $fee . ')');
							//DB::insert('insert into wallet_queues (`to`,`from`,created_at,amt,match_id, fee) values(\'?\',\'?\',now(),?,0,?)',[$address,$wallet_address,floatval($amt),$fee]);
			
							$sql = 'insert into wallet_queues (`to`,`from`,created_at,amt,match_id,`status`, fee) values(\'' . $address .'\',\'' . $wallet_address . '\',now(),' . floatval($amt) . ',0,0,' . $fee . ')';
							DB::insert($sql);

							return back();

							//$record_id = DB::select('select LAST_INSERT_ID() as id');
							//$queue_id = 0;
							//foreach($record_id as $output)
							//{
							//	$queue_id = $output->id;            
							//}

							//return $sql;
							//if($queue_id)
							//	{return 1;}
							//else
							//	{return 0;}
						}
					}
				}
				else
				{
					abort(500,"Wrong OTP");
				}
			}
		}
    }

    public function checkAvailableBalance()
    {
        $wallet = DB::table('wallets')
            ->where('user_id',$this->user->id)->first();
        $available_balance = $wallet->current_balance + ($wallet->pending_balance);

		$walletqueue = DB::select('select sum(amt) amt from wallet_queues where `status`=0 and fee > 0 and `from`=\'' . $wallet->wallet_address . '\' ');
		$wallet_queue = 0;
        foreach($walletqueue as $output)
        {
            $wallet_queue = $output->amt;            
        }

        $available_balance_final = $available_balance - $wallet_queue - (app('App\Http\Controllers\PhController')->sumPhActive() - app('App\Http\Controllers\PhController')->sumPhActiveDistributed());
        return $available_balance_final;
        //return array($available_balance , app('App\Http\Controllers\PhController')->sumPhActive() , app('App\Http\Controllers\PhController')->sumPhActiveDistributed());
    }    

    public function get_next_trans_inmin_inwallet()
    {
		$next_wait = DB::select('select check_next_trans_inminutes(' . $this->user->id . ') waittime; ');
        $next_wait_time = 0;
		foreach($next_wait as $output)
        {
			$next_wait_time = $output->waittime;           
        }
		return $next_wait_time; 
    }
}