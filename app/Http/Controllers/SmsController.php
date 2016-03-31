<?php
namespace App\Http\Controllers;

use Auth;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\User;
use Session;
use Crypt;
use Carbon\Carbon;
use Services_Twilio;
use App\Classes\Custom;
use Mail;
use Response;

class SmsController extends Controller
{	    
    private $user;
    private $account_sid;
    private $auth_token;
    protected $mailer;

    public function __construct()
    {    	
    	$this->user = Auth::user();

		$this->account_sid = $_ENV['TWILIO_SID'];
		$this->auth_token = $_ENV['TWILIO_TOKEN'];		
    }

    public function send($to,$message)
    {
		//if logged in
		if(true) 
		{			
			//variables
			$from = "+19143154556";

			//init
			$to = "+".str_replace(array('+','-',' ','.','#','*'), '', $to);
			$message = trim($message);

			//check if valid
			if($to && $message):
				$client = new Services_Twilio($this->account_sid, $this->auth_token); 
				
				try
				{
					$data = $client->account->messages->create(array( 
					'To' => $to, 
					'From' => $from, 
					'Body' => $message,   
					));
				}
				catch(Exception $e)
				{
					return false;

					$data = '{"status": "error","data": null,"message": "$e"}';

					//output
					$data = json_decode($data);
					$json = response()->json($data, 200, array(), JSON_PRETTY_PRINT);
				}

				//output
				$data = json_decode($data);
				$json = response()->json($data, 200, array(), JSON_PRETTY_PRINT);

    			//insert log
				//'created_at' 		=> date('Y-m-d H:i:s'),
    			DB::table('sms_logs')->insert([
				'created_at' 		=> 'now()',
				'from'				=> $from,
				'to'				=> $to,
				'message'			=> $message,
				'user_id' 			=> @$this->user->id,
				'json'				=> $json
				]);

				return $json;
			else:
				return false;
			endif;
		}
		else
		{ 
			return false;
		}
    }

    public function sendOtp()
    {			
		if(!$this->user->otp):
			//init
			$id = $this->user->id;
			
			if($id):
				$otp = rand(100000,999999);
				$to = trim($this->user->mobile);
				
				//send
				if ($this->user->messaging=='email')
					{	
						//send email
						$subject = 'BTCPanda OTP';
						$message = "This is your One Time Password (OTP) ".$otp.". Once you logged out OTP will reset.";
						Mail::send('emails.email', ['key' => $message], function($message) use ($subject) {
						  $message->to($this->user->email, $this->user->name)
							->subject($subject);
						});
						$sent = true;
					}
					else
					{
						//send sms
						$sent = Self::send($to,"[BTCPANDA] This is your One Time Password (OTP) ".$otp." Once you logged out OTP will reset.");
						$sent = true;
					}

				if($sent):
					//set
					User::where('id', $this->user->id)->update(['otp' => $otp]);
				endif;

				//intercept back
				//return Custom::popup('OTP Sent','about:none');
				//return back();

				//output
				$data = '{"status": "Success","data": null,"message": "OTP succesfully sent."}';;
				$data = json_decode($data);
				return response()->json($data, 200, array(), JSON_PRETTY_PRINT);

			endif;
		else:		
			//output
			$data = '{"status": "Error","data": null,"message": "OTP exists. User need to logout and re-login to clear OTP."}';;
			$data = json_decode($data);
			return response()->json($data, 200, array(), JSON_PRETTY_PRINT);
		endif;
    }

    public function forgetPassword(Request $request)
    {			
		//check if user pair email and phone exist
		$user = User::where('user_email',$request->email)          
	            ->Where('user_phone','LIKE','%'.$request->phone.'%')
	            ->first();

		//check if user has id and tac is empty
		if(@$user->user_id && !@$user->user_tac):
			//init
			$id = $user->user_id;
			
			if($id):
				$tac = rand(100000,999999);
				$to = Self::reformatPhone($user->user_phone,$user->user_country);
				
				//send
				$sent = Self::send($to,"BK-LOGIN-TAC = ".$tac);				

				if($sent):

					//set
					User::where('user_id',$id)->update(['user_tac' => $tac]);

				endif;				

				//output
				$data = '{"status": "Success","data": null,"message": "TAC sent succesfully."}';;
				$data = json_decode($data);
				//return response()->json($data, 200, array(), JSON_PRETTY_PRINT);
				//return redirect('/forget/?showTac=1');
				return view('forget')
					->with('email',$request->email)
					->with('phone',$request->phone)
					->with('showTac',1);
			endif;
		else:
			//output
			$data = '{"status": "Error","data": null,"message": "No user found or TAC already requested."}';;
			$data = json_decode($data);
			return redirect('/forget/tac');
			return response()->json($data, 200, array(), JSON_PRETTY_PRINT);
		endif;
    }

    public function resetTacByUsername(Request $request)
    {
    	$profile = User::where('user_login', $request->username)->first();

    	if( ! $profile)
    	{
    		return response()->json(['status' => 'Failed', 'data' => null, 'message' => 'Profile not found'], 200, [], JSON_PRETTY_PRINT);
    	}

		//set
		$profile->user_tac = ($request->tac) ? $request->tac : null;

		if($profile->save())
		{
			// insert log
			DB::table('general_logs')->insert([
				'created_at'  => Carbon::now(),
				'updated_at'  => Carbon::now(),
				'user_id'     => $this->user->id,
				'profile_id'  => $profile->id,
				'description' => $profile->user_tac,
				'type'        => 'tac'
			]);

			$data = ['status' => 'Success', 'data' => null, 'message' => 'TAC reset succesfully'];
		}
		else
		{
			$data = ['status' => 'Failed', 'data' => null, 'message' => 'Failed to reset TAC'];
		}

		//output
		// $data = '{"status": "Success","data": null,"message": "TAC reset succesfully."}';;
		// $data = json_decode($data);

		return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }
    
    public function resetAllTac()
    {
		//set
		$user = new User;
		$user->update(['user_tac' => null]);

		//output
		// $data = '{"status": "Success","data": null,"message": "All TAC cleared."}';;
		// $data = json_decode($data);

		$data = ['status' => 'Success', 'data' => null, 'message' => 'All TAC cleared'];

		return response()->json($data, 200, array(), JSON_PRETTY_PRINT);
    }

    public function reformatPhone($number,$countrycode)
    {    	
    	$phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
    	
    	try 
    	{
    		$phone = $phoneUtil->parse($number,$countrycode);
    		//print_r($phone);

    	} 
    	catch (\libphonenumber\NumberParseException $e) 
    	{
    		print_r($e);
    	}

    	return $phoneUtil->format($phone,\libphonenumber\PhoneNumberFormat::E164);
    }
}