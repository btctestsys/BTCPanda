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
use Mail;


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

    public function getUserListKYC(Request $request){

      $uname = $request->uname;
      $status_kyc = $request->status_kyc;
      $typ = $request->show_entries;
      if($typ == ''){
         $query_limit = ' LIMIT 50';
      }else{
         $query_limit = ' LIMIT '.$request->show_entries;
      }
      $query = '';
      if($uname != ''){
         $query = $query.' username like "%'.$uname.'%" ';
      }
      if($status_kyc != ''){
         if($query != ''){ $query = $query.' and '; }
         if($status_kyc == 1){
            $query = $query.' kyc = "1"';
         }elseif($status_kyc == 2){
            $query = $query.' kyc = "2"';
         }elseif($status_kyc == 3){
            $query = $query.' kyc = "3"';
         }elseif($status_kyc == 4){
            $query = $query.' kyc = "4"';
         }
      }
      if($query != ''){
         $query = ' and '.$query;
      }
      $q = 'SELECT * FROM users WHERE (kyc != "0" OR kyc !=  "null") '.$query.' order by kyc_date desc'.$query_limit.'';
      $users_kyc = db::select($q);

      return view('admin.users_kyc')
         ->with('request',$request)
         ->with('users_kyc',$users_kyc)
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

      $query='';
		$querylimit='';
		$typ = $request->typ;
		if ($typ!='all'){$querylimit=' limit 10 ';}else{$querylimit='';}
		$country = $request->country;
		$tbname = $request->tbname;
		$tbuname = $request->tbuname;
		$tbwallet = $request->tbwallet;
		//$tbmobile = $request->tbmobile;
		$tbemail = $request->tbemail;
		$query=' u.username<>\'\' ';

		if ($tbname!=''){if ($query!='') {$query= $query . ' and ';}$query= $query . ' u.`name` like \'%' . $tbname . '%\' ';}
		if ($tbuname!=''){if ($query!='') {$query= $query . ' and ';}$query= $query .' u.`username` like \'%' . $tbuname . '%\' ';}
		if ($tbwallet!=''){if ($query!='') {$query= $query . ' and ';} $query= $query .' w.`wallet_address` like \'%' . $tbwallet . '%\' ';}
		//if ($tbmobile!=''){if ($query!='') {$query= $query . ' and ';} $query= $query .' u.`mobile` like \'%' . $tbmobile .'%\' ';}
		if ($tbemail!=''){if ($query!='') {$query= $query . ' and ';} $query= $query .' u.`email` like \'%' . $tbemail .'%\' ';}
		if ($country!=''){if ($query!='') {$query= $query . ' and ';} $query= $query .' u.`country` = \'' . $country .'\' ';}

		if ($query!='')
		{
			$query=' where ' . $query;
			if (in_array(session('AdminLvl'),array(3,4)))
			{
			$query = 'SELECT u.kyc,u.suspend u1s,s.suspend u2s,s1.suspend u3s,u.id, u.email, u.username, u.name, u.mobile, u.bamboo_balance, u.level_id, u.country,s.id sid,s.username susername,s1.id sid1,s1.username susername1,getPHActive(u.id) uph,getPHActive(s.id) sph,getPHActive(s1.id) sph1,w.wallet_address FROM users u left join wallets w on u.id=w.user_id left join users s on u.referral_id=s.id left join users s1 on s.referral_id=s1.id' . $query . ' order by u.id desc ' . $querylimit;
			}
			elseif (in_array(session('AdminLvl'),array(2)))
			{
			$kungfupanda = '1,2,3,4,5,6,7,8,9,10,11,19';
			$query = 'SELECT u.kyc,u.suspend u1s,s.suspend u2s,s1.suspend u3s,u.id, u.email, u.username, u.name, u.mobile, u.bamboo_balance, u.level_id, u.country,s.id sid,s.username susername,s1.id sid1,s1.username susername1,getPHActive(u.id) uph,getPHActive(s.id) sph,getPHActive(s1.id) sph1,w.wallet_address FROM users u left join wallets w on u.id=w.user_id left join users s on u.referral_id=s.id and left(s.gene,length(\''.$kungfupanda.'\')) = \''.$kungfupanda.'\' left join users s1 on s.referral_id=s1.id and left(s1.gene,length(\''.$kungfupanda.'\')) = \''.$kungfupanda.'\'' . $query . ' and left(u.gene,length(\''.$kungfupanda.'\')) = \''.$kungfupanda.'\' order by u.id desc ' . $querylimit;
			}
			elseif (in_array(session('AdminLvl'),array(1)))
			{
			$query = 'SELECT u.kyc,u.suspend u1s,s.suspend u2s,s1.suspend u3s,u.id, u.email, u.username, u.name, u.mobile, u.bamboo_balance, u.level_id, u.country,s.id sid,s.username susername,s1.id sid1,s1.username susername1,getPHActive(u.id) uph,getPHActive(s.id) sph,getPHActive(s1.id) sph1,w.wallet_address FROM users u left join wallets w on u.id=w.user_id left join users s on u.referral_id=s.id and left(s.gene,length(\''.session('AdminGene').'\')) = \''.session('AdminGene').'\' left join users s1 on s.referral_id=s1.id and left(s1.gene,length(\''.session('AdminGene').'\')) = \''.session('AdminGene').'\'' . $query . ' and left(u.gene,length(\''.session('AdminGene').'\')) = \''.session('AdminGene').'\' order by u.id desc ' . $querylimit;
         }
			$users = DB::select($query);

		}
		else
		{
			if (in_array(session('AdminLvl'),array(3,4)))
			{
			$query = 'SELECT u.kyc,u.suspend u1s,s.suspend u2s,s1.suspend u3s,u.id, u.email, u.username, u.name, u.mobile, u.bamboo_balance, u.level_id, u.country,s.id sid,s.username susername,s1.id sid1,s1.username susername1,getPHActive(u.id) uph,getPHActive(s.id) sph,getPHActive(s1.id) sph1,w.wallet_address FROM users u left join wallets w on u.id=w.user_id left join users s on u.referral_id=s.id left join users s1 on s.referral_id=s1.id  order by u.id desc ' . $querylimit;
			}
			elseif (in_array(session('AdminLvl'),array(2)))
			{
			$kungfupanda = '1,2,3,4,5,6,7,8,9,10,11,19';
			$query = 'SELECT u.kyc,u.suspend u1s,s.suspend u2s,s1.suspend u3s,u.id, u.email, u.username, u.name, u.mobile, u.bamboo_balance, u.level_id, u.country,s.id sid,s.username susername,s1.id sid1,s1.username susername1,getPHActive(u.id) uph,getPHActive(s.id) sph,getPHActive(s1.id) sph1,w.wallet_address FROM users u left join wallets w on u.id=w.user_id left join users s on u.referral_id=s.id and left(s.gene,length(\''.$kungfupanda.'\')) = \''.$kungfupanda.'\' left join users s1 on s.referral_id=s1.id and left(s1.gene,length(\''.$kungfupanda.'\')) = \''.$kungfupanda.'\'  and left(u.gene,length(\''.$kungfupanda.'\')) = \''.$kungfupanda.'\' order by u.id desc ' . $querylimit;
			}
			elseif (in_array(session('AdminLvl'),array(1)))
			{
			$query = 'SELECT u.kyc,u.suspend u1s,s.suspend u2s,s1.suspend u3s,u.id, u.email, u.username, u.name, u.mobile, u.bamboo_balance, u.level_id, u.country,s.id sid,s.username susername,s1.id sid1,s1.username susername1,getPHActive(u.id) uph,getPHActive(s.id) sph,getPHActive(s1.id) sph1,w.wallet_address FROM users u left join wallets w on u.id=w.user_id left join users s on u.referral_id=s.id and left(s.gene,length(\''.session('AdminGene').'\')) = \''.session('AdminGene').'\' left join users s1 on s.referral_id=s1.id and left(s1.gene,length(\''.session('AdminGene').'\')) = \''.session('AdminGene').'\'  and left(u.gene,length(\''.session('AdminGene').'\')) = \''.session('AdminGene').'\' order by u.id desc ' . $querylimit;
			}
			//$users = DB::select('SELECT u.suspend u1s,s.suspend u2s,s1.suspend u3s,u.id, u.email, u.username, u.name, u.mobile, u.bamboo_balance, u.level_id, u.country,s.id sid,s.username susername,s1.id sid1,s1.username susername1,getPHActive(u.id) uph,getPHActive(s.id) sph,getPHActive(s1.id) sph1,w.wallet_address FROM users u left join wallets w on u.id=w.user_id left join users s on u.referral_id=s.id left join users s1 on s.referral_id=s1.id order by u.id desc ' . $querylimit);
			//$users = DB::select($query);
		}
		//dd(array(session('AdminLvl'),$query));

        //$users = DB::table('users')->select('id','email','username','name','bamboo_balance','level_id','country')->orderby('created_at','desc')->get();
        //echo $query;
        //die();
		//return $users;
        return view('admin.users')
            ->with('request',$request)
            ->with('users',$users)
            ->with('user',$this->user);
    }

    public function getBamboos()
    {
		if (!in_array(session('AdminLvl'),array(3,4)))
		{
			abort(500,'Unauthorized Access');
		}

        $bamboos = DB::table('bamboos')->orderby('created_at','desc')
            ->where('from',1)
            ->get();

        return view('admin.bamboo')
            ->with('bamboos',$bamboos)
            ->with('user',$this->user);
    }

    public function getBamboosDaily()
    {
		if (!in_array(session('AdminLvl'),array(3,4)))
		{
			abort(500,'Unauthorized Access');
		}
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
		if (!in_array(session('AdminLvl'),array(3,4)))
		{
			abort(500,'Unauthorized Access');
		}
        //$ph = DB::table('ph')->orderby('created_at','desc')->get();
		$ph = DB::select('SELECT p.created_at, p.user_id, u.username, s.id sid, s.username susername, p.amt, p.amt_distributed,datediff(now(),p.created_at)+1 ddif FROM ph p left join users u on p.user_id=u.id left join users s on u.referral_id=s.id where p.status is null order by p.created_at desc');

        return view('admin.ph')
            ->with('ph',$ph)
            ->with('user',$this->user);
    }

    public function getPhDaily()
    {
		if (!in_array(session('AdminLvl'),array(3,4)))
		{
			abort(500,'Unauthorized Access');
		}
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
		if (!in_array(session('AdminLvl'),array(3,4)))
		{
			abort(500,'Unauthorized Access');
		}
        //$earnings = Earning::where('status',0)->orwhere('status',null)->get();
		$earnings = DB::select('SELECT u.suspend u1s,s.suspend u2s,s1.suspend u3s,e.id, e.created_at, e.user_id, u.username,s.id sid,s.username susername, e.amt,s1.id sid1,s1.username susername1,getPHActive(u.id) uph,getPHActive(s.id) sph,getPHActive(s1.id) sph1 FROM earnings e left join users u on e.user_id=u.id left join users s on u.referral_id=s.id left join users s1 on s.referral_id=s1.id where (e.`status` is null or e.`status`=0) and u.suspend=0');
        return view('admin.approve_earnings')
			->with('earnings',$earnings)
			->with('user',$this->user);
    }

    public function getApprovalEarningsAll()
    {
		if (!in_array(session('AdminLvl'),array(3,4)))
		{
			abort(500,'Unauthorized Access');
		}
        //$earnings = Earning::where('status',0)->orwhere('status',null)->get();
		$earnings = DB::select('SELECT u.suspend u1s,s.suspend u2s,s1.suspend u3s,e.id, e.created_at, e.user_id, u.username,s.id sid,s.username susername, e.amt,s1.id sid1,s1.username susername1,getPHActive(u.id) uph,getPHActive(s.id) sph,getPHActive(s1.id) sph1 FROM earnings e left join users u on e.user_id=u.id left join users s on u.referral_id=s.id left join users s1 on s.referral_id=s1.id where e.`status` is null or e.`status`=0');
        return view('admin.approve_earnings')
			->with('earnings',$earnings)
			->with('user',$this->user);
    }

    public function getApprovalReferrals()
    {
		if (!in_array(session('AdminLvl'),array(3,4)))
		{
			abort(500,'Unauthorized Access');
		}
        //$referrals = Referral::where('status',0)->orwhere('status',null)->get();
		$referrals = DB::select('SELECT u.suspend u1s,s.suspend u2s,s1.suspend u3s,e.id, e.created_at, e.user_id, u.username,s.id sid,s.username susername, e.amt,s1.id sid1,s1.username susername1,getPHActive(u.id) uph,getPHActive(s.id) sph,getPHActive(s1.id) sph1 FROM referrals e left join users u on e.user_id=u.id left join users s on u.referral_id=s.id left join ph p on e.ph_id=p.id left join users s1 on p.user_id=s1.id where (e.`status` is null or e.`status`=0) and u.suspend=0');

        return view('admin.approve_referrals')
			->with('referrals',$referrals)
			->with('user',$this->user);
    }

    public function getApprovalReferralsAll()
    {
		if (!in_array(session('AdminLvl'),array(3,4)))
		{
			abort(500,'Unauthorized Access');
		}
        //$referrals = Referral::where('status',0)->orwhere('status',null)->get();
		$referrals = DB::select('SELECT u.suspend u1s,s.suspend u2s,s1.suspend u3s,e.id, e.created_at, e.user_id, u.username,s.id sid,s.username susername, e.amt,s1.id sid1,s1.username susername1,getPHActive(u.id) uph,getPHActive(s.id) sph,getPHActive(s1.id) sph1 FROM referrals e left join users u on e.user_id=u.id left join users s on u.referral_id=s.id left join ph p on e.ph_id=p.id left join users s1 on p.user_id=s1.id where e.`status` is null or e.`status`=0');

        return view('admin.approve_referrals')
			->with('referrals',$referrals)
			->with('user',$this->user);
    }

    public function getApprovalUnilevels()
    {
		if (!in_array(session('AdminLvl'),array(3,4)))
		{
			abort(500,'Unauthorized Access');
		}
        //$unilevels = Unilevel::where('status',0)->orwhere('status',null)->get();
		$unilevels = DB::select('SELECT u.suspend u1s,s.suspend u2s,s1.suspend u3s,e.id, e.created_at, e.user_id, u.username,s.id sid,s.username susername, e.amt,s1.id sid1,s1.username susername1,getPHActive(u.id) uph,getPHActive(s.id) sph,getPHActive(s1.id) sph1 FROM unilevels e left join users u on e.user_id=u.id left join users s on u.referral_id=s.id left join ph p on e.ph_id=p.id left join users s1 on p.user_id=s1.id where (e.`status` is null or e.`status`=0) and u.suspend=0');
        return view('admin.approve_unilevels')
			->with('unilevels',$unilevels)
			->with('user',$this->user);
    }

    public function getApprovalUnilevelsAll()
    {
		if (!in_array(session('AdminLvl'),array(3,4)))
		{
			abort(500,'Unauthorized Access');
		}
        //$unilevels = Unilevel::where('status',0)->orwhere('status',null)->get();
		$unilevels = DB::select('SELECT u.suspend u1s,s.suspend u2s,s1.suspend u3s,e.id, e.created_at, e.user_id, u.username,s.id sid,s.username susername, e.amt,s1.id sid1,s1.username susername1,getPHActive(u.id) uph,getPHActive(s.id) sph,getPHActive(s1.id) sph1 FROM unilevels e left join users u on e.user_id=u.id left join users s on u.referral_id=s.id left join ph p on e.ph_id=p.id left join users s1 on p.user_id=s1.id where e.`status` is null or e.`status`=0');
        return view('admin.approve_unilevels')
			->with('unilevels',$unilevels)
			->with('user',$this->user);
    }

    public function postApproveReferral(Request $request)
    {
		if (!in_array(session('AdminLvl'),array(3,4)))
		{
			abort(500,'Unauthorized Access');
		}
        $referral = Referral::find($request->id);
        $referral->status = 1;
        $referral->save();

        ##Audit-----
        ##20 = Check Referral - Approve
        if(session('has_admin_access') == ''){ $edited_by = $this->user->id;}else{$edited_by = session('has_admin_access');}
        $input = "[".$request->id."][".$request->member."][".$request->ref_bonus."]";
        Custom::auditTrail($this->user->id, '20', $edited_by, $input);
        return back();
    }

    public function postApproveUnilevel(Request $request)
    {
		if (!in_array(session('AdminLvl'),array(3,4)))
		{
			abort(500,'Unauthorized Access');
		}
        $referral = Unilevel::find($request->id);
        $referral->status = 1;
        $referral->save();

        ##Audit-----
        ##23 = Check Referral - Approve
        if(session('has_admin_access') == ''){ $edited_by = $this->user->id;}else{$edited_by = session('has_admin_access');}
        $input = "[".$request->id."][".$request->member."][".$request->ref_bonus."]";
        Custom::auditTrail($this->user->id, '23', $edited_by, $input);
        return back();
    }

    public function postApproveEarning(Request $request)
    {
		if (!in_array(session('AdminLvl'),array(3,4)))
		{
			abort(500,'Unauthorized Access');
		}
        $referral = Earning::find($request->id);
        $referral->status = 1;
        $referral->save();
        return back();
    }

    public function getApprovalMatch(Request $request)
    {
		if (!in_array(session('AdminLvl'),array(3,4)))
		{
			abort(500,'Unauthorized Access');
		}
        //if($request->type == 'all') $matches = Gh::where('status',0)->orwhere('status',null)->get();
        //if($request->type == 'referrals') $matches = Gh::where('status',0)->where('type',1)->get();
        //if($request->type == 'unilevels') $matches = Gh::where('status',0)->where('type',2)->get();
        //if($request->type == 'earnings') $matches = Gh::where('status',0)->where('type',3)->get();

		if($request->type == 'all') {
			$matches = DB::select('SELECT u.kyc, u.suspend u1s,s.suspend u2s,s1.suspend u3s,e.id, e.created_at, e.user_id, u.username,s.id sid,s.username susername,s1.id sid1,s1.username susername1,getPHActive(u.id) uph,getPHActive(s.id) sph,getPHActive(s1.id) sph1, e.amt, e.`type`,datediff(now(),e.created_at) ddiff,datediff(now(),e.created_at)+1 ddifc FROM gh e left join users u on e.user_id=u.id left join users s on u.referral_id=s.id left join users s1 on s.referral_id=s1.id where (e.`status` is null or e.`status`=0) and u.suspend=0');
			$matches_sum = DB::select('SELECT sum(if(datediff(now(),e.created_at)-1=1,e.amt,0)) sd1, sum(if(datediff(now(),e.created_at)-1=2,e.amt,0)) sd2, sum(if(datediff(now(),e.created_at)-1=3,e.amt,0)) sd3, sum(if(datediff(now(),e.created_at)-1=4,e.amt,0)) sd4, sum(if(datediff(now(),e.created_at)-1=5,e.amt,0)) sd5, sum(if(datediff(now(),e.created_at)-1=6,e.amt,0)) sd6, sum(if(datediff(now(),e.created_at)-1=7,e.amt,0)) sd7, sum(if(datediff(now(),e.created_at)-1=8,e.amt,0)) sd8, sum(if(datediff(now(),e.created_at)-1=9,e.amt,0)) sd9, sum(if(datediff(now(),e.created_at)-1=10,e.amt,0)) sd10, sum(if(datediff(now(),e.created_at)-1=11,e.amt,0)) sd11, sum(if(datediff(now(),e.created_at)-1=12,e.amt,0)) sd12, sum(if(datediff(now(),e.created_at)-1=13,e.amt,0)) sd13, sum(if(datediff(now(),e.created_at)-1=14,e.amt,0)) sd14, sum(if(datediff(now(),e.created_at)-1=15,e.amt,0)) sd15, sum(if(datediff(now(),e.created_at)-1=16,e.amt,0)) sd16, sum(if(datediff(now(),e.created_at)-1=17,e.amt,0)) sd17, sum(if(datediff(now(),e.created_at)-1=18,e.amt,0)) sd18, sum(if(datediff(now(),e.created_at)-1=19,e.amt,0)) sd19, sum(if(datediff(now(),e.created_at)-1>=20,e.amt,0)) sd20 FROM gh e inner join users u on e.user_id=u.id where (e.`status` is null or e.`status`=0) and u.suspend=0');
		}
		if($request->type == 'referrals') {
			$matches = DB::select('SELECT u.kyc, u.suspend u1s,s.suspend u2s,s1.suspend u3s,e.id, e.created_at, e.user_id, u.username,s.id sid,s.username susername,s1.id sid1,s1.username susername1,getPHActive(u.id) uph,getPHActive(s.id) sph,getPHActive(s1.id) sph1, e.amt, e.`type`,datediff(now(),e.created_at) ddiff,datediff(now(),e.created_at)+1 ddifc FROM gh e left join users u on e.user_id=u.id left join users s on u.referral_id=s.id left join users s1 on s.referral_id=s1.id where e.`type`=1 and e.`status`=0 and u.suspend=0');
			$matches_sum = DB::select('SELECT sum(if(datediff(now(),e.created_at)-1=1,e.amt,0)) sd1, sum(if(datediff(now(),e.created_at)-1=2,e.amt,0)) sd2, sum(if(datediff(now(),e.created_at)-1=3,e.amt,0)) sd3, sum(if(datediff(now(),e.created_at)-1=4,e.amt,0)) sd4, sum(if(datediff(now(),e.created_at)-1=5,e.amt,0)) sd5, sum(if(datediff(now(),e.created_at)-1=6,e.amt,0)) sd6, sum(if(datediff(now(),e.created_at)-1=7,e.amt,0)) sd7, sum(if(datediff(now(),e.created_at)-1=8,e.amt,0)) sd8, sum(if(datediff(now(),e.created_at)-1=9,e.amt,0)) sd9, sum(if(datediff(now(),e.created_at)-1=10,e.amt,0)) sd10, sum(if(datediff(now(),e.created_at)-1=11,e.amt,0)) sd11, sum(if(datediff(now(),e.created_at)-1=12,e.amt,0)) sd12, sum(if(datediff(now(),e.created_at)-1=13,e.amt,0)) sd13, sum(if(datediff(now(),e.created_at)-1=14,e.amt,0)) sd14, sum(if(datediff(now(),e.created_at)-1=15,e.amt,0)) sd15, sum(if(datediff(now(),e.created_at)-1=16,e.amt,0)) sd16, sum(if(datediff(now(),e.created_at)-1=17,e.amt,0)) sd17, sum(if(datediff(now(),e.created_at)-1=18,e.amt,0)) sd18, sum(if(datediff(now(),e.created_at)-1=19,e.amt,0)) sd19, sum(if(datediff(now(),e.created_at)-1>=20,e.amt,0)) sd20 FROM gh e inner join users u on e.user_id=u.id where e.`type`=1 and e.`status`=0 and u.suspend=0');
		}
		if($request->type == 'unilevels') {
			$matches = DB::select('SELECT u.kyc, u.suspend u1s,s.suspend u2s,s1.suspend u3s,e.id, e.created_at, e.user_id, u.username,s.id sid,s.username susername,s1.id sid1,s1.username susername1,getPHActive(u.id) uph,getPHActive(s.id) sph,getPHActive(s1.id) sph1, e.amt, e.`type`,datediff(now(),e.created_at) ddiff,datediff(now(),e.created_at)+1 ddifc FROM gh e left join users u on e.user_id=u.id left join users s on u.referral_id=s.id left join users s1 on s.referral_id=s1.id where e.`type`=2 and e.`status`=0 and u.suspend=0');
			$matches_sum = DB::select('SELECT sum(if(datediff(now(),e.created_at)-1=1,e.amt,0)) sd1, sum(if(datediff(now(),e.created_at)-1=2,e.amt,0)) sd2, sum(if(datediff(now(),e.created_at)-1=3,e.amt,0)) sd3, sum(if(datediff(now(),e.created_at)-1=4,e.amt,0)) sd4, sum(if(datediff(now(),e.created_at)-1=5,e.amt,0)) sd5, sum(if(datediff(now(),e.created_at)-1=6,e.amt,0)) sd6, sum(if(datediff(now(),e.created_at)-1=7,e.amt,0)) sd7, sum(if(datediff(now(),e.created_at)-1=8,e.amt,0)) sd8, sum(if(datediff(now(),e.created_at)-1=9,e.amt,0)) sd9, sum(if(datediff(now(),e.created_at)-1=10,e.amt,0)) sd10, sum(if(datediff(now(),e.created_at)-1=11,e.amt,0)) sd11, sum(if(datediff(now(),e.created_at)-1=12,e.amt,0)) sd12, sum(if(datediff(now(),e.created_at)-1=13,e.amt,0)) sd13, sum(if(datediff(now(),e.created_at)-1=14,e.amt,0)) sd14, sum(if(datediff(now(),e.created_at)-1=15,e.amt,0)) sd15, sum(if(datediff(now(),e.created_at)-1=16,e.amt,0)) sd16, sum(if(datediff(now(),e.created_at)-1=17,e.amt,0)) sd17, sum(if(datediff(now(),e.created_at)-1=18,e.amt,0)) sd18, sum(if(datediff(now(),e.created_at)-1=19,e.amt,0)) sd19, sum(if(datediff(now(),e.created_at)-1>=20,e.amt,0)) sd20 FROM gh e inner join users u on e.user_id=u.id where e.`type`=2 and e.`status`=0 and u.suspend=0');
		}
		if($request->type == 'earnings') {
			$matches = DB::select('SELECT u.kyc, u.suspend u1s,s.suspend u2s,s1.suspend u3s,e.id, e.created_at, e.user_id, u.username,s.id sid,s.username susername,s1.id sid1,s1.username susername1,getPHActive(u.id) uph,getPHActive(s.id) sph,getPHActive(s1.id) sph1, e.amt, e.`type`,datediff(now(),e.created_at) ddiff,datediff(now(),e.created_at)+1 ddifc FROM gh e left join users u on e.user_id=u.id left join users s on u.referral_id=s.id left join users s1 on s.referral_id=s1.id where e.`type`=3 and e.`status`=0 and u.suspend=0');
			$matches_sum = DB::select('SELECT sum(if(datediff(now(),e.created_at)-1=1,e.amt,0)) sd1, sum(if(datediff(now(),e.created_at)-1=2,e.amt,0)) sd2, sum(if(datediff(now(),e.created_at)-1=3,e.amt,0)) sd3, sum(if(datediff(now(),e.created_at)-1=4,e.amt,0)) sd4, sum(if(datediff(now(),e.created_at)-1=5,e.amt,0)) sd5, sum(if(datediff(now(),e.created_at)-1=6,e.amt,0)) sd6, sum(if(datediff(now(),e.created_at)-1=7,e.amt,0)) sd7, sum(if(datediff(now(),e.created_at)-1=8,e.amt,0)) sd8, sum(if(datediff(now(),e.created_at)-1=9,e.amt,0)) sd9, sum(if(datediff(now(),e.created_at)-1=10,e.amt,0)) sd10, sum(if(datediff(now(),e.created_at)-1=11,e.amt,0)) sd11, sum(if(datediff(now(),e.created_at)-1=12,e.amt,0)) sd12, sum(if(datediff(now(),e.created_at)-1=13,e.amt,0)) sd13, sum(if(datediff(now(),e.created_at)-1=14,e.amt,0)) sd14, sum(if(datediff(now(),e.created_at)-1=15,e.amt,0)) sd15, sum(if(datediff(now(),e.created_at)-1=16,e.amt,0)) sd16, sum(if(datediff(now(),e.created_at)-1=17,e.amt,0)) sd17, sum(if(datediff(now(),e.created_at)-1=18,e.amt,0)) sd18, sum(if(datediff(now(),e.created_at)-1=19,e.amt,0)) sd19, sum(if(datediff(now(),e.created_at)-1>=20,e.amt,0)) sd20 FROM gh e inner join users u on e.user_id=u.id where e.`type`=3 and e.`status`=0 and u.suspend=0');
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
		if (!in_array(session('AdminLvl'),array(3,4)))
		{
			abort(500,'Unauthorized Access');
		}
        Referral::where('status',0)->orwhere('status',null)->update(['status' => 1]);

        ##Audit-----
        ##21 = Check Referral - Approve All
        if(session('has_admin_access') == ''){ $edited_by = $this->user->id;}else{$edited_by = session('has_admin_access');}
        $input = "[ALL]";
        Custom::auditTrail($this->user->id, '21', $edited_by, $input);

        return back();
    }

    public function postApproveAllUnilevels()
    {
		if (!in_array(session('AdminLvl'),array(3,4)))
		{
			abort(500,'Unauthorized Access');
		}
        Unilevel::where('status',0)->orwhere('status',null)->update(['status' => 1]);

        ##Audit-----
        ##22 = Check Unilevels - Approve All
        if(session('has_admin_access') == ''){ $edited_by = $this->user->id;}else{$edited_by = session('has_admin_access');}
        $input = "[ALL]";
        Custom::auditTrail($this->user->id, '22', $edited_by, $input);

        return back();
    }

    public function postApproveAllEarnings()
    {
		if (!in_array(session('AdminLvl'),array(3,4)))
		{
			abort(500,'Unauthorized Access');
		}
        Earning::where('status',0)->orwhere('status',null)->update(['status' => 1]);
        return back();
    }

    public function getPhQueue()
    {
		if (!in_array(session('AdminLvl'),array(3,4)))
		{
			abort(500,'Unauthorized Access');
		}
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

	public function getSumAmtPhSelected(){

		//select sum amt selected
		//$SumAmtPhSelected = DB::select('select sum(amt) as total_amt_selected from ph where status is null and selected = "1"');

		$SQLStr="SELECT sum(p.amt) amt, sum(w.current_balance) cb, sum(p.amt_distributed) ad";
		$SQLStr=$SQLStr . " FROM ph p left join users u on p.user_id=u.id ";
		$SQLStr=$SQLStr . " left join wallets w on u.id=w.user_id ";
		$SQLStr=$SQLStr . " where p.status is null and selected = '1'";

		$ph = DB::select($SQLStr);

		foreach($ph as $output)
		{
			$amt = $output->amt;
			$cb = $output->cb;
			$ad = $output->ad;
		}
		#print_r(array($cb,$amt, $amt - $ad));
		return array($cb,$amt, $amt - $ad);
		//return $SumAmtPhSelected['0']->total_amt_selected;
	}

    public function getRemoveAllPH()
    {
		DB::update('update ph set selected=0 where `status` is null');
		return "All PH removed.";
	}

    public function resetQueue(Request $request)
    {
		if (!in_array(session('AdminLvl'),array(3,4)))
		{
			abort(500,'Unauthorized Access');
		}
		$id=$request->id;
		DB::update('update wallet_queues_exe set qstat=2 where qstat=1 and id=' . $id);
		return "Wallet Queue reset successfully.";
	}

    public function currentPhQueue()
    {
		if (!in_array(session('AdminLvl'),array(3,4)))
		{
			abort(500,'Unauthorized Access');
		}
        return Ph::where('status',null)->first();
	}

    public function getKyc()
    {
		if (!in_array(session('AdminLvl'),array(3,4)))
		{
			abort(500,'Unauthorized Access');
		}
        $kyc = User::where('identification_verified',-1)->where('youtube_verified',-1)->get();
            return view('admin.approve_kyc')
            ->with('user',$this->user)
            ->with('kyc',$kyc);
    }

    public function postKyc(Request $request)
    {
		if (!in_array(session('AdminLvl'),array(3,4)))
		{
			abort(500,'Unauthorized Access');
		}
        $user = User::find($request->user_id);
        $user->identification_verified = $request->status;
        $user->youtube_verified = $request->status;
        $youtube_link = $user->youtube;
        if($request->status == 0)
        {
            $user->youtube = '';
            $user->identification = '';
        }
        $user->save();

        if($request->status == 0){ $action = 'Reject'; $audit_id = '26';}
        if($request->status == 1){ $action = 'Approve'; $audit_id = '25';}

        ##Audit-----
        ##25 && 26 = Approve / Reject KYC
        if(session('has_admin_access') == ''){ $edited_by = $this->user->id;}else{$edited_by = session('has_admin_access');}
        $input = "[".$request->user_id."-".$user->username."][".$action."][".$youtube_link."]";
        Custom::auditTrail($this->user->id, $audit_id, $edited_by, $input);

        return back();
    }

    public function reportPH()
    {
		if (!in_array(session('AdminLvl'),array(3,4)))
		{
			abort(500,'Unauthorized Access');
		}

		$TopDSV = app('App\Http\Controllers\UserController')->getTopDSV();

		return view('report.dailyph')
			->with('TopDSV',$TopDSV)
			->with('user',$this->user);
    }

	public function reportPhByCountry(Request $request){

		if($request->inputDate != ''){
		    $inputDate = $request->input('inputDate');
		}else{
		    $inputDate = date("Y-m-d");
		}

		$query = 'SELECT u.country,c.country cname,SUM(amt) totalph FROM users u INNER JOIN ph p ON u.id=p.user_id
					   LEFT JOIN country c ON u.country=c.code
					   WHERE	DATE(p.created_at) = "'.$inputDate.'" GROUP BY u.country ORDER BY totalph DESC';
		$phDate = DB::select($query);

		$query2 = "SELECT u.country,c.country cname,SUM(amt) totalph, DATE(p.created_at) as created_at
						FROM users u INNER JOIN ph p ON u.id=p.user_id LEFT JOIN country c ON u.country=c.code
						WHERE 	DATE(p.created_at) BETWEEN DATE_ADD('".$inputDate."', INTERVAL -6 DAY) AND '".$inputDate."'
						GROUP BY DATE(p.created_at), u.country
						ORDER BY u.country, DATE(p.created_at) DESC";
		$phDate7d = DB::select($query2);

		$query3 = "SELECT u.country,c.country cname,SUM(amt) totalph, DATE_FORMAT(p.created_at, '%Y%m') as created_at
						FROM users u INNER JOIN ph p ON u.id=p.user_id LEFT JOIN country c ON u.country=c.code
						WHERE DATE(p.created_at) BETWEEN DATE_ADD(DATE(CONCAT(YEAR('".$inputDate."'), '-', MONTH('".$inputDate."'), '-01')), INTERVAL -2 MONTH)
						AND DATE_ADD(DATE_ADD(DATE(CONCAT(YEAR('".$inputDate."'), '-', MONTH('".$inputDate."'), '-01')), INTERVAL 1 MONTH), INTERVAL -1 DAY)
						GROUP BY DATE_FORMAT(p.created_at, '%Y%m'), u.country
						ORDER BY u.country, DATE_FORMAT(p.created_at, '%Y%m') DESC";

		$phDate3m= DB::select($query3);

		$query4 = "SELECT  DATE_FORMAT(p.created_at, '%Y%m') as created_at, DATE_FORMAT(p.created_at, '%Y-%m') as created_at1
						FROM ph p
						WHERE DATE(p.created_at) BETWEEN DATE_ADD(DATE(CONCAT(YEAR('".$inputDate."'), '-', MONTH('".$inputDate."'), '-01')), INTERVAL -2 MONTH)
						AND DATE_ADD(DATE_ADD(DATE(CONCAT(YEAR('".$inputDate."'), '-', MONTH('".$inputDate."'), '-01')), INTERVAL 1 MONTH), INTERVAL -1 DAY)
						GROUP BY DATE_FORMAT(p.created_at, '%Y%m')
						ORDER BY DATE_FORMAT(p.created_at, '%Y%m') DESC";

		$phdates = DB::select($query4);



		return view('report.phbycountry')
			->with('inputDate',$inputDate)
			->with('phDate',$phDate)
			->with('phDate7d',$phDate7d)
			->with('phDate3m',$phDate3m)
			->with('phdates',$phdates)
			->with('user',$this->user);
    }

    function auditTrail(Request $request){

      $query_limit = ' LIMIT 10';

      $inputDate = $request->inputDate;
		$uname = $request->uname;
	   $ip = $request->ip;
      $query = '';
      $typ = $request->show_entries;
      if($typ == 'all'){
         $query_limit = '';
      }elseif($typ != ''){
         $query_limit = ' LIMIT '.$request->show_entries;
      }

      if($inputDate != ''){
         $query = " date(a.created_at) = '".$inputDate."' ";
      }
      if($uname != ''){
         if($query != ''){
            $query = $query.' and ';
         }
         $query = $query.' (c.username like "%'.$uname.'%" or  d.username like "%'.$uname.'%")';
      }
      if($ip != ''){
         if($query != ''){
            $query = $query.' and ';
         }
         $query = $query.' a.ip_address like "%'.$ip.'%" ';
      }

      if($query != ''){
         $query = ' where '.$query;
      }
      $db1 = getenv('DB_DATABASE');
      $db2 = getenv('DB_EXT_DATABASE');

      $sql = 'SELECT a.*, b.`action` ,c.username member, d.username updated_by
                           FROM '.$db2.'.audit_trail a
                           JOIN '.$db2.'.lookup_audit_trail b ON (a.`action_id` = b.id)
                           JOIN '.$db1.'.users c ON (a.`uid` = c.`id`)
                           JOIN '.$db1.'.users d ON (a.`created_by` = d.`id`)'.$query.'order by a.created_at desc '.$query_limit.'';

      $audit = DB::select($sql);

      if($request->view == 1){
         $view = 'admin.user_audit_trail';
      }else{
         $view = 'admin.audit_trail';
      }
        return view($view)
            ->with('audit',$audit)
            ->with('request',$request)
            ->with('user',$this->user);
   }

   public function doUpdateKycStatus($uid, $status, $kyc_note){

      if($status == '1'){
         $suspend = '1';
         $date_kyc = 'kyc_date';
      }elseif($status == '2'){
         $suspend = '1';
         $date_kyc = 'kyc_endorse_date';
      }elseif($status == '3'){
         $suspend = '2';
         $date_kyc = 'kyc_approve_date';
      }elseif($status == '4'){
         $suspend = '0';
         $date_kyc = 'kyc_approve_date';
      }

      $query = DB::table('users')
                  ->where('id', $uid)
                  ->update(['kyc' => $status,'suspend'=> $suspend,'kyc_note'=> $kyc_note, $date_kyc => DB::raw("now()")]);

      if($query){

         if($status == '1'){

            ##Send Email KYC Verification to member-----
            $query      = "SELECT `email`,`username`,`name` FROM users WHERE id = '$uid'";
      		$userInfo   = DB::select($query);

            $subject    = 'Respond To KYC Required';
            $username   = $userInfo['0']->username;
            $email      = $userInfo['0']->email;
            $name       = $userInfo['0']->name;

            Mail::send('emails.emailKYC_verification', ['username' => $username], function($message) use ($subject, $email, $name) {
      		   $message->to($email, $name)
      			->subject($subject);
      		});
         }

         ##Audit-----
         ##27 = Update KYC Status
         if(session('has_admin_access') == ''){ $edited_by = $this->user->id;}else{$edited_by = session('has_admin_access');}
         $input = "[".$uid."][".$status."][".$suspend."]";
         Custom::auditTrail($this->user->id, '27', $edited_by, $input);

         return 1;
      }else{
         return 0;
      }
   }
}
