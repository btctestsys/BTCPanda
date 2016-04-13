<?php
namespace App\Http\Controllers;
use Auth;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use App\User;
use App\Classes\Custom;
class BambooController extends Controller
{

	private $user;
    public function __construct()
    {
    	$this->user = Auth::user();
    }
    public function getIndex()
    {
    	$history = Self::getHistory();
    	return view('bamboo')
    		->with('user',$this->user)
    		->with('history',$history);
    }
    public function postSend(Request $request)
    {
		//otp check
        if($this->user->otp != $request->otp) abort(500,'Wrong OTP');

        //get stuff
		$username = $request->username;
    	$amt = $request->amt;
    	$from_balance = $this->user->bamboo_balance - $amt;
    	//get user
    	$user = User::where('username',$username)->first();
    	if($user) $to_balance = $user->bamboo_balance + $amt;
    	//validate request
		if($from_balance < 0 or $amt <= 0 or !$user)
		{
			return redirect('/bamboo');
		}
    	//DB::table('bamboos')->insert([
    	//	'created_at'	=>	date('Y-m-d H:i:s'),
    	//	'from'			=>	$this->user->id,
    	//	'to'			=>	$user->id,
    	//	'amt'			=>	$amt,
    	//	'from_balance'	=>	$from_balance,
    	//	'to_balance'	=>	$to_balance,
    	//	'notes'			=>	$this->user->username." -> ".$user->username,
		//]);
		DB::insert('insert into bamboos (created_at,`from`,`to`,amt,from_balance,to_balance,notes) values(now(),' . $this->user->id . ',' . $user->id .',' . $amt . ',' . $from_balance . ',' . $to_balance . ',\'' . $this->user->username." -> ".$user->username . '\')');
		//DB::insert('insert into bamboos (created_at,`from`,`to`,amt,from_balance,to_balance,notes) values(now(),?,1,?,?,?,\'?\')',[$this->user->id,$amt,$from_balance,$to_balance,$this->user->username." -> ".$user->username]);

		DB::table('users')
			->where('id',$this->user->id)
			->decrement('bamboo_balance',$amt);
		DB::table('users')
			->where('id',$user->id)
			->increment('bamboo_balance',$amt);
		return redirect('/bamboo');
    }
    public function getHistory()
    {
    	return DB::table('bamboos')
    		->where('to',$this->user->id)
    		->orWhere('from',$this->user->id)
    		->orderBy('created_at','desc')
    		->take(50)->get();
    }
    public function BambooRequired($amt)
    {
        if($amt < 0.1) return 1;
        if($amt >= 0.1 && $amt <= 3)  return 1;
        if($amt > 3 && $amt <= 6)     return 2;
        if($amt > 6 && $amt <= 9)     return 3;
        if($amt > 9 && $amt <= 12)    return 4;
        if($amt > 12 && $amt <= 15)   return 5;
        if($amt > 15) return 5;
    }
    public function BambooCheck($user_id,$bamboo_required)
    {
        $bamboo_balance = DB::table('users')->where('id',$user_id)->value('bamboo_balance');
        if($bamboo_balance >= $bamboo_required) return true;
        else return false;
    }
    public function deductBamboo($bamboo,$notes)
    {
        //to from balance
        $from_bamboo_balance = DB::table('users')->where('id',$this->user->id)->value('bamboo_balance');
        $to_bamboo_balance = DB::table('users')->where('id',1)->value('bamboo_balance');
        DB::table('users')
            ->where('id',$this->user->id)
            ->decrement('bamboo_balance',$bamboo);
        DB::table('users')
            ->where('id',1)
            ->increment('bamboo_balance',$bamboo);
        DB::table('bamboos')->insert([
            'created_at'    =>  date('Y-m-d H:i:s'),
            'amt'           =>  $bamboo,
            'from'          =>  $this->user->id,
            'to'            =>  1,
            'from_balance'  =>  $from_bamboo_balance-$bamboo,
            'to_balance'    =>  $to_bamboo_balance+$bamboo,
            'notes'         =>  $notes
        ]);
		//DB::insert('insert into bamboos (created_at,`from`,`to`,amt,from_balance,to_balance,notes) values(now(),' . $this->user->id . ',1,' . $bamboo . ',' . $from_bamboo_balance-$bamboo . ',' . $to_bamboo_balance+$bamboo . ',\'' . $notes . '\')');
		//DB::select('insert into bamboos (created_at,`from`,`to`,amt,from_balance,to_balance,notes) values(now(),?,1,?,?,?,\'?\')',[$this->user->id,$bamboo,$from_bamboo_balance-$bamboo,$to_bamboo_balance+$bamboo,$notes]);
		//DB::insert('insert into bamboos (created_at,`from`,`to`,amt,from_balance,to_balance,notes) values(now(),' . $this->user->id . ',1,' . $bamboo . ',' . $from_bamboo_balance-$bamboo . ',' . $to_bamboo_balance+$bamboo . ',\'' . $notes . '\')');
}
    public function addBamboo($bamboo,$notes,$rate)
    {
        //check previous record
		$last_user = DB::select('SELECT `to` from bamboos order by id desc limit 1');
        foreach($last_user as $output)
        {
			if($output->to == $this->user->id)
			{
				return abort(500,"Please wait 30 minutes and try again...");
			}
		}
	    //$last_user = DB::table('bamboos')->orderby('id','desc')->first();
        //if($last_user->to == $this->user->id)
        //{
        //    return abort(500,"Please wait 30 minutes and try again.");
        //}
        //to from balance
        $from_bamboo_balance = DB::table('users')->where('id',1)->value('bamboo_balance');
        $to_bamboo_balance = DB::table('users')->where('id',$this->user->id)->value('bamboo_balance');

        DB::table('users')
            ->where('id',$this->user->id)
            ->increment('bamboo_balance',$bamboo);
        DB::table('users')
            ->where('id',1)
            ->decrement('bamboo_balance',$bamboo);
        DB::table('bamboos')->insert([
            'created_at'    =>  date('Y-m-d H:i:s'),
            'amt'           =>  $bamboo,
            'from'          =>  1,
            'to'            =>  $this->user->id,
            'from_balance'  =>  $from_bamboo_balance-$bamboo,
            'to_balance'    =>  $to_bamboo_balance+$bamboo,
            'notes'         =>  $notes,
            'rate'          =>  $rate
        ]);
		//DB::select('insert into bamboos (created_at,`from`,`to`,amt,from_balance,to_balance,notes,rate) values(now(),1,' . $this->user->id . ',' . $bamboo . ',' . $from_bamboo_balance-$bamboo . ',' . $to_bamboo_balance+$bamboo . ',\'' . $notes . '\',' . $rate . ')');
		//DB::select('insert into bamboos (created_at,`from`,`to`,amt,from_balance,to_balance,notes,rate) values(now(),?,1,?,?,?,\'?\',?)',[$this->user->id,$bamboo,$from_bamboo_balance-$bamboo,$to_bamboo_balance+$bamboo,$notes,$rate]);
		//DB::insert('insert into bamboos (created_at,`from`,`to`,amt,from_balance,to_balance,notes,rate) values(now(),1,' . $this->user->id . ',' . $bamboo . ',' . $from_bamboo_balance-$bamboo . ',' . $to_bamboo_balance+$bamboo . ',\'' . $notes . '\',' . $rate . ')');
    }
    public function checkUnconfirmBalance()
    {
        $address = $this->user->walletBamboo->wallet_address;
        //$json = json_decode(file_get_contents("https://chain.so/api/v2/get_address_balance/BTC/$address/0"));
        $json = json_decode(file_get_contents("https://block.io/api/v2/get_address_balance/?api_key=".$_ENV['BLOCKIO_KEY']."&addresses=$address"));
        if($json->data->pending_received_balance != 0.00000000)
        {
            return '1';
        }
        else
        {
            return '0';
        }
    }
    public function postCheck()
    {
        if($this->user->walletBamboo->pending_balance == 0.00000000)
        {
            $address = $this->user->walletBamboo->wallet_address;
            //$json = json_decode(file_get_contents("https://chain.so/api/v2/get_address_balance/BTC/$address/0"));
            $json = json_decode(file_get_contents("https://block.io/api/v2/get_address_balance/?api_key=".$_ENV['BLOCKIO_KEY']."&addresses=$address"));

            if($json)
            {
                $unconfirmed_balance = $json->data->pending_received_balance;
                if($unconfirmed_balance == 0)
                {
                    return redirect('/bamboo/#bamboo-buy');
                }
                else
                {
                    $bamboo_price = Custom::getPinBTCAmount();
                    $bamboo = ceil($unconfirmed_balance / $bamboo_price);
                    $notes = "BUY @ $bamboo_price (".$this->user->username.")";
                    Self::addBamboo($bamboo,$notes,$bamboo_price);
                    DB::table('wallet_bamboos')
                        ->where('user_id',$this->user->id)
                        ->update([
                        'pending_balance' => $unconfirmed_balance
                    ]);
                }
                return back();
            }
            else
            {
                return back();
            }
        }
        else
        {
            return back();
        }
    }
    public function postCheckx()
    {
        if($this->user->walletBamboo->pending_balance == 0.00000000)
        {
            $address = $this->user->walletBamboo->wallet_address;
            //$json = json_decode(file_get_contents("https://chain.so/api/v2/get_address_balance/BTC/$address/0"));
            $json = json_decode(file_get_contents("https://block.io/api/v2/get_address_balance/?api_key=".$_ENV['BLOCKIO_KEY']."&addresses=$address"));

            if($json)
            {
                $unconfirmed_balance = $json->data->available_balance;
                if($unconfirmed_balance == 0)
                {
                    return redirect('/bamboo/#bamboo-buy');
                }
                else
                {
                    $bamboo_price = Custom::getPinBTCAmount();
                    $bamboo = floor($unconfirmed_balance / $bamboo_price);
                    $notes = "BUY @ $bamboo_price (".$this->user->username.")";
                    Self::addBamboo($bamboo,$notes,$bamboo_price);
                    DB::table('wallet_bamboos')
                        ->where('user_id',$this->user->id)
                        ->update([
                        'pending_balance' => $unconfirmed_balance
                    ]);
                }
                return back();
            }
            else
            {
                return back();
            }
        }
        else
        {
            return back();
        }
    }
    public function postChecky(Request $request)
    {
        if($this->user->walletBamboo->pending_balance == 0.00000000)
        {
            $address = $this->user->walletBamboo->wallet_address;
            //$json = json_decode(file_get_contents("https://chain.so/api/v2/get_address_balance/BTC/$address/0"));

            if(true)
            {
                $unconfirmed_balance = $request->yamt;
                if($unconfirmed_balance == 0)
                {
                    return redirect('/bamboo/#bamboo-buy');
                }
                else
                {
                    $bamboo_price = Custom::getPinBTCAmount();
                    $bamboo = floor($unconfirmed_balance / $bamboo_price);
                    $notes = "BUY @ $bamboo_price (".$this->user->username.")";
                    Self::addBamboo($bamboo,$notes,$bamboo_price);
                    DB::table('wallet_bamboos')
                        ->where('user_id',$this->user->id)
                        ->update([
                        'pending_balance' => $unconfirmed_balance
                    ]);
                }
                return back();
            }
            else
            {
                return back();
            }
        }
        else
        {
            return back();
        }
    }
    public function checkUnconfirmBalanceAjax()
    {
        $address = $this->user->walletBamboo->wallet_address;
        //$json = json_decode(file_get_contents("https://chain.so/api/v2/get_address_balance/BTC/$address/0"));
        $json = json_decode(file_get_contents("https://block.io/api/v2/get_address_balance/?api_key=".$_ENV['BLOCKIO_KEY']."&addresses=$address"));
        if($json->data->pending_received_balance != 0.00000000)
        {
            return '1';
        }
        else
        {
            return '0';
        }
    }
}
