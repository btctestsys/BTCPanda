<?php
namespace App\Http\Controllers;

use Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\WalletController;
use DB;
use Illuminate\Http\Request;
use App\User;
use App\Classes\Custom;
use App\Earning;
use App\Referral;
use App\Unilevel;
use App\Gh;
use App\Ph;

class AdminController extends Controller
{	    
    private $user;

    public function __construct()
    {    	
    	$this->user = Auth::user();
    }

    public function login($id)
    {
    	Auth::loginUsingId($id);
    	return redirect('/dashboard');
    }

    public function viewtree($id)
    {
    	Auth::loginUsingId($id);
    	return redirect('/unitree');
    }

    public function getDashboard()
    {
		$SQLStr="SELECT w.created_at, w.`from`, w.`to`, w.amt,if(w.match_id>0,'GH','SEND') typ,u1.id u1id,u1.username u1username,u2.id u2id,u2.username u2username ";
		$SQLStr=$SQLStr . " FROM wallet_queues w left join wallets w1 on w.`from`=w1.wallet_address left join users u1 on w1.id=u1.id ";
		$SQLStr=$SQLStr . " left join wallets w2 on w.`to`=w2.wallet_address left join users u2 on w2.id=u2.id ";
		$SQLStr=$SQLStr . " where `status`=0 or `status` is null ";
		$pendingQ = DB::select($SQLStr);

		$statMth = DB::select('select left(monthname(now()),3) m1,left(monthname(date_add(now(), interval -1 month)),3) m2,left(monthname(date_add(now(), interval -2 month)),3) m3');
        foreach($statMth as $output)
        {
            @$m1 = $output->m1;            
            @$m2 = $output->m2;            
            @$m3 = $output->m3;            
        }

		$statPH = DB::select('select u.country,c.country cname,sum(amt) totalph, sum(if((`status` is null or `status`<>2) and DATE_FORMAT(now(),\'%Y%m\')=DATE_FORMAT(p.created_at,\'%Y%m\'),amt,0)) aphm1, sum(if((`status` is null or `status`<>2) and DATE_FORMAT(date_add(now(), interval -1 month),\'%Y%m\')=DATE_FORMAT(p.created_at,\'%Y%m\'),amt,0)) aphm2, sum(if((`status` is null or `status`<>2) and DATE_FORMAT(date_add(now(), interval -2 month),\'%Y%m\')=DATE_FORMAT(p.created_at,\'%Y%m\'),amt,0)) aphm3, sum(if(`status` is null or `status`<>2,amt,0)) activeph from users u inner join ph p on u.id=p.user_id left join country c on u.country=c.code group by u.country;');
        foreach($statPH as $output)
        {
            @$totalph = $output->totalph;            
            @$moneybox = $output->moneybox;            
            @$totalactive = $output->totalactive;            
            @$activeph = $output->activeph;            
        }

		$stat = DB::select('select sum(amt) totalph,sum(if(`status` is null or `status`<>2,amt,0)) activeph,sum(if(`status` is null or `status`<>2,1,0)) totalactive,sum(amt-amt_distributed) moneybox from users u inner join ph p on u.id=p.user_id;');
        foreach($stat as $output)
        {
            @$totalph = $output->totalph;            
            @$moneybox = $output->moneybox;            
            @$totalactive = $output->totalactive;            
            @$activeph = $output->activeph;            
        }

		$stat = DB::select('select sum(amt) totalgh from gh;');
        foreach($stat as $output)
        {
            @$totalgh = $output->totalgh;            
        }
        
		$stat = DB::select('select sum(current_balance) current_balance from wallets;');
        foreach($stat as $output)
        {
            @$current_balance = $output->current_balance;            
            @$available_balance = $output->current_balance - @$activeph;            
        }
        
		$LastOpenQ = app('App\Http\Controllers\UserController')->getLastOpenQ();

		return view('admin.dashboard')
            ->with('LastOpenQ',$LastOpenQ)
            ->with('pendingQ',$pendingQ)
            ->with('statPH',$statPH)
            ->with('m1',$m1)
            ->with('m2',$m2)
            ->with('m3',$m3)
            ->with('totalph',$totalph)
            ->with('totalgh',$totalgh)
            ->with('moneybox',$moneybox)
            ->with('totalactive',$totalactive)
            ->with('activeph',$activeph)
            ->with('current_balance',$current_balance)
            ->with('available_balance',$available_balance)
			->with('user',$this->user);
    }

    public function getUserListAll(Request $request)
    {
        //$users = DB::table('users')->select('id','email','username','name','bamboo_balance','level_id','country')->orderby('created_at','desc')->get();
		$users = DB::select('SELECT u.id, u.email, u.username, u.name, u.bamboo_balance, u.level_id, u.country,s.id sid,s.username susername,s1.id sid1,s1.username susername1,getPHActive(u.id) uph,getPHActive(s.id) sph,getPHActive(s1.id) sph1 FROM users u left join users s on u.referral_id=s.id left join users s1 on s.referral_id=s1.id order by u.id desc limit 10');

        return view('admin.usersall')
            ->with('request',$request)
            ->with('users',$users)
            ->with('user',$this->user);
    }

    public function getUserList(Request $request)
    {
		$typ = $request->typ;
		if ($typ!='all'){$querylimit=' limit 10 ';}else{$querylimit='';}
		$country = $request->country;
		$tbname = $request->tbname;
		$tbuname = $request->tbuname;
		$tbwallet = $request->tbwallet;
		$tbmobile = $request->tbmobile;
		//$tbemail = $request->tbemail;
		$query=' u.username<>\'\' ';
		if ($tbname!=''){if ($query!='') {$query= $query . ' and ';}$query= $query . ' u.`name` like \'%' . $tbname . '%\' ';}
		if ($tbuname!=''){if ($query!='') {$query= $query . ' and ';}$query= $query .' u.`username` like \'%' . $tbuname . '%\' ';}
		if ($tbwallet!=''){if ($query!='') {$query= $query . ' and ';} $query= $query .' w.`wallet_address` like \'%' . $tbwallet . '%\' ';}
		if ($tbmobile!=''){if ($query!='') {$query= $query . ' and ';} $query= $query .' u.`mobile` like \'%' . $tbmobile .'%\' ';}
		if ($country!=''){if ($query!='') {$query= $query . ' and ';} $query= $query .' u.`country` = \'' . $country .'\' ';}
		if ($query!='')
		{
			$query=' where ' . $query;
			$users = DB::select('SELECT u.id, u.email, u.username, u.name, u.mobile, u.bamboo_balance, u.level_id, u.country,s.id sid,s.username susername,s1.id sid1,s1.username susername1,getPHActive(u.id) uph,getPHActive(s.id) sph,getPHActive(s1.id) sph1,w.wallet_address FROM users u left join wallets w on u.id=w.user_id left join users s on u.referral_id=s.id left join users s1 on s.referral_id=s1.id ' . $query . ' order by u.id desc ' . $querylimit);
		}
		else
		{
			$users = DB::select('SELECT u.id, u.email, u.username, u.name, u.mobile, u.bamboo_balance, u.level_id, u.country,s.id sid,s.username susername,s1.id sid1,s1.username susername1,getPHActive(u.id) uph,getPHActive(s.id) sph,getPHActive(s1.id) sph1,w.wallet_address FROM users u left join wallets w on u.id=w.user_id left join users s on u.referral_id=s.id left join users s1 on s.referral_id=s1.id order by u.id desc ' . $querylimit);
		}

        //$users = DB::table('users')->select('id','email','username','name','bamboo_balance','level_id','country')->orderby('created_at','desc')->get();

		//return $users;
        return view('admin.users')
            ->with('request',$request)
            ->with('users',$users)
            ->with('user',$this->user);
    }

    public function getBamboos()
    {
        $bamboos = DB::table('bamboos')->orderby('created_at','desc')
            ->where('from',1)
            ->get();

        return view('admin.bamboo')
            ->with('bamboos',$bamboos)
            ->with('user',$this->user);
    }

    public function getBamboosDaily()
    {
        $bamboos = DB::table('bamboos')
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y%m%d') as date,sum(amt) as pins"))
            ->where('from',1)
            ->groupby('date')
            ->orderby('date','desc')
            ->get();

        return view('admin.bamboo_daily')
            ->with('bamboos',$bamboos)
            ->with('user',$this->user);
    }
    public function getPh()
    {
        //$ph = DB::table('ph')->orderby('created_at','desc')->get();
		$ph = DB::select('SELECT p.created_at, p.user_id, u.username, s.id sid, s.username susername, p.amt, p.amt_distributed,datediff(now(),p.created_at)+1 ddif FROM ph p left join users u on p.user_id=u.id left join users s on u.referral_id=s.id where p.status is null order by p.created_at desc');

        return view('admin.ph')
            ->with('ph',$ph)
            ->with('user',$this->user);
    }

    public function getPhDaily()
    {
        $ph = DB::table('ph')
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y%m%d') as date,sum(amt) as total_ph"))            
            ->groupby('date')
            ->orderby('date','desc')
            ->get();

        return view('admin.ph_daily')
            ->with('ph',$ph)
            ->with('user',$this->user);
    }

    public function getApprovalEarnings()
    {
        //$earnings = Earning::where('status',0)->orwhere('status',null)->get();
		$earnings = DB::select('SELECT e.id, e.created_at, e.user_id, u.username,s.id sid,s.username susername, e.amt,s1.id sid1,s1.username susername1,getPHActive(u.id) uph,getPHActive(s.id) sph,getPHActive(s1.id) sph1 FROM earnings e left join users u on e.user_id=u.id left join users s on u.referral_id=s.id left join users s1 on s.referral_id=s1.id where e.`status` is null or e.`status`=0');
        return view('admin.approve_earnings')->with('earnings',$earnings)->with('user',$this->user);
    }

    public function getApprovalReferrals()
    {
        //$referrals = Referral::where('status',0)->orwhere('status',null)->get();
		$referrals = DB::select('SELECT e.id, e.created_at, e.user_id, u.username,s.id sid,s.username susername, e.amt,s1.id sid1,s1.username susername1,getPHActive(u.id) uph,getPHActive(s.id) sph,getPHActive(s1.id) sph1 FROM referrals e left join users u on e.user_id=u.id left join users s on u.referral_id=s.id left join ph p on e.ph_id=p.id left join users s1 on p.user_id=s1.id where e.`status` is null or e.`status`=0');

        return view('admin.approve_referrals')->with('referrals',$referrals)->with('user',$this->user);
    }

    public function getApprovalUnilevels()
    {
        //$unilevels = Unilevel::where('status',0)->orwhere('status',null)->get();
		$unilevels = DB::select('SELECT e.id, e.created_at, e.user_id, u.username,s.id sid,s.username susername, e.amt,s1.id sid1,s1.username susername1,getPHActive(u.id) uph,getPHActive(s.id) sph,getPHActive(s1.id) sph1 FROM unilevels e left join users u on e.user_id=u.id left join users s on u.referral_id=s.id left join ph p on e.ph_id=p.id left join users s1 on p.user_id=s1.id where e.`status` is null or e.`status`=0');
        return view('admin.approve_unilevels')->with('unilevels',$unilevels)->with('user',$this->user);
    }

    public function postApproveReferral(Request $request)
    {
        $referral = Referral::find($request->id);
        $referral->status = 1;
        $referral->save();
        return back();
    }

    public function postApproveUnilevel(Request $request)
    {
        $referral = Unilevel::find($request->id);
        $referral->status = 1;
        $referral->save();
        return back();
    }

    public function postApproveEarning(Request $request)
    {
        $referral = Earning::find($request->id);
        $referral->status = 1;
        $referral->save();
        return back();
    }

    public function getApprovalMatch(Request $request)
    {
        //if($request->type == 'all') $matches = Gh::where('status',0)->orwhere('status',null)->get();
        //if($request->type == 'referrals') $matches = Gh::where('status',0)->where('type',1)->get();
        //if($request->type == 'unilevels') $matches = Gh::where('status',0)->where('type',2)->get();
        //if($request->type == 'earnings') $matches = Gh::where('status',0)->where('type',3)->get();

		if($request->type == 'all') {
			$matches = DB::select('SELECT e.id, e.created_at, e.user_id, u.username,s.id sid,s.username susername,s1.id sid1,s1.username susername1,getPHActive(u.id) uph,getPHActive(s.id) sph,getPHActive(s1.id) sph1, e.amt, e.`type`,datediff(now(),e.created_at) ddiff,datediff(now(),e.created_at)+1 ddifc FROM gh e left join users u on e.user_id=u.id left join users s on u.referral_id=s.id left join users s1 on s.referral_id=s1.id where e.`status` is null or e.`status`=0');
			$matches_sum = DB::select('SELECT sum(if(datediff(now(),e.created_at)-1=1,e.amt,0)) sd1, sum(if(datediff(now(),e.created_at)-1=2,e.amt,0)) sd2, sum(if(datediff(now(),e.created_at)-1=3,e.amt,0)) sd3, sum(if(datediff(now(),e.created_at)-1=4,e.amt,0)) sd4, sum(if(datediff(now(),e.created_at)-1=5,e.amt,0)) sd5, sum(if(datediff(now(),e.created_at)-1=6,e.amt,0)) sd6, sum(if(datediff(now(),e.created_at)-1=7,e.amt,0)) sd7, sum(if(datediff(now(),e.created_at)-1=8,e.amt,0)) sd8, sum(if(datediff(now(),e.created_at)-1=9,e.amt,0)) sd9, sum(if(datediff(now(),e.created_at)-1=10,e.amt,0)) sd10, sum(if(datediff(now(),e.created_at)-1=11,e.amt,0)) sd11, sum(if(datediff(now(),e.created_at)-1=12,e.amt,0)) sd12, sum(if(datediff(now(),e.created_at)-1=13,e.amt,0)) sd13, sum(if(datediff(now(),e.created_at)-1=14,e.amt,0)) sd14, sum(if(datediff(now(),e.created_at)-1=15,e.amt,0)) sd15, sum(if(datediff(now(),e.created_at)-1=16,e.amt,0)) sd16, sum(if(datediff(now(),e.created_at)-1=17,e.amt,0)) sd17, sum(if(datediff(now(),e.created_at)-1=18,e.amt,0)) sd18, sum(if(datediff(now(),e.created_at)-1=19,e.amt,0)) sd19, sum(if(datediff(now(),e.created_at)-1>=20,e.amt,0)) sd20 FROM gh e where e.`status` is null or e.`status`=0');
		}
		if($request->type == 'referrals') {
			$matches = DB::select('SELECT e.id, e.created_at, e.user_id, u.username,s.id sid,s.username susername,s1.id sid1,s1.username susername1,getPHActive(u.id) uph,getPHActive(s.id) sph,getPHActive(s1.id) sph1, e.amt, e.`type`,datediff(now(),e.created_at) ddiff,datediff(now(),e.created_at)+1 ddifc FROM gh e left join users u on e.user_id=u.id left join users s on u.referral_id=s.id left join users s1 on s.referral_id=s1.id where e.`type`=1 and e.`status`=0');
			$matches_sum = DB::select('SELECT sum(if(datediff(now(),e.created_at)-1=1,e.amt,0)) sd1, sum(if(datediff(now(),e.created_at)-1=2,e.amt,0)) sd2, sum(if(datediff(now(),e.created_at)-1=3,e.amt,0)) sd3, sum(if(datediff(now(),e.created_at)-1=4,e.amt,0)) sd4, sum(if(datediff(now(),e.created_at)-1=5,e.amt,0)) sd5, sum(if(datediff(now(),e.created_at)-1=6,e.amt,0)) sd6, sum(if(datediff(now(),e.created_at)-1=7,e.amt,0)) sd7, sum(if(datediff(now(),e.created_at)-1=8,e.amt,0)) sd8, sum(if(datediff(now(),e.created_at)-1=9,e.amt,0)) sd9, sum(if(datediff(now(),e.created_at)-1=10,e.amt,0)) sd10, sum(if(datediff(now(),e.created_at)-1=11,e.amt,0)) sd11, sum(if(datediff(now(),e.created_at)-1=12,e.amt,0)) sd12, sum(if(datediff(now(),e.created_at)-1=13,e.amt,0)) sd13, sum(if(datediff(now(),e.created_at)-1=14,e.amt,0)) sd14, sum(if(datediff(now(),e.created_at)-1=15,e.amt,0)) sd15, sum(if(datediff(now(),e.created_at)-1=16,e.amt,0)) sd16, sum(if(datediff(now(),e.created_at)-1=17,e.amt,0)) sd17, sum(if(datediff(now(),e.created_at)-1=18,e.amt,0)) sd18, sum(if(datediff(now(),e.created_at)-1=19,e.amt,0)) sd19, sum(if(datediff(now(),e.created_at)-1>=20,e.amt,0)) sd20 FROM gh e where e.`type`=1 and e.`status`=0');
		}
		if($request->type == 'unilevels') {
			$matches = DB::select('SELECT e.id, e.created_at, e.user_id, u.username,s.id sid,s.username susername,s1.id sid1,s1.username susername1,getPHActive(u.id) uph,getPHActive(s.id) sph,getPHActive(s1.id) sph1, e.amt, e.`type`,datediff(now(),e.created_at) ddiff,datediff(now(),e.created_at)+1 ddifc FROM gh e left join users u on e.user_id=u.id left join users s on u.referral_id=s.id left join users s1 on s.referral_id=s1.id where e.`type`=2 and e.`status`=0');
			$matches_sum = DB::select('SELECT sum(if(datediff(now(),e.created_at)-1=1,e.amt,0)) sd1, sum(if(datediff(now(),e.created_at)-1=2,e.amt,0)) sd2, sum(if(datediff(now(),e.created_at)-1=3,e.amt,0)) sd3, sum(if(datediff(now(),e.created_at)-1=4,e.amt,0)) sd4, sum(if(datediff(now(),e.created_at)-1=5,e.amt,0)) sd5, sum(if(datediff(now(),e.created_at)-1=6,e.amt,0)) sd6, sum(if(datediff(now(),e.created_at)-1=7,e.amt,0)) sd7, sum(if(datediff(now(),e.created_at)-1=8,e.amt,0)) sd8, sum(if(datediff(now(),e.created_at)-1=9,e.amt,0)) sd9, sum(if(datediff(now(),e.created_at)-1=10,e.amt,0)) sd10, sum(if(datediff(now(),e.created_at)-1=11,e.amt,0)) sd11, sum(if(datediff(now(),e.created_at)-1=12,e.amt,0)) sd12, sum(if(datediff(now(),e.created_at)-1=13,e.amt,0)) sd13, sum(if(datediff(now(),e.created_at)-1=14,e.amt,0)) sd14, sum(if(datediff(now(),e.created_at)-1=15,e.amt,0)) sd15, sum(if(datediff(now(),e.created_at)-1=16,e.amt,0)) sd16, sum(if(datediff(now(),e.created_at)-1=17,e.amt,0)) sd17, sum(if(datediff(now(),e.created_at)-1=18,e.amt,0)) sd18, sum(if(datediff(now(),e.created_at)-1=19,e.amt,0)) sd19, sum(if(datediff(now(),e.created_at)-1>=20,e.amt,0)) sd20 FROM gh e where e.`type`=2 and e.`status`=0');
		}
		if($request->type == 'earnings') {
			$matches = DB::select('SELECT e.id, e.created_at, e.user_id, u.username,s.id sid,s.username susername,s1.id sid1,s1.username susername1,getPHActive(u.id) uph,getPHActive(s.id) sph,getPHActive(s1.id) sph1, e.amt, e.`type`,datediff(now(),e.created_at) ddiff,datediff(now(),e.created_at)+1 ddifc FROM gh e left join users u on e.user_id=u.id left join users s on u.referral_id=s.id left join users s1 on s.referral_id=s1.id where e.`type`=3 and e.`status`=0');
			$matches_sum = DB::select('SELECT sum(if(datediff(now(),e.created_at)-1=1,e.amt,0)) sd1, sum(if(datediff(now(),e.created_at)-1=2,e.amt,0)) sd2, sum(if(datediff(now(),e.created_at)-1=3,e.amt,0)) sd3, sum(if(datediff(now(),e.created_at)-1=4,e.amt,0)) sd4, sum(if(datediff(now(),e.created_at)-1=5,e.amt,0)) sd5, sum(if(datediff(now(),e.created_at)-1=6,e.amt,0)) sd6, sum(if(datediff(now(),e.created_at)-1=7,e.amt,0)) sd7, sum(if(datediff(now(),e.created_at)-1=8,e.amt,0)) sd8, sum(if(datediff(now(),e.created_at)-1=9,e.amt,0)) sd9, sum(if(datediff(now(),e.created_at)-1=10,e.amt,0)) sd10, sum(if(datediff(now(),e.created_at)-1=11,e.amt,0)) sd11, sum(if(datediff(now(),e.created_at)-1=12,e.amt,0)) sd12, sum(if(datediff(now(),e.created_at)-1=13,e.amt,0)) sd13, sum(if(datediff(now(),e.created_at)-1=14,e.amt,0)) sd14, sum(if(datediff(now(),e.created_at)-1=15,e.amt,0)) sd15, sum(if(datediff(now(),e.created_at)-1=16,e.amt,0)) sd16, sum(if(datediff(now(),e.created_at)-1=17,e.amt,0)) sd17, sum(if(datediff(now(),e.created_at)-1=18,e.amt,0)) sd18, sum(if(datediff(now(),e.created_at)-1=19,e.amt,0)) sd19, sum(if(datediff(now(),e.created_at)-1>=20,e.amt,0)) sd20 FROM gh e where e.`type`=3 and e.`status`=0');
        }
		$total_ph = app('App\Http\Controllers\PhController')->sumAllPhActive();
		$total_phsel = app('App\Http\Controllers\PhController')->sumAllPhSelected();
        $total_gh = app('App\Http\Controllers\GhController')->sumAllGh();
        //$current_queue = Self::currentPhQueue();
		$current_q = DB::select('SELECT p.id,p.created_at, p.user_id, p.amt, p.amt_distributed,datediff(now(),p.created_at) ddiff,datediff(now(),p.created_at)+1 ddifc FROM ph p where (p.`status` is null) and selected=1 order by p.created_at asc limit 1');
        return view('admin.approve_matches')
            ->with('current_q',$current_q)
            ->with('total_ph',$total_ph)
            ->with('total_phsel',$total_phsel)
            ->with('total_gh',$total_gh)
            ->with('matches',$matches)
            ->with('matches_sum',$matches_sum)
            ->with('user',$this->user);
    }

    public function postApproveAllReferrals()
    {
        Referral::where('status',0)->orwhere('status',null)->update(['status' => 1]);
        return back();
    }

    public function postApproveAllUnilevels()
    {
        Unilevel::where('status',0)->orwhere('status',null)->update(['status' => 1]);
        return back();
    }
    
    public function postApproveAllEarnings()
    {
        Earning::where('status',0)->orwhere('status',null)->update(['status' => 1]);
        return back();
    }

    public function getPhQueue()
    {
        //$ph = Ph::where('status',null)->orderby('created_at')->get();
		$ph_sum = DB::select('SELECT sum(if(datediff(now(),p.created_at)+1=1,p.amt-p.amt_distributed,0)) sd1, sum(if(datediff(now(),p.created_at)+1=2,p.amt-p.amt_distributed,0)) sd2, sum(if(datediff(now(),p.created_at)+1=3,p.amt-p.amt_distributed,0)) sd3, sum(if(datediff(now(),p.created_at)+1=4,p.amt-p.amt_distributed,0)) sd4, sum(if(datediff(now(),p.created_at)+1=5,p.amt-p.amt_distributed,0)) sd5, sum(if(datediff(now(),p.created_at)+1=6,p.amt-p.amt_distributed,0)) sd6, sum(if(datediff(now(),p.created_at)+1=7,p.amt-p.amt_distributed,0)) sd7, sum(if(datediff(now(),p.created_at)+1=8,p.amt-p.amt_distributed,0)) sd8, sum(if(datediff(now(),p.created_at)+1=9,p.amt-p.amt_distributed,0)) sd9, sum(if(datediff(now(),p.created_at)+1=10,p.amt-p.amt_distributed,0)) sd10, sum(if(datediff(now(),p.created_at)+1=11,p.amt-p.amt_distributed,0)) sd11, sum(if(datediff(now(),p.created_at)+1=12,p.amt-p.amt_distributed,0)) sd12, sum(if(datediff(now(),p.created_at)+1=13,p.amt-p.amt_distributed,0)) sd13, sum(if(datediff(now(),p.created_at)+1=14,p.amt-p.amt_distributed,0)) sd14, sum(if(datediff(now(),p.created_at)+1=15,p.amt-p.amt_distributed,0)) sd15, sum(if(datediff(now(),p.created_at)+1=16,p.amt-p.amt_distributed,0)) sd16, sum(if(datediff(now(),p.created_at)+1=17,p.amt-p.amt_distributed,0)) sd17, sum(if(datediff(now(),p.created_at)+1=18,p.amt-p.amt_distributed,0)) sd18, sum(if(datediff(now(),p.created_at)+1=19,p.amt-p.amt_distributed,0)) sd19, sum(if(datediff(now(),p.created_at)+1>=20,p.amt-p.amt_distributed,0)) sd20 FROM ph p where p.status is null order by p.created_at');

		$SQLStr="SELECT p.id pid,p.selected,p.created_at, p.user_id, u.username, s.id sid, s.username susername,s1.id sid1,s1.username susername1,getPHActive(u.id) uph, ";
		$SQLStr=$SQLStr . " getPHActive(s.id) sph, getPHActive(s1.id) sph1, p.amt, p.amt_distributed,datediff(now(),p.created_at)+1 ddif,datediff(now(),";
		$SQLStr=$SQLStr . " p.created_at) ddiff,datediff(now(),p.created_at)+1 ddifc,w.current_balance ";
		$SQLStr=$SQLStr . " FROM ph p left join users u on p.user_id=u.id ";
		$SQLStr=$SQLStr . " left join wallets w on u.id=w.user_id ";
		$SQLStr=$SQLStr . " left join users s on u.referral_id=s.id ";
		$SQLStr=$SQLStr . " left join users s1 on s.referral_id=s1.id ";
		$SQLStr=$SQLStr . " where p.status is null order by p.created_at";

		$ph = DB::select($SQLStr);

        return view('admin.ph_queue')
            ->with('user',$this->user)
            ->with('ph_sum',$ph_sum)
            ->with('ph',$ph);
    }

    public function getBalance()
    {
		ini_set('max_execution_time', 3000);
        
		//return Ph::where('status',null)->first();
		$SQLStr="SELECT p.user_id, w.wallet_address ";
		$SQLStr=$SQLStr . " FROM ph p left join users u on p.user_id=u.id ";
		$SQLStr=$SQLStr . " left join wallets w on u.id=w.user_id ";
		$SQLStr=$SQLStr . " where p.status is null group by p.user_id order by p.created_at ";

		$targetwallet = DB::select($SQLStr);
		$allmsg="";
        foreach($targetwallet as $output)
        {
			$msg = app('App\Http\Controllers\WalletController')->updateMainWallet($output->user_id,$output->wallet_address); 
			$allmsg = $allmsg . $msg;
        }

		return "balance updated<br>" . $allmsg;
	}

    public function getBalanceSelected()
    {
		ini_set('max_execution_time', 3000);
        
		//return Ph::where('status',null)->first();
		$SQLStr="SELECT p.user_id, w.wallet_address ";
		$SQLStr=$SQLStr . " FROM ph p left join users u on p.user_id=u.id ";
		$SQLStr=$SQLStr . " left join wallets w on u.id=w.user_id ";
		$SQLStr=$SQLStr . " where p.selected=1 and p.status is null group by p.user_id order by p.created_at ";

		$targetwallet = DB::select($SQLStr);
		$allmsg="";
        foreach($targetwallet as $output)
        {
			$msg = app('App\Http\Controllers\WalletController')->updateMainWallet($output->user_id,$output->wallet_address); 
			$allmsg = $allmsg . $msg;
        }

		return "balance updated<br>" . $allmsg;
	}

    public function getAddPH(Request $request)
    {
		$id=$request->id;
		DB::update('update ph set selected=1 where id=' . $id);
		return "Selected PH added.";
	}

    public function getRemovePH(Request $request)
    {
		$id=$request->id;
		DB::update('update ph set selected=0 where id=' . $id);
		return "Selected PH removed.";
	}

    public function getAddAllPH()
    {
		DB::update('update ph set selected=1  where `status` is null');
		return "All PH added.";
	}

    public function getRemoveAllPH()
    {
		DB::update('update ph set selected=0 where `status` is null');
		return "All PH removed.";
	}

    public function resetQueue(Request $request)
    {
		$id=$request->id;
		DB::update('update wallet_queues_exe set qstat=2 where qstat=1 and id=' . $id);
		return "Wallet Queue reset successfully.";
	}

    public function currentPhQueue()
    {
        return Ph::where('status',null)->first();
	}

    public function getKyc()
    {
        $kyc = User::where('identification_verified',-1)->where('youtube_verified',-1)->get();
            return view('admin.approve_kyc')
            ->with('user',$this->user)
            ->with('kyc',$kyc);
    }

    public function postKyc(Request $request)
    {
        $user = User::find($request->user_id);
        $user->identification_verified = $request->status;
        $user->youtube_verified = $request->status;
        if($request->status == 0)
        {
            $user->youtube = '';
            $user->identification = '';
        }
        $user->save();
        return back();
    }
}