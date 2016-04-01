<?php
namespace App\Http\Controllers;

use Auth;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use App\User;
use App\Classes\Custom;
use App\Referral;
use Crypt;
use Mail;
use Session;

class UserController extends Controller
{	    
    private $user;
    private $users2;
    private $query;

    public function __construct()
    {    	
    	$this->user = Auth::user();
    }

    public function countSetActiveReferrals()
    {
        $referrals_active = User::where('referral_id',$this->user->id)
            ->where(function($query) {
                $query->where('ph.status',null)->orwhere('ph.status','<>',2);
            })
            ->join('ph','ph.user_id','=','users.id')
            ->groupby('ph.user_id')
            ->get();

        $referrals_active = count($referrals_active);
        
        //if(app('App\Http\Controllers\PhController')->sumPhActive() >= 0.1)
        //{
        //    //set referal level    	
        //    if($referrals_active <= 5) $level_referral_id = 1;
        //	if($referrals_active >  5) $level_referral_id = 2;
        //	if($referrals_active > 10) $level_referral_id = 3;
        //	if($referrals_active > 15) $level_referral_id = 4;
        //	if($referrals_active > 20) $level_referral_id = 5;
        //	if($referrals_active > 25) $level_referral_id = 6;

        //    //set manager level
        //    if($referrals_active <  10) $level_id = 1;
        //    if($referrals_active >= 10) $level_id = 2;
        //    if($referrals_active >= 15) $level_id = 3;
        //    if($referrals_active >= 20) $level_id = 4;
        //    if($referrals_active >= 25) $level_id = 5;
        //    if($referrals_active >= 30) $level_id = 6;
        //}
        //else
        //{
        //    //set to lowest
        //    $level_referral_id = 1;
        //    $level_id = 1;
        //}

        //if admin set max level
        //if($this->user->isAdmin())
        //{
        //    $level_id = 6;
        //    $level_referral_id = 6;
        //}   

		//skipped. do this during ph/gh instead
    	//DB::table('users')
    	//	->where('id',$this->user->id)
    	//	->update([
    	//	'level_referral_id' => $level_referral_id,
    	//	'level_id' => $level_id,
		//]);

    	return $referrals_active;
	}

	public function getUserReferralRate($user_id)
	{
		$user = User::find($user_id);
		return $user->levelReferral->referral_rate;
	}

    public function getUserPhLimit($user_id)
    {
        $user = User::find($user_id);
        return $user->levelReferral->ph_limit;
    }

    public function getUserPhLeft($user_id)
    {
        $ph_limit = Self::getUserPhLimit($user_id);
        $ph_active = app('App\Http\Controllers\PhController')->sumPhActive($user_id);
        return $ph_limit - $ph_active;
    }

    public function selfUpdateGene()
    {
		
        $upline = DB::table('users')->where('id',$this->user->referral_id)->first();
		if (empty($upline->gene))
		{
	        DB::table('users')->where('id',$this->user->id)->update(['gene'=>$this->user->id]);
		}
		else
		{
	        DB::table('users')->where('id',$this->user->id)->update(['gene'=>$upline->gene.",".$this->user->id]);
		}
    }

    public function getUserUnilevelRate($user_id,$level)
    {
        $user = User::find($user_id);        
        return $user->level->{"level".$level};
    }

    public function resetAllTitle()
    {
        $user = DB::select('select id from users order by id desc'); 
        foreach($user as $output)
        {
			//DB::select('call setManagerTitle('.$output->id.')');
			DB::select('call setSponsorTitle2016('.$output->id.')');
        }
		return 'done reset title';
    }

    public function getIdUrl($user_id)
    {
        $user = User::find($user_id);
        $filename = md5($user->identification).".png";        
        return "https://s3-ap-southeast-1.amazonaws.com/btcpanda/identification/".$filename;
    }

    public function embedYouTube($url)
    {
        $url = str_replace('watch','embed/',$url);
        $url = str_replace('?v=','',$url);
        return $url;
    }

    public function getTree(Request $request)
    {
        if($request->id)
        {
            $id = Crypt::decrypt($request->id);
        }
        else
        {
            $id = $this->user->id;
        }

        $current_user = User::find($id);
        $users = User::where('referral_id',$id)->orderby('created_at','desc')->get();
        return view('tree')
            ->with('users',$users)
            ->with('user',$this->user)
            ->with('current_user',$current_user);
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

    public function getMarchDSV()
    {
        $dsv = 0;
		$ph = DB::select('select ifnull(sum(p.amt),0) activedownlinePH from ph p inner join users u on p.user_id=u.id inner join users r on u.referral_id=r.id where (`status` is null or `status`<>2) and month(p.created_at)=3 and year(p.created_at)=2016 and u.referral_id=' . $this->user->id);
        
        foreach($ph as $output)
        {
            $dsv = $output->activedownlinePH;
        }
        
        return $dsv;
    }

    public function getLastOpenQ()
    {
		$CurLastOpenQ = DB::select('select id,created_at,TIMESTAMPDIFF(MINUTE,created_at,NOW()) mdif from wallet_queues_exe where qstat=1 limit 1');
        return $CurLastOpenQ;
    }

    public function getTopDSV()
    {
        $SQLStr = "select c.code,c.country,r.username,ifnull(sum(p.amt),0) activedownlinePH,date_format(now(),'%d %M') dt from ph p ";
		$SQLStr = $SQLStr . " inner join users u on p.user_id=u.id ";
		$SQLStr = $SQLStr . " inner join users r on u.referral_id=r.id ";
		$SQLStr = $SQLStr . " left join country c on r.country=c.code ";
		$SQLStr = $SQLStr . " where (`status` is null or `status`<>2) and month(p.created_at)=3 and year(p.created_at)=2016 ";
		$SQLStr = $SQLStr . " group by r.id order by activedownlinePH desc limit 20 ";

		$TopDSV = DB::select($SQLStr);
        
        return $TopDSV;
    }


    public function getUniTree(Request $request)
    {
        if($request->id)
        {
            $id = Crypt::decrypt($request->id);
        }
        else
        {
            $id = $this->user->id;
        }

        $current_user = User::find($id);
        $users = User::where('referral_id',$id)->orderby('created_at','desc')->get();

		$users2 = DB::select('select 1 lvl,m.id x1,l1.id x2, 0 x3, 0 x4,l1.id,l1.referral_id,l1.username,getTitle(l1.level_id) title,getTitleColor(l1.level_id) color,getPHActive(l1.id) ph,getGH(l1.id) gh,l1.country from users m inner join users l1 on m.id=l1.referral_id  where m.id=? union all select 2 lvl,m.id x1,l1.id x2, l2.id x3, 0 x4,l2.id,l2.referral_id,l2.username,getTitle(l2.level_id) title,getTitleColor(l2.level_id) color,getPHActive(l2.id) ph,getGH(l2.id) gh,l2.country from users m inner join users l1 on m.id=l1.referral_id inner join users l2 on l1.id=l2.referral_id  where m.id=? union all select 3 lvl,m.id x1,l1.id x2, l2.id x3, l3.id x4,l3.id,l3.referral_id,l3.username,getTitle(l3.level_id) title,getTitleColor(l3.level_id) color,getPHActive(l3.id) ph,getGH(l3.id) gh,l3.country from users m inner join users l1 on m.id=l1.referral_id inner join users l2 on l1.id=l2.referral_id  inner join users l3 on l2.id=l3.referral_id  where m.id=? order by x1,x2,x3,x4', [$id,$id,$id]);

		//return ($users2);
		return view('unitree')
            ->with('users',$users)
            ->with('user',$this->user)
            ->with('users2',$users2)
            ->with('current_user',$current_user);
    }

    public function processUnilevel_old()
    {   
		
		ini_set('max_execution_time', 3000);

		//track active exe
		$check_id = DB::select('select id from calc_log where datediff(now(),dt)=0 ');
		$chk_id = 0;
		foreach($check_id as $output){$chk_id = $output->id; }
		if ($chk_id != 0){$process = 0;}
		else
		{
			//check if calculate title is completed already or not
			$check_id = DB::select('select id from calc_title_log where datediff(now(),dt)=0 and stat_title=2');
			$chk_title_id = 0;
			foreach($check_id as $output){$chk_title_id = $output->id; }
			if ($chk_title_id == 0){$process = 0;}else{$process = 1;}
		}

		if ($process == 0)
		{
			//do nothing 1. if already run 2. if title calculation not completed yet..
			return 'no calculation';
		}
		else
		{
			
			DB::insert('insert into calc_log (`dt`,`stat`) values(now(),1)');

			$record_id = DB::select('select LAST_INSERT_ID() as id');
			$calc_id = 0;
			foreach($record_id as $output)
			{
				$calc_id = $output->id;            
			}

			//DB::select('call setBuildLeader()');

			$SQLStr=" select p.id phid,u.gene,u.id uid,p.amt,getPHCold(p.user_id,p.amt) as netamt, ";
			$SQLStr=$SQLStr . " ifnull(u1.id,0) u1id, ifnull(u2.id,0) u2id, ifnull(u3.id,0) u3id,ifnull(u4.id,0) u4id, ifnull(u5.id,0) u5id, ifnull(u6.id,0) u6id, ";
			$SQLStr=$SQLStr . " ifnull(u7.id,0) u7id, ifnull(u8.id,0) u8id, ifnull(u9.id,0) u9id,ifnull(u10.id,0) u10id, ifnull(u11.id,0) u11id, ifnull(u12.id,0) u12id, ";
			$SQLStr=$SQLStr . " ifnull(l1.level1,0) lvl1,ifnull(l2.level2,0) lvl2,ifnull(l3.level3,0) lvl3, ";
			$SQLStr=$SQLStr . " ifnull(l4.level4,0) lvl4,ifnull(l5.level5,0) lvl5,ifnull(l6.level6,0) lvl6, ";
			$SQLStr=$SQLStr . " ifnull(l7.level7,0) lvl7,ifnull(l8.level8,0) lvl8,ifnull(l9.level9,0) lvl9, ";
			$SQLStr=$SQLStr . " ifnull(l10.level10,0) lvl10,ifnull(l11.level11,0) lvl11,ifnull(l12.level12,0) lvl12 ";
			$SQLStr=$SQLStr . " from ph p inner join users u on p.user_id=u.id ";
			$SQLStr=$SQLStr . " left join users u1 on u.referral_id=u1.id left join levels l1 on u1.level_id=l1.id ";
			$SQLStr=$SQLStr . " left join users u2 on u1.referral_id=u2.id left join levels l2 on u2.level_id=l2.id ";
			$SQLStr=$SQLStr . " left join users u3 on u2.referral_id=u3.id left join levels l3 on u3.level_id=l3.id ";
			$SQLStr=$SQLStr . " left join users u4 on u3.referral_id=u4.id left join levels l4 on u4.level_id=l4.id ";
			$SQLStr=$SQLStr . " left join users u5 on u4.referral_id=u5.id left join levels l5 on u5.level_id=l5.id ";
			$SQLStr=$SQLStr . " left join users u6 on u5.referral_id=u6.id left join levels l6 on u6.level_id=l6.id ";
			$SQLStr=$SQLStr . " left join users u7 on u6.referral_id=u7.id left join levels l7 on u7.level_id=l7.id ";
			$SQLStr=$SQLStr . " left join users u8 on u7.referral_id=u8.id left join levels l8 on u8.level_id=l8.id ";
			$SQLStr=$SQLStr . " left join users u9 on u8.referral_id=u9.id left join levels l9 on u9.level_id=l9.id ";
			$SQLStr=$SQLStr . " left join users u10 on u9.referral_id=u10.id left join levels l10 on u10.level_id=l10.id ";
			$SQLStr=$SQLStr . " left join users u11 on u10.referral_id=u11.id left join levels l11 on u11.level_id=l11.id ";
			$SQLStr=$SQLStr . " left join users u12 on u11.referral_id=u12.id left join levels l12 on u12.level_id=l12.id ";
			$SQLStr=$SQLStr . " where datediff(p.created_at,now())=-1 and calc=0 ";
			$ph = DB::select($SQLStr);
			foreach($ph as $output)
			{

				$netamt = $output->netamt;
				$phid = $output->phid;
				$uid = $output->uid;

				$ul1 = $output->u1id;
				$rate1 = $output->lvl1;
				$referral_amt1 =  round($rate1/100 * $netamt,8); 
				//eliminate 0 and 1
				if($ul1 > 1 && $rate1>0){DB::insert('insert into unilevels (created_at,amt,user_id,referral_user_id,ph_id,status) values(now(),?,?,?,?,0)',[$referral_amt1,$ul1,$uid,$phid]);}

				$ul2 = $output->u2id;
				$rate2 = $output->lvl2;
				$referral_amt2 =  round($rate2/100 * $netamt,8); 
				if($ul2 > 1 && $rate2>0){DB::insert('insert into unilevels (created_at,amt,user_id,referral_user_id,ph_id,status) values(now(),?,?,?,?,0)',[$referral_amt2,$ul2,$uid,$phid]);}

				$ul3 = $output->u3id;
				$rate3 = $output->lvl3;
				$referral_amt3 =  round($rate3/100 * $netamt,8); 
				if($ul3 > 1 && $rate3>0){DB::insert('insert into unilevels (created_at,amt,user_id,referral_user_id,ph_id,status) values(now(),?,?,?,?,0)',[$referral_amt3,$ul3,$uid,$phid]);}
				
				$ul4 = $output->u4id;
				$rate4 = $output->lvl4;
				$referral_amt4 =  round($rate4/100 * $netamt,8); 
				if($ul4 > 1 && $rate4>0){DB::insert('insert into unilevels (created_at,amt,user_id,referral_user_id,ph_id,status) values(now(),?,?,?,?,0)',[$referral_amt4,$ul4,$uid,$phid]);}
				
				$ul5 = $output->u5id;
				$rate5 = $output->lvl5;
				$referral_amt5 =  round($rate5/100 * $netamt,8); 
				if($ul5 > 1 && $rate5>0){DB::insert('insert into unilevels (created_at,amt,user_id,referral_user_id,ph_id,status) values(now(),?,?,?,?,0)',[$referral_amt5,$ul5,$uid,$phid]);}
				
				$ul6 = $output->u6id;
				$rate6 = $output->lvl6;
				$referral_amt6 =  round($rate6/100 * $netamt,8); 
				if($ul6 > 1 && $rate6>0){DB::insert('insert into unilevels (created_at,amt,user_id,referral_user_id,ph_id,status) values(now(),?,?,?,?,0)',[$referral_amt6,$ul6,$uid,$phid]);}
				
				$ul7 = $output->u7id;
				$rate7 = $output->lvl7;
				$referral_amt7 =  round($rate7/100 * $netamt,8); 
				if($ul7 > 1 && $rate7>0){DB::insert('insert into unilevels (created_at,amt,user_id,referral_user_id,ph_id,status) values(now(),?,?,?,?,0)',[$referral_amt7,$ul7,$uid,$phid]);}
				
				$ul8 = $output->u8id;
				$rate8 = $output->lvl8;
				$referral_amt8 =  round($rate8/100 * $netamt,8); 
				if($ul8 > 1 && $rate8>0){DB::insert('insert into unilevels (created_at,amt,user_id,referral_user_id,ph_id,status) values(now(),?,?,?,?,0)',[$referral_amt8,$ul8,$uid,$phid]);}
				
				$ul9 = $output->u9id;
				$rate9 = $output->lvl9;
				$referral_amt9 =  round($rate9/100 * $netamt,8); 
				if($ul9 > 1 && $rate9>0){DB::insert('insert into unilevels (created_at,amt,user_id,referral_user_id,ph_id,status) values(now(),?,?,?,?,0)',[$referral_amt9,$ul9,$uid,$phid]);}
				
				$ul10 = $output->u10id;
				$rate10 = $output->lvl10;
				$referral_amt10 =  round($rate10/100 * $netamt,8); 
				if($ul10 > 1 && $rate10>0){DB::insert('insert into unilevels (created_at,amt,user_id,referral_user_id,ph_id,status) values(now(),?,?,?,?,0)',[$referral_amt10,$ul10,$uid,$phid]);}
				
				$ul11 = $output->u11id;
				$rate11 = $output->lvl11;
				$referral_amt11 =  round($rate11/100 * $netamt,8); 
				if($ul11 > 1 && $rate11>0){DB::insert('insert into unilevels (created_at,amt,user_id,referral_user_id,ph_id,status) values(now(),?,?,?,?,0)',[$referral_amt11,$ul11,$uid,$phid]);}
				
				$ul12 = $output->u12id;
				$rate12 = $output->lvl12;
				$referral_amt12 =  round($rate12/100 * $netamt,8); 
				if($ul12 > 1 && $rate12>0){DB::insert('insert into unilevels (created_at,amt,user_id,referral_user_id,ph_id,status) values(now(),?,?,?,?,0)',[$referral_amt12,$ul12,$uid,$phid]);}

				//set already processed
				DB::table('ph')->where('id',$phid)->update(["calc" => 1]);

			}

			//DB::table('calc_log')->where('id',$calc_id)->update(["stat" => 2]);
			DB::update('update calc_log set stat=2,`end`=now() where id=' . $calc_id);

		}

		return "done";
	}


    public function processUnilevel_march()
    {   
		
		ini_set('max_execution_time', 3000);

		//track active exe
		$check_id = DB::select('select id from calc_log where datediff(now(),dt)=0 ');
		$chk_id = 0;
		foreach($check_id as $output){$chk_id = $output->id; }
		if ($chk_id != 0){$process = 0;}
		else
		{
			//check if calculate title is completed already or not
			$check_id = DB::select('select id from calc_title_log where datediff(now(),dt)=0 and stat_title=2');
			$chk_title_id = 0;
			foreach($check_id as $output){$chk_title_id = $output->id; }
			if ($chk_title_id == 0){$process = 0;}else{$process = 1;}
		}
		if ($process == 0)
		{
			//do nothing 1. if already run 2. if title calculation not completed yet..
			return 'no calculation';
		}
		else
		{
			
			DB::insert('insert into calc_log (`dt`,`stat`) values(now(),1)');

			$record_id = DB::select('select LAST_INSERT_ID() as id');
			$calc_id = 0;
			foreach($record_id as $output)
			{
				$calc_id = $output->id;            
			}

			//DB::select('call setBuildLeader()');

			$SQLStr=" select p.id phid,u.gene,u.id uid,p.amt,getPHCold(p.user_id,p.amt) as netamt ";
			$SQLStr=$SQLStr . " from ph p inner join users u on p.user_id=u.id ";
			$SQLStr=$SQLStr . " where datediff(p.created_at,now())=-1 and calc=0 ";
			//$SQLStr=$SQLStr . " where datediff(p.created_at,'2016-03-11')=0  ";
			$ph = DB::select($SQLStr);
			foreach($ph as $output)
			{
				$netamt = $output->netamt;
				$phid = $output->phid;
				$uid = $output->uid;
				$gene = $output->gene;

				$max_level = 12;
        
				$array = explode(',',$gene);
				rsort($array);
				array_shift($array);

				//$msg = $msg . "<br>";
				$l=1;
				foreach($array as $outputlvl)
				{
					$rate = Self::getUserUnilevelRate($outputlvl,$l);
            
					if($rate)
					{
						//$msg = $msg . "lvl=" . $l . ", phid=" . $phid . ", sponsor=" . $outputlvl . "<br>";
						app('App\Http\Controllers\ReferralController')->addUnilevelBonus($phid,$outputlvl,$l,$netamt);
						if($l==$max_level) break;
						$l++;
					}                        
				}

				//set already processed
				DB::table('ph')->where('id',$phid)->update(["calc" => 1]);

			}

			//DB::table('calc_log')->where('id',$calc_id)->update(["stat" => 2]);
			DB::update('update calc_log set stat=2,`end`=now() where id=' . $calc_id);

		}

		//return "done<br>" . $msg ;
		return "done";
	}

    public function processUnilevel()
    {   
		
		ini_set('max_execution_time', 3000);

		//track active exe
		$check_id = DB::select('select id from calc_log where datediff(now(),dt)=0 ');
		$chk_id = 0;
		foreach($check_id as $output){$chk_id = $output->id; }
		if ($chk_id != 0){$process = 0;}
		else
		{
			//check if calculate title is completed already or not
			$check_id = DB::select('select id from calc_title_log where datediff(now(),dt)=0 and stat_title=2');
			$chk_title_id = 0;
			foreach($check_id as $output){$chk_title_id = $output->id; }
			if ($chk_title_id == 0){$process = 0;}else{$process = 1;}
		}
		if ($process == 0)
		{
			//do nothing 1. if already run 2. if title calculation not completed yet..
			return 'no calculation';
		}
		else
		{
			
			DB::insert('insert into calc_log (`dt`,`stat`) values(now(),1)');

			$record_id = DB::select('select LAST_INSERT_ID() as id');
			$calc_id = 0;
			foreach($record_id as $output)
			{
				$calc_id = $output->id;            
			}

			//DB::select('call setBuildLeader()');

			$SQLStr=" select p.id phid,u.gene,u.id uid,p.amt,getPHCold(p.user_id,p.amt) as netamt ";
			$SQLStr=$SQLStr . " from ph p inner join users u on p.user_id=u.id ";
			$SQLStr=$SQLStr . " where datediff(p.created_at,now())=-1 and calc=0 ";
			//$SQLStr=$SQLStr . " where datediff(p.created_at,'2016-03-11')=0  ";
			$ph = DB::select($SQLStr);
			foreach($ph as $output)
			{
				$netamt = $output->netamt;
				$phid = $output->phid;
				$uid = $output->uid;
				$gene = $output->gene;

				$max_level = 12;
        
				$array = explode(',',$gene);
				rsort($array);
				array_shift($array);

				//$msg = $msg . "<br>";
				$l=1;
				foreach($array as $outputlvl)
				{
					$rate = Self::getUserUnilevelRate($outputlvl,$l);
            
					if($rate)
					{
						//$msg = $msg . "lvl=" . $l . ", phid=" . $phid . ", sponsor=" . $outputlvl . "<br>";
						app('App\Http\Controllers\ReferralController')->addUnilevelBonus($phid,$outputlvl,$l,$netamt);
						if($l==$max_level) break;
						$l++;
					}                        
				}

				//set already processed
				DB::table('ph')->where('id',$phid)->update(["calc" => 1]);

			}

			//DB::table('calc_log')->where('id',$calc_id)->update(["stat" => 2]);
			DB::update('update calc_log set stat=2,`end`=now() where id=' . $calc_id);

		}

		//return "done<br>" . $msg ;
		return "done";
	}

	
	public function verifyEmail(Request $request)
    {
        if($request != '')
        {
            $users = db::update('update users set active = "1" where verify_email_token = "'.$request->token.'"');
			
			$email = db::select('select email from users where verify_email_token = "'.$request->token.'"');

			//send email confirmation
			$subject = 'BTCPanda Confirmation';
			$email = $email['0']->email;
			
			Mail::send('emails.emailRegisterConfirmation', [], function($message) use ($subject, $email) {
		   $message->to($email)
			->subject($subject);
			});	
			return redirect('login')
						->withErrors([
							'active' => 'Successfully activate your account. You can login now.'
						]);
        }
        else
        {
            return 'Invalid Token. Email confirmation failed.';
        }
	

    }

	public function SetSession(user $user)
    {
        //set admin session
        //if($user->isAdmin())
		if (in_array(session('AdminLvl'),array(1,2,3,4)))
		{}
		else
		{
			if($user->adm > 0)
			{
				session(['has_admin_access' => $user->id]);
				session(['isAdmin' => 'true']);
				session(['AdminLvl' => $user->adm]);
			}
        }
    }
	public function DestroySession()
    {
		Session::flush();
    }
}