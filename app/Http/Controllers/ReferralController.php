<?php
namespace App\Http\Controllers;

use Auth;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use App\User;
use App\Unilevel;
use App\Referral;

class ReferralController extends Controller
{	    
    private $user;

    public function __construct()
    {    	
    	$this->user = Auth::user();
    }

    public function getIndex()
    {
    	$referrals = User::where('referral_id',$this->user->id)
            ->where(function($query) {
                $query->where('ph.status',null)->orwhere('ph.status','<>',2);
            })
            ->leftjoin('ph','ph.user_id','=','users.id')            
            ->get();

        $referrals_inactive = User::where('referral_id',$this->user->id)
            ->where('ph.status',2)
            ->join('ph','ph.user_id','=','users.id')            
            ->get();            

    	return view('referral_table')
    		->with('user',$this->user)
    		->with('referrals',$referrals)
            ->with('referrals_inactive',$referrals_inactive);
    }

    public function getReferrals(Request $request)
    {
        $user = DB::table('users')->where('username',$request->username)->first();

        if(!strstr($user->gene,$this->user->gene)) abort(500,'Not allowed');

        $referrals = User::where('referral_id',$user->id)
            ->where(function($query) {
                $query->where('ph.status',null)->orwhere('ph.status','<>',2);
            })
            ->leftjoin('ph','ph.user_id','=','users.id')            
            ->get();

        $referrals_inactive = User::where('referral_id',$user->id)
            ->where('ph.status',2)
            ->join('ph','ph.user_id','=','users.id')            
            ->get();            

        return view('referral_table')
            ->with('user',$this->user)
            ->with('referrals',$referrals)
            ->with('referrals_inactive',$referrals_inactive);
    }

    public function referralRate()
    {
        $upline = User::find($this->user->referral_id);
        return $upline->levelReferral->referral_rate / 100;
    }

    public function referralAmt($ph_amt)
    {
        $referral_rate = Self::referralRate();
        return round($ph_amt * $referral_rate,7);
    }

    public function addReferralBonus($ph_id,$net_ph_amt)
    {
        $ph = DB::table('ph')
            ->where('id',$ph_id)
            ->first();

        //$referral_amt = Self::referralAmt($ph->amt);
        $referral_amt = Self::referralAmt($net_ph_amt);

        //DB::table('referrals')->insert([
        //    'created_at'        => date('Y-m-d H:i:s'),
        //    'amt'               => $referral_amt,
        //    'user_id'           => $this->user->referral_id,
        //    'referral_user_id'  => $this->user->id,
        //    'ph_id'             => $ph->id,
        //    'status'            => 0
        //]);

		DB::insert('insert into referrals (created_at,amt,user_id,referral_user_id,ph_id,status) values(now(),?,?,?,?,0)',[$referral_amt,$this->user->referral_id,$this->user->id,$ph->id]);
    }

    public function sumReferralBonus($user_id)
    {
        return DB::table('referrals')
            ->where('user_id',$user_id)
            ->sum('amt');
    }

    public function getReferralBonus()
    {
        //$referrals = Referral::where('user_id',$this->user->id)->orderby('created_at','desc')->get();

		$SQLStr = "select u.created_at,r.name,r.username,u.amt,p.amt pamt ";
		$SQLStr = $SQLStr . " from referrals u inner join ph p on u.ph_id=p.id ";
		$SQLStr = $SQLStr . " inner join users r on u.referral_user_id=r.id ";
		$SQLStr = $SQLStr . " where u.user_id=" . $this->user->id . " order by u.created_at desc ";

		$referrals = DB::select($SQLStr);

        return view('referral_bonus')
            ->with('referrals',$referrals)
            ->with('user',$this->user);
    }

    public function addUnilevelBonus($ph_id,$user_id,$level,$net_ph_amt)
    {

        $ph = DB::table('ph')
            ->where('id',$ph_id)
            ->first();

        $referral_rate = app('App\Http\Controllers\UserController')->getUserUnilevelRate($user_id,$level);

        //$referral_amt = round($referral_rate/100 * $ph->amt,8);
        $referral_amt =  round($referral_rate/100 * $net_ph_amt,8); 

		if($user_id==1)
		{
			//do nothing
		}
		else
		{
			//DB::table('unilevels')->insert([
			//	'created_at'        => date('Y-m-d H:i:s'),
			//	'amt'               => $referral_amt,
			//	'user_id'           => $user_id,
			//	'referral_user_id'  => $this->user->id,
			//	'ph_id'             => $ph->id,
			//	'status'            => 0
			//]);
			DB::insert('insert into unilevels (created_at,amt,user_id,referral_user_id,ph_id,status) values(now(),?,?,?,?,0)',[$referral_amt,$user_id,$ph->user_id,$ph->id]);
		}
    }

    public function processUnilevelBonus($ph_id,$gene,$net_ph_amt)
    {
        $max_level = 12;
        
        $ph = DB::table('ph')
            ->where('id',$ph_id)
            ->first();

        $array = explode(',',$gene);
        rsort($array);
        array_shift($array);

        $l=1;
        foreach($array as $output)
        {
            $rate = app('App\Http\Controllers\UserController')->getUserUnilevelRate($output,$l);
            
            if($rate)
            {
                Self::addUnilevelBonus($ph_id,$output,$l,$net_ph_amt);
                if($l==$max_level) break;
                $l++;
            }                        
        }
    }

    public function sumUnilevelBonus($user_id)
    {
        return DB::table('unilevels')
            ->where('user_id',$user_id)
            ->sum('amt');
    }

    public function getUnilevelBonus()
    {
        //$referrals = Unilevel::where('user_id',$this->user->id)->orderby('created_at','desc')->get();
        
		$SQLStr = "select u.created_at,r.name,r.username,u.amt,p.amt pamt ";
		$SQLStr = $SQLStr . " from unilevels u inner join ph p on u.ph_id=p.id ";
		$SQLStr = $SQLStr . " inner join users r on u.referral_user_id=r.id ";
		$SQLStr = $SQLStr . " where u.user_id=" . $this->user->id . " order by u.created_at desc ";

		$referrals = DB::select($SQLStr);

        return view('unilevel_bonus')
            ->with('referrals',$referrals)
            ->with('user',$this->user);
    }

    public function apiReferralsList(Request $request)
    {
        $data = User::where('referral_id',$request->id)->get();
        return response()->json($data, 200, array(), JSON_PRETTY_PRINT);
    }

    public function get_next_trans_inmin_inreferral()
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