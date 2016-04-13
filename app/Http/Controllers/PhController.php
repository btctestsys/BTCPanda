<?php
namespace App\Http\Controllers;

use Auth;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use App\User;
use Crypt;
use Carbon\Carbon;
use App\Match;
use App\Earning;
use App\Referral;
use App\Unilevel;
use App\Ph;

class PhController extends Controller
{
    private $user;

    public function __construct()
    {
    	$this->user = Auth::user();
    }

    public function getIndex()
    {
      #Check Setting
      $uid = $this->user->id;
      $query = "SELECT `country`, `mobile`, `wallet1` FROM users WHERE id = '$uid'";
		$check = DB::select($query);

      if($check['0']->mobile == '' or $check['0']->country == '' or $check['0']->wallet1 == ''){
         return redirect("/settings");
      }


    	//$ph = DB::table('ph')->where('user_id',$this->user->id)->where(function($query) {$query->where('status',null)->orwhere('status','<>',2);})->orderby('created_at','desc')->get();
		//ddifc - ceiling day difference, ddiff - floor day difference, hdif - remaining hours difference, htotal - total hours difference
		//$ph = DB::select('SELECT p.id,p.`status`,p.created_at, p.user_id, p.amt, p.amt_distributed,l.ph_limit,l.ph_limit - getphactive(p.user_id) phleft,time_format(timediff(date_add(now(),interval 0 day),p.created_at),\'%H\') htotal,floor(time_format(timediff(date_add(now(),interval 0 day),p.created_at),\'%H\')/24) ddiff,ceiling(time_format(timediff(date_add(now(),interval 0 day),p.created_at),\'%H\')/24) ddifc,time_format(timediff(date_add(now(),interval 0 day),p.created_at),\'%H\')-floor(time_format(timediff(date_add(now(),interval 0 day),p.created_at),\'%H\')/24)*24 hdif FROM ph p inner join users u on p.user_id=u.id left join level_referrals l on u.level_referral_id=l.id where p.user_id=? and (p.`status` is null or p.`status`<>2) order by p.created_at desc',[$this->user->id]);
		$ph = DB::select('SELECT p.id,p.`status`,p.created_at, p.user_id, p.amt, p.amt_distributed,l.ph_limit,l.ph_limit - getphactive(p.user_id) phleft,time_format(timediff(date_add(now(),interval 0 day),p.created_at),\'%H\') htotal,datediff(now(),p.created_at) ddiff,if(datediff(now(),p.created_at)+1>90,90,datediff(now(),p.created_at)+1) ddifc,hour(now())+1 hdif FROM ph p inner join users u on p.user_id=u.id left join level_referrals l on u.level_referral_id=l.id where p.user_id=? and (p.`status` is null or p.`status`<>2) order by p.created_at desc',[$this->user->id]);

        $ph_ended = DB::table('ph')
            ->where('user_id',$this->user->id)
            ->where('status',2)
            ->orderby('created_at','desc')
            ->get();

        foreach($ph as $output)
        {
            //add gh user list to ph
            $gh_users = Match::where('ph_id',$output->id)->get();

            $gh_users_list = array();

            foreach($gh_users as $output2)
            {
                $gh_users_list[] .= '<i class="fa fa-bitcoin"></i> '.$output2->amt.' <a target="_blank" href="http://blockchain.info/address/'.$output2->gh->user->wallet->wallet_address.'">'.$output2->gh->user->username.' ('.$output2->gh->user->country.')</a>';
            }

            $output->gh_users_list = $gh_users_list;

            //include earnings to ph and calculate how much taken from `earnings`
			$earning_days = Carbon::parse($output->created_at)->diffInDays() + 1;
			if ($earning_days > 90) {$earning_days=90;}
            @$earnings_claimed = Earning::where('user_id',$this->user->id)->where('ph_id',$output->id)->sum('amt');
            $output->earnings = round((($output->ddifc) * 0.01 * $output->amt)-$earnings_claimed,8);
            $output->earnings_claimed = @$earnings_claimed;
            $output->days = $earning_days;

            //reset back for next loop
            @$earnings_claimed = 0;
        }

        foreach($ph_ended as $output)
        {
            //add gh user list to ph
            $gh_users = Match::where('ph_id',$output->id)->get();

            $gh_users_list = array();

            foreach($gh_users as $output2)
            {
                $gh_users_list[] .= '<i class="fa fa-bitcoin"></i> '.$output2->amt.' <a target="_blank" href="http://blockchain.info/address/'.$output2->gh->user->wallet->wallet_address.'">'.$output2->gh->user->username.' ('.$output2->gh->user->country.')</a>';
            }

            $output->gh_users_list = $gh_users_list;

            //include earnings to ph and calculate how much taken from `earnings`
			$earning_days = Carbon::parse($output->created_at)->diffInDays();
			if ($earning_days > 90) {$earning_days=90;}
            @$earnings_claimed = Earning::where('user_id',$this->user->id)->where('ph_id',$output->id)->sum('amt');
            $output->earnings = round(($earning_days * 0.01 * $output->amt)-$earnings_claimed,8);
            $output->earnings_claimed = @$earnings_claimed;
            $output->days = $earning_days;

            //reset back for next loop
            @$earnings_claimed = 0;
        }

        //other things to calculate
        $ph_left = app('App\Http\Controllers\UserController')->getUserPhLeft($this->user->id);

		$walletqueue_history = DB::select('select created_at,`from`,`to`,amt,match_id,if(match_id=0,\'SEND\',\'GH\') typ,`status`,json from wallet_queues where `from`=\'' . $this->user->wallet->wallet_address . '\' order by id desc limit 100');

        return view('ph')
            ->with('walletqueue_history',$walletqueue_history)
            ->with('ph_left',$ph_left)
            ->with('user',$this->user)
    		->with('ph_ended',$ph_ended)
            ->with('ph',$ph);
    }

    public function postCreate(Request $request)
    {
		$next_trans = Self::get_next_trans_inmin_inph();
		if ($next_trans > 0)
        {
            abort(500,"Please wait " . $next_trans . " minutes before making next transaction.");
        }
		else
		{
			//update wallet first
			app('App\Http\Controllers\WalletController')->updateWallet();

			if($request->amt >= 0.1)
			{
				if(round(app('App\Http\Controllers\WalletController')->checkAvailableBalance($this->user->id),8) >= round($request->amt,8))
				{
					if(app('App\Http\Controllers\UserController')->getUserPhLeft($this->user->id) >= $request->amt)
					{
						$bamboo_required = app('App\Http\Controllers\BambooController')->BambooRequired($request->amt);
						$bamboo_check = app('App\Http\Controllers\BambooController')->BambooCheck($this->user->id,$bamboo_required);

						if($bamboo_check)
						{
							//insert ph
							//$ph_id = DB::table('ph')->insertGetId([
                    		//	'created_at'    =>  date('Y-m-d H:i:s'),
                    		//	'amt'			=>	$request->amt,
                    		//	'user_id'		=>	$this->user->id,
                			//]);

							DB::insert('insert into ph (created_at,amt,user_id) values(now(),' . floatval($request->amt) . ',' . $this->user->id . ')');
							$record_id = DB::select('select LAST_INSERT_ID() as id');
							$ph_id = 0;
							foreach($record_id as $output)
							{
								$ph_id = $output->id;
							}

							$notes = "PH ".$ph_id;

							//deduct bamboos
							app('App\Http\Controllers\BambooController')->deductBamboo($bamboo_required,$notes);

							//get amount that eligible for upline bonuses
							$current_ph = DB::select('select getPHCold(?,?) as amt',[$this->user->id,$request->amt]);
							foreach($current_ph as $output)
							{
								$net_ph_amt = $output->amt;
							}

							DB::select('call setSponsorTitle2016('.$this->user->id.')');
							DB::select('call setSponsorTitle2016('.$this->user->referral_id.')');

							//add referal bonus
							app('App\Http\Controllers\ReferralController')->addReferralBonus($ph_id,$net_ph_amt);

							//add unilevel bonus
							//deferred to daily
							//app('App\Http\Controllers\ReferralController')->processUnilevelBonus($ph_id,$this->user->gene,$net_ph_amt);

							//reset manager title
							//DB::select('call setManagerTitle('.$this->user->id.')');
							//DB::select('call setManagerTitle('.$this->user->referral_id.')');

                			return redirect("/provide_help");
						}
						else
						{
							return abort(500,"Insufficient Pin");
						}
					}
					else
					{
						return abort(500,"Insufficient PH Quota.");
					}
				}
				else
				{
					return abort(500,"Insufficient Wallet Balance");
				}
			}
			else
			{
				return abort(500,"PH must be 0.1 or more.");
			}
        }
    }

    public function phMax($user_id)
    {
        return (15 - Self::sumPhActive($user_id));
    }

    public function sumAllPhActive()
    {
        return Ph::where('status',null)->orwhere('status','<>',2)->sum('amt');
    }

    public function sumAllPhSelected()
    {
		$ph = DB::select('select sum(amt) amt from ph where selected=1 and `status` is null ');
        //return Ph::where('selected',1)andwhere('status',null)->orwhere('status','<>',2)->sum('amt');

        foreach($ph as $output)
        {
            $phsel = $output->amt;
        }

        return $phsel;
    }

    public function sumPhActive()
    {
        return DB::table('ph')
            ->where('user_id',$this->user->id)
            ->where(function($query) {
                $query->where('status',null)->orwhere('status',0)->orwhere('status',1);
            })
            ->sum('amt');
    }

    public function sumPhActiveDistributed()
    {
        return DB::table('ph')
            ->where('user_id',$this->user->id)
            ->where(function($query) {
                $query->where('status',null)->orwhere('status',0)->orwhere('status',1);
            })
            ->sum('amt_distributed');
    }

    public function currentEarnings()
    {
        $current_earnings = 0;

        $ph = DB::table('ph')
            ->where('user_id',$this->user->id)
            ->where(function($query) {
                $query->where('status',null)->orwhere('status','<>',2);
            })
            ->get();

        foreach($ph as $output)
        {
            $current_earnings += Carbon::parse($output->created_at)->diffInDays() * $output ->amt * 0.01;
        }

        return $current_earnings;
    }

    public function getDSV()
    {
        $dsv = 0;
		$ph = DB::select('select sum(getPHActive(id)) as activedownlinePH from users where referral_id=' . $this->user->id);

        foreach($ph as $output)
        {
            $dsv = $output->activedownlinePH;
        }

        return $dsv;
    }

    public function postClaimEarnings(Request $request)
    {
		$next_trans = Self::get_next_trans_inmin_inph();
		if ($next_trans > 0)
        {
            abort(500,"Please wait " . $next_trans . " minutes before making next transaction.");
        }
		else
		{
			try
			{
				//decrypt data
				$data     = Crypt::decrypt($request->hidden);
				$data     = explode('~',$data);
				$ph_id    = $data[0];
				$amt      = $data[1];
				@$all      = @$data[2];
			}
			catch(\Exception $e)
			{
				abort(500,'Invalid Data');
			}

			//check bamboo
			$bamboo_required = app('App\Http\Controllers\BambooController')->BambooRequired($amt);
			$bamboo_check = app('App\Http\Controllers\BambooController')->BambooCheck($this->user->id,$bamboo_required);
			$notes = "PH (Claim) ".$ph_id;

			//check minimum amt gh earnings
			if($amt > 0 && $bamboo_check)
			{
				//to prevent double entry
				$check = Earning::where('user_id',$this->user->id)->where('status',1)->count();

				if($check)
				{
					abort(500,'Previous claim not yet GH.');
				}
				else
				{
					//insert earnings
					//DB::table('earnings')->insert([
					//    'user_id'       => $this->user->id,
					//    'ph_id'         => $ph_id,
					//    'created_at'    => date('Y-m-d H:i:s'),
					//    'amt'           => $amt,
					//    'status'        => 1,
					//]);
					DB::insert('insert into earnings (user_id,ph_id,created_at,amt,status) values(' . $this->user->id . ',' . $ph_id . ',now(),' . floatval($amt) . ',1)');

					//deduct bamboos
					app('App\Http\Controllers\BambooController')->deductBamboo($bamboo_required,$notes);

					//end ph if gh all
					if($all)
					{
						$ph = Ph::find($ph_id);
						$ph->status = 2;
						$ph->save();

						$track_gh = DB::select('call set_TrackGHHot(?,?)',[$this->user->id,$ph_id]);
					}
				}
			}
			else
			{
				abort(500,'Insufficient Pin');
			}
        }

        return back();
    }

    public function get_next_trans_inmin_inph()
    {
		$next_wait = DB::select('select check_next_trans_inminutes(' . $this->user->id . ') waittime; ');
        $next_wait_time = 0;
		foreach($next_wait as $output)
        {
			$next_wait_time = $output->waittime;
        }
		return $next_wait_time;
    }

    public function doCheckBeforePH(Request $request){

      return 0;
   }
}
