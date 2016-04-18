<?php
namespace App\Http\Controllers;

use Auth;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\User;
use App\Classes\Custom;

use Hash;
use Crypt;
use Storage;
use File;
use Response;
use Mail;

class SettingController extends Controller
{
    private $user;

    public function __construct()
    {
    	$this->user = Auth::user();
    }

    public function getIndex()
    {
      #Check Setting------------------------
      $uid = $this->user->id;
      $query = "SELECT `country`, `mobile`, `wallet1` FROM users WHERE id = '$uid'";
		$check = DB::select($query);

      if($check['0']->mobile == '' or $check['0']->country == ''){
         $act = 1;
      }else{
         $act = 0;
      }
      #-------------------------------------

		$country = DB::select('SELECT c.code,c.country,p.phone FROM country c left join phonecoderaw p on c.code=p.code');

        return view('settings')
         ->with('country',$country)
         ->with('act',$act)
			->with('user',$this->user);
    }

    public function postMobileUpdate(Request $request)
    {
        //strip + - etc.
        $mobile = str_replace(array('+','-',' ','.','#','*'), '', $request->mobile);

        //find duplicate
        $check = User::where('mobile',"+".$mobile)->count();

        if($check)
        {
            abort(500,'Duplicate mobile number detected');
        }
        else
        {
			$country = DB::select('select if(country<>\'\',checkcountrybyphone(\'+' . $mobile . '\',country),\'true\') validcountry from users where id=' . $this->user->id);
			foreach($country as $output)
			{
				$validcountry = $output->validcountry;
			}
			if($validcountry == 'true')
			{
				$user = User::find($this->user->id);
				$user->mobile = "+".$mobile;
				$user->save();
			}
			else
			{
				abort(500,'Invalid phone number. Phone number must match the country selected.');
			}
        }

        return back();
    }

    public function postIdentificationUpdate(Request $request)
    {
        $user = User::find($this->user->id);
        $user->identification = $request->identification;
        $user->save();

        return back();
    }

    public function postYoutubeUpdate(Request $request)
    {
        $user = User::find($this->user->id);
        $user->youtube = $request->youtube;
        $user->youtube_verified = -1;
        $user->save();

        return back();
    }

    public function postProfileUpdate(Request $request)
    {
		$country = DB::select('select if(mobile<>\'\',checkcountrybyphone(mobile,\'' . $request->country . '\'),\'true\') validcountry from users where id=' . $this->user->id);
        foreach($country as $output)
        {
            $validcountry = $output->validcountry;
        }
        if($validcountry == 'true')
        {
			$user = User::find($this->user->id);
			//$user->name = $request->name;
			//$user->email = $request->email;
			$user->country = $request->country;
			$user->save();

         ##Audit-----
         ##1 = Update Country Information at Profile Details
         Custom::auditTrail($this->user->id, '1', session('user_id'));

			return back();
        }
        else
        {
            abort(500,'Invalid country. Selected country must match the country where phone number is registered.');
        }

    }

    public function postMobileVerify(Request $request)
    {
        $user = User::find($this->user->id);

        if($user->otp == $request->otp)
        {
            $user->mobile_verified = 1;
            $user->save();
            return back();
        }
        else
        {
            abort(500,'Wrong OTP');
        }
    }

    public function postIdentificationUpload(Request $request)
    {
        //init
        $path = "https://s3-ap-southeast-1.amazonaws.com/btcpanda/identification/";
        $hash = hash("md5",$this->user->identification);
        $ext = "png";
        $filename = $hash.".".$ext;
        $tmpname = $request->file('identification_file')->getfileName();

        if ($request->file('identification_file')->isValid())
        {
            //move
            $request->file('identification_file')->move("/tmp");

            //store
            Storage::disk('s3')->put("/identification/$filename",File::get("/tmp/$tmpname"),'public');

            //update user table
            User::where('id', $this->user->id)->update(["identification_verified" => -1]);

            return back();
        }
        else
        {
            abort(500,"Error Uploading");
        }
    }

    public function postChangePassword(request $request)
    {
        $user = User::find($this->user->id);
        if($user->otp == $request->otp)
        {

			$newpass = $request->newpass;
			$cnewpass = $request->cnewpass;
			if ($newpass!=$cnewpass)
			{
				abort(500,'New password does not match.' );
			}

			$cpass = bcrypt($request->cpass);
			$result = DB::select('select id from users where `password`=\'' . $cpass . '\' and id=' . $this->user->id);
			if (is_null($result)) {
				abort(500,'Invalid current password.');
			}

			$cpass = $request->cpass;

            $user->password = bcrypt($request->newpass);
            $user->save();

            return Custom::popup('Password Updated','/settings');
            return back();
        }
        else
        {
            abort(500,'Wrong OTP');
        }
    }

    public function postChangeWallet(request $request)
    {
        $user = User::find($this->user->id);
		if($user->otp == $request->otp)
        {

			$wallet1 = trim($request->wallet1);
			$wallet2 = trim($request->wallet2);
			if (strlen($wallet1)>0){
			if (!Self::checkAddress($wallet1)){abort(500,'Invalid Wallet #1 Address'); }}
			if (strlen($wallet2)>0){
			if (!Self::checkAddress($wallet2)){abort(500,'Invalid Wallet #2 Address'); }}

            $user->wallet1 = $wallet1;
            $user->wallet2 = $wallet2;
            $user->save();

            return Custom::popup('Wallet Updated','/settings');
            return back();
        }
		else
		{
			abort(500,'Wrong OTP');
		}
    }

    public function postChangeMessaging(request $request)
    {
        $user = User::find($this->user->id);

			$messaging = $request->messaging;

            $user->messaging = $messaging;
            $user->save();

            ##Audit-----
            ##2 = Update OTP Delivery at Profile Details
            Custom::auditTrail($this->user->id, '2', session('user_id'));
            
            return Custom::popup('Profile updated','/settings');
            return back();
    }

    public function postChangeAdmin(request $request)
    {
        $user = User::find($this->user->id);
		if(session('isAdmin')=='true')
		{

			$email = $request->email;
			$mobile = $request->mobile;
			$pwd = $request->pwd;
			$otp = $request->votp;
			$adminlvl = $request->adminlvl;
			$suspension = $request->suspension;

            $user->email = $email;
			if ($mobile=='')
			{
				$user->mobile_verified = '0';
				$user->otp = '0';
			}
			if ($pwd!='')
			{
				$user->password = bcrypt($pwd);
			}
			if (in_array(session('AdminLvl'),array(2,3,4)))
            {
				$user->suspend = $suspension;
			}
			if (in_array(session('AdminLvl'),array(3,4)))
            {
				$wallet1 = trim($request->wallet1);
				$wallet2 = trim($request->wallet2);
				if (strlen($wallet1)>0){
				if (!Self::checkAddress($wallet1)){abort(500,'Invalid Wallet #1 Address'); }}
				if (strlen($wallet2)>0){
				if (!Self::checkAddress($wallet2)){abort(500,'Invalid Wallet #2 Address'); }}

	            $user->otp = $otp;
				$user->wallet1 = $wallet1;
				$user->wallet2 = $wallet2;
			}
			if (in_array(session('AdminLvl'),array(4)))
            {
				$user->adm = $adminlvl;
			}
            $user->mobile = $mobile;
            $user->save();

            return Custom::popup('Vital Settings Updated','/settings');
            return back();
		}
		else
		{
			abort(500,'Unauthorized access');
		}

    }
   public function checkAddress($address){
      try
      {
          $blockchain_current_balance = file_get_contents("https://blockchain.info/q/addressbalance/$address");
          return 1;
      }
      catch(\Exception $e)
      {
          //abort(500,'Too many sync requests to Blockchain (blockchain.info)');
          return 0;
      }
   }
	public function checkAddress2($address)
	{
		$origbase58 = $address;
		$dec = "0";

		for ($i = 0; $i < strlen($address); $i++)
		{
			$dec = bcadd(bcmul($dec,"58",0),strpos("123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz",substr($address,$i,1)),0);
		}

		$address = "";

		while (bccomp($dec,0) == 1)
		{
			$dv = bcdiv($dec,"16",0);
			$rem = (integer)bcmod($dec,"16");
			$dec = $dv;
			$address = $address.substr("0123456789ABCDEF",$rem,1);
		}

		$address = strrev($address);

		for ($i = 0; $i < strlen($origbase58) && substr($origbase58,$i,1) == "1"; $i++)
		{
			$address = "00".$address;
		}

		if (strlen($address)%2 != 0)
		{
			$address = "0".$address;
		}

		if (strlen($address) != 50)
		{
			return false;
		}

		if (hexdec(substr($address,0,2)) > 0)
		{
			return false;
		}

		return substr(strtoupper(hash("sha256",hash("sha256",pack("H*",substr($address,0,strlen($address)-8)),true))),0,8) == substr($address,strlen($address)-8);
	}

   public function resendConfirmationEmail(){

      $uid        = $this->user->id;
      $query      = "SELECT `email`,`username`,`verify_email_token`,`name` FROM users WHERE id = '$uid'";
		$userInfo   = DB::select($query);

      $subject    = 'BTCPanda Confirmation';
      $username   = $userInfo['0']->username;
      $token      = $userInfo['0']->verify_email_token;
      $email      = $userInfo['0']->email;
      $name       = $userInfo['0']->name;

      Mail::send('emails.emailRegister', ['username' => $username,'token' => $token], function($message) use ($subject, $email, $name) {
		   $message->to($email, $name)
			->subject($subject);
		});
		$sent = true;

      if($sent == true){
         return 1;
		}
   }

}
