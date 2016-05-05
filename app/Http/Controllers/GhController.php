<?php
namespace App\Http\Controllers;

use Auth;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use App\User;
use App\Match;
use App\Ph;
use App\Gh;
use App\Earning;
use App\Referral;
use App\Unilevel;
use App\Classes\Custom;

class GhController extends Controller
{
    private $user;

    public function __construct()
    {
    	$this->user = Auth::user();
    }

    public function getIndex()
    {
    	$earnings_pending = Earning::where('user_id',$this->user->id)->where('status',0)->orwhere('status',null)->sum('amt');
        $earning = Earning::where('user_id',$this->user->id)->where('status',1)->sum('amt');
        $earnings_transfer = Earning::where('user_id',$this->user->id)->where('status',2)->sum('amt');

        $referral_pending = Referral::where('user_id',$this->user->id)->where('status',0)->orwhere('status',null)->sum('amt');
        $referral = Referral::where('user_id',$this->user->id)->where('status',1)->sum('amt');
        $referral_transfer = Referral::where('user_id',$this->user->id)->where('status',2)->sum('amt');

        $unilevel_pending = Unilevel::where('user_id',$this->user->id)->where('status',0)->orwhere('status',null)->sum('amt');
        $unilevel = Unilevel::where('user_id',$this->user->id)->where('status',1)->sum('amt');
        $unilevel_transfer = Unilevel::where('user_id',$this->user->id)->where('status',2)->orwhere('status',null)->sum('amt');

        $total_gh = Gh::where('user_id',$this->user->id)->where('status',2)->sum('amt');

        $gh_balance = $earning + $referral + $unilevel;
        $gh_pending = $earnings_pending + $referral_pending + $unilevel_pending; //not used already
        $pending_sent = abs(round($earnings_transfer + $referral_transfer + $unilevel_transfer - $total_gh,8));

		$nowdt = DB::select('select now() dt');
        foreach($nowdt as $output)
        {
            $now = $output->dt;
        }

        //history
        $history = Gh::where('user_id',$this->user->id)->orderby('created_at','desc')->get();
        foreach($history as $output)
        {
            //add gh user list to ph
            //$ph_users = Match::where('gh_id',$output->id)->get();
			$ph_users = DB::select('SELECT m.*,w.wallet_address,u.username,u.country from matches m inner join ph p on m.ph_id=p.id inner join users u on p.user_id=u.id inner join wallets w on p.user_id=w.id where m.gh_id=' . $output->id);

            $ph_users_list = array();

            foreach($ph_users as $output2)
            {
                $ph_users_list[] .= '<i class="fa fa-bitcoin"></i> '.$output2->amt.' <a target="_blank" href="http://blockchain.info/address/'.$output2->wallet_address.'">'.$output2->username.' ('.$output2->country.')</a>';
            }

            $output->ph_users_list = $ph_users_list;
        }

		$walletqueue_history = DB::select('select q.created_at,q.`from`,q.`to`,q.amt,q.match_id,if(q.match_id=0,\'SEND\',\'GH\') typ,q.`status`,q.json from wallet_queues q inner join wallets w on q.`to`=w.wallet_address where w.id=\'' . $this->user->id . '\' order by q.id desc limit 100');

        return view('gh')
            ->with('now',$now)
            ->with('history',$history)
            ->with('walletqueue_history',$walletqueue_history)
            ->with('referral',$referral)
            ->with('unilevel',$unilevel)
            ->with('earning',$earning)
            ->with('gh_balance',$gh_balance)
            ->with('gh_pending',$gh_pending)
            ->with('total_gh',$total_gh)
            ->with('pending_sent',$pending_sent)
            ->with('user',$this->user);
    }

    public function postCreateReferrals()
    {
		$next_trans = Self::get_next_trans_inmin_ingh();
		if ($next_trans > 0)
        {
            abort(500,"Please wait " . $next_trans . " minutes before making next transaction.");
        }
		else
		{
			//$table_referrals = DB::table('referrals')->where('user_id',$this->user->id)->where('status',1)->get();
			$amt = Referral::where('user_id',$this->user->id)->where('status',1)->sum('amt');
			if($amt <= 0) abort(500,'Invalid GH');

			//foreach($table_referrals as $output)
			//{
				//insert gh referrals
				//$gh_id = DB::table('gh')->insertGetId([
				//    'amt'           =>  $amt,
				//    'created_at'    =>  date('Y-m-d H:i:s'),
				//    'status'        =>  0,
				//    'user_id'       =>  $this->user->id,
				//    'type'          =>  1,
				//    'type_id'       =>  -1, //$output->id
				//]);
				//DB::select('insert into gh (amt,created_at,status,user_id,type,type_id) values(\'' . $amt . '\',now(),0,' . $this->user->id . ',1,-1)');
				DB::insert('insert into gh (amt,created_at,status,user_id,type,type_id) values(?,now(),0,?,1,-1)',[$amt,$this->user->id]);
				$record_id = DB::select('select LAST_INSERT_ID() as id');

            ##Audit-----
            ##16 = Available Referral GH
            if(session('has_admin_access') == ''){ $edited_by = $this->user->id;}else{$edited_by = session('has_admin_access');}
            $input = "[".floatval($amt)."]";
            Custom::auditTrail($this->user->id, '16', $edited_by, $input);

				$gh_id = 0;
				foreach($record_id as $output)
				{
					$gh_id = $output->id;
				}


				//Self::match($gh_id);

				//update referral status
				//$referral = Referral::find($output->id);
				//$referral->status = 2;
				//$referral->save();
				Referral::where('user_id',$this->user->id)->where('status',1)->update(['status'=> 2]);
			//}
		}
        return back();
    }

    public function postCreateUnilevels()
    {
		$next_trans = Self::get_next_trans_inmin_ingh();
		if ($next_trans > 0)
        {
            abort(500,"Please wait " . $next_trans . " minutes before making next transaction.");
        }
		else
		{
			//$table_unilevels = DB::table('unilevels')->where('user_id',$this->user->id)->where('status',1)->get();
			$amt = Unilevel::where('user_id',$this->user->id)->where('status',1)->sum('amt');
			if($amt <= 0) abort(500,'Invalid GH');

			//foreach($table_unilevels as $output)
			//{
				//insert gh unilevel
				//$gh_id = DB::table('gh')->insertGetId([
				//    'amt'           =>  $amt,
				//    'created_at'    =>  date('Y-m-d H:i:s'),
				//    'status'        =>  0,
				//    'user_id'       =>  $this->user->id,
				//    'type'          =>  2,
				//    'type_id'       =>  -1, //$output->id // if -1 means grouped gh
				//]);

				//DB::select('insert into gh (amt,created_at,status,user_id,type,type_id) values(' . $amt . ',now(),0,' . $this->user->id . ',2,-1)');
				DB::insert('insert into gh (amt,created_at,status,user_id,type,type_id) values(?,now(),0,?,2,-1)',[$amt,$this->user->id]);

            ##Audit-----
            ##17 = Available Unilevel GH
            if(session('has_admin_access') == ''){ $edited_by = $this->user->id;}else{$edited_by = session('has_admin_access');}
            $input = "[".floatval($amt)."]";
            Custom::auditTrail($this->user->id, '17', $edited_by, $input);

				//$record_id = DB::select('select LAST_INSERT_ID() as id');
				//$gh_id = 0;
				//foreach($record_id as $output)
				//{
				//	$gh_id = $output->id;
				//}

				//Self::match($gh_id);

				//update unilevel status
				//$unilevel = Unilevel::find($output->id);
				//$unilevel->status = 2;
				//$unilevel->save();
				Unilevel::where('user_id',$this->user->id)->where('status',1)->update(['status'=> 2]);
			//}
		}
        return back();
    }

    public function postCreateEarnings()
    {
		$next_trans = Self::get_next_trans_inmin_ingh();
		if ($next_trans > 0)
        {
            abort(500,"Please wait " . $next_trans . " minutes before making next transaction.");
        }
		else
		{
			//$table_earnings = DB::table('earnings')->where('user_id',$this->user->id)->where('status',1)->get();
			$amt = Earning::where('user_id',$this->user->id)->where('status',1)->sum('amt');
			if($amt <= 0) abort(500,'Invalid GH');

			//foreach($table_earnings as $output)
			//{
				//insert gh earnings
				//$gh_id = DB::table('gh')->insertGetId([
				//    'amt'           =>  $amt,
				//    'created_at'    =>  date('Y-m-d H:i:s'),
				//    'status'        =>  0,
				//    'user_id'       =>  $this->user->id,
				//    'type'          =>  3,
				//    'type_id'       =>  -1, //$output->id // if -1 means grouped gh
				//]);

				//DB::select('insert into gh (amt,created_at,status,user_id,type,type_id) values(' . $amt . ',now(),0,' . $this->user->id . ',3,-1)');
				DB::insert('insert into gh (amt,created_at,status,user_id,type,type_id) values(?,now(),0,?,3,-1)',[$amt,$this->user->id]);

            ##Audit-----
            ##18 = Available Profit GH
            if(session('has_admin_access') == ''){ $edited_by = $this->user->id;}else{$edited_by = session('has_admin_access');}
            $input = "[".floatval($amt)."]";
            Custom::auditTrail($this->user->id, '18', $edited_by, $input);
				//$record_id = DB::select('select LAST_INSERT_ID() as id');
				//$gh_id = 0;
				//foreach($record_id as $output)
				//{
				//	$gh_id = $output->id;
				//}

				//Self::match($gh_id);

				//update earnings status
				//$earning = Earning::find($output->id);
				//$earning->status = 2;
				//$earning->save();
				Earning::where('user_id',$this->user->id)->where('status',1)->update(['status'=> 2]);

				//reset manager title
				//DB::select('call setManagerTitle('.$this->user->id.')');
				//DB::select('call setManagerTitle('.$this->user->referral_id.')');
				DB::select('call setSponsorTitle2016('.$this->user->id.')');
				DB::select('call setSponsorTitle2016('.$this->user->referral_id.')');

			//}
		}
        return back();
    }

    public function addWalletQueue($from,$to,$amt,$match_id)
    {
        if($from && $to && $amt && $match_id):
        //$queue_id = DB::table('wallet_queues')->insertGetId([
        //    'to'            =>  $to,
        //    'from'          =>  $from,
        //    'created_at'    =>  date('Y-m-d H:i:s'),
        //    'amt'           =>  $amt,
        //    'match_id'      =>  $match_id
        //]);
		//DB::select('insert into wallet_queues (to,from,created_at,amt,match_id) values(\'' . $to . '\',\'' . $from . '\',now(),' . $amt . ',' . $match_id . ')');
		//DB::insert('insert into wallet_queues (`to`,`from`,created_at,amt,match_id) values(\'?\',\'?\',now(),?,?)',[$to,$from,floatval($amt),$match_id]);
		DB::insert('insert into wallet_queues (`to`,`from`,created_at,amt,match_id) values(\'' . trim($to) . '\',\'' . trim($from) . '\',now(),' . $amt . ',' . $match_id . ')');
		$record_id = DB::select('select LAST_INSERT_ID() as id');
		$queue_id = 0;
		foreach($record_id as $output)
		{
			$queue_id = $output->id;
		}

        if($queue_id)
            return 1;
        else
            return 0;
        endif;
    }

    public function sumAllGh()
    {
        return Gh::where('status',2)->sum('amt');
    }

    public function match($gh_id)
    {
        $gh = Gh::where('id',$gh_id)->first();
		//$gh = DB::select('SELECT g.*,w.wallet_address FROM gh g inner join wallets w on g.user_id=w.id where g.id=' . $gh_id . ' limit 1');
        $user_gh = User::where('id',$gh->user_id)->first();
		$wallet = DB::table('wallets')
			->where('id',$gh->user_id)->first();
		$ghaddress = $wallet->wallet_address;

        //FIFO based on ID
		//$ph = Ph::where('status',null)->orwhere('status',0)->orderby('id')->first();
		//FIFO based on created_at
        //$ph = Ph::where('status',null)->orwhere('status',0)->orderby('created_at')->first();
		//FIFO based on selected and created_at

		$gh_unfilled = $gh->amt - $gh->amt_filled;
        $ph_qs = DB::select('select sum(amt-amt_distributed) phq_sum from ph where selected=1 and (`status` is null or `status`=0)');
        foreach($ph_qs as $output)
        {
            $phq_sum = $output->phq_sum;
        }
		if($gh_unfilled>$phq_sum)
		{
            //abort(500,"Not enough PH Queue for distribution.");
		  return "1";
		}
		else
		{
			$ph = Ph::where('selected',1)->where('status',null)->orwhere('status',0)->orderby('created_at')->first();
			//$ph = DB::select('SELECT p.*,w.wallet_address FROM ph p inner join wallets w on p.user_id=w.id where p.selected=1 and (p.status is null or p.status=0) order by p.created_at limit 1');
			$wallet = DB::table('wallets')
				->where('id',$ph->user_id)->first();
			$phaddress = $wallet->wallet_address;

			if(!$ph)
			{
				//abort(500,"No more PH Queue for distribution.");
				return "1";
			}
			else
			{
				if($gh->status == null or $gh->status == 0):
					$ph_distributed  = $ph->amt_distributed;
					$ph_amt          = $ph->amt;
					$ph_unfilled     = $ph_amt - $ph_distributed;
					$gh_filled       = $gh->amt_filled;
					$gh_amt          = $gh->amt;
					$gh_unfilled     = $gh_amt - $gh_filled;

					if(round($ph_distributed,8) < round($ph_amt,8)):
						if($ph_unfilled > $gh_unfilled):
							//insert match
							//$match_id = DB::table('matches')->insertGetId([
							//    'ph_id'         =>  $ph->id,
							//    'gh_id'         =>  $gh->id,
							//    'created_at'    =>  date('Y-m-d H:i:s'),
							//    'amt'           =>  $gh_unfilled
							//]);
							//DB::select('insert into matches (ph_id,gh_id,created_at,amt) values(' . $ph->id . ',' . $gh->id . ',now(),' . $gh_unfilled . ')');
							DB::insert('insert into matches (ph_id,gh_id,created_at,amt) values(?,?,now(),?)',[$ph->id,$gh->id,$gh_unfilled]);
							$record_id = DB::select('select LAST_INSERT_ID() as id');
							$match_id = 0;
							foreach($record_id as $output)
							{
								$match_id = $output->id;
							}

							//update gh status and filled
							DB::table('gh')
								->where('id',$gh->id)
								->update([
									"status" => 2,
									"amt_filled" => $gh_amt
							]);

							//update ph increment filled
							DB::table('ph')
								->where('id',$ph->id)
								->increment("amt_distributed",$gh_unfilled);

							//add to wallet queue
							Self::addWalletQueue($phaddress,$ghaddress,$gh_unfilled,$match_id);
						endif;

						if(round($ph_unfilled,8) < round($gh_unfilled,8)):
							//insert match
							//$match_id = DB::table('matches')->insertGetId([
							//    'ph_id'         =>  $ph->id,
							//    'gh_id'         =>  $gh->id,
							//    'created_at'    =>  date('Y-m-d H:i:s'),
							//    'amt'           =>  $ph_unfilled
							//]);
							//DB::select('insert into matches (ph_id,gh_id,created_at,amt) values(' . $ph->id . ',' . $gh->id . ',now(),' . $ph_unfilled . ')');
							DB::insert('insert into matches (ph_id,gh_id,created_at,amt) values(?,?,now(),?)',[$ph->id,$gh->id,$ph_unfilled]);
							$record_id = DB::select('select LAST_INSERT_ID() as id');
							$match_id = 0;
							foreach($record_id as $output)
							{
								$match_id = $output->id;
							}

							//update ph status and filled
							DB::table('ph')
								->where('id',$ph->id)
								->update([
									"status" => 1,
									"amt_distributed" => $ph_amt
							]);

							//update gh increment filled
							DB::table('gh')
								->where('id',$gh->id)
								->increment("amt_filled",$ph_unfilled);

							//add to wallet queue
							Self::addWalletQueue($phaddress,$ghaddress,$ph_unfilled,$match_id);

							//gh not complete so do again
							Self::match($gh_id);
						endif;

						if(round($ph_unfilled,8) == round($gh_unfilled,8)):
							//insert match
							//$match_id = DB::table('matches')->insertGetId([
							//    'ph_id'         =>  $ph->ph_id,
							//    'gh_id'         =>  $gh->gh_id,
							//    'created_at'    =>  date('Y-m-d H:i:s'),
							//    'amt'           =>  $ph_unfilled
							//]);
							//DB::select('insert into matches (ph_id,gh_id,created_at,amt) values(' . $ph->ph_id . ',' . $gh->gh_id . ',now(),' . $ph_unfilled . ')');
							DB::insert('insert into matches (ph_id,gh_id,created_at,amt) values(?,?,now(),?)',[$ph->id,$gh->id,$ph_unfilled]);
							$record_id = DB::select('select LAST_INSERT_ID() as id');
							$match_id = 0;
							foreach($record_id as $output)
							{
								$match_id = $output->id;
							}


							//update ph will complete
							DB::table('ph')
								->where('id',$ph->id)
								->update([
									"status" => 1,
									"ph_distributed" => $ph_amt
							]);

							//update gh will complete
							DB::table('gh')
								->where('id',$gh->id)
								->update([
									"status" => 2,
									"amt_filled" => $gh_amt
							]);

							//add to wallet queue
							Self::addWalletQueue($phaddress,$ghaddress,$ph_unfilled,$match_id);
						endif;
					else:
						DB::table('ph')
						->where('id',$ph->id)
						->update(["status" => 1]);
					endif; //ph filled < ph amt
				endif; //gh complete 0

            $match_type = array('1'=>'referrals','2'=>'unilevels','3'=>'earnings');

            ##Audit-----
            ##24 = Match Earnings/Referrals/Unilevels
            if(session('has_admin_access') == ''){ $edited_by = $this->user->id;}else{$edited_by = session('has_admin_access');}
            $input = "[".$gh->amt."][".$gh->user_id."-".$user_gh->username."][".$match_type[$gh->type]."]";
            Custom::auditTrail($this->user->id, '24', $edited_by, $input);

				return back();
			}
		}
    }

    public function get_next_trans_inmin_ingh()
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
