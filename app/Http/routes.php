<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

if($_ENV['APP_ENV'] == 'production') URL::forceSchema('https');

Route::get('/', function () {
    if(Auth::check())
    {
    	return redirect('/dashboard');
    }
    else
    {
    	if($_ENV['APP_ENV'] == 'production')
		{return redirect("http://web.btcpanda.com");}
		else
		{return view('welcome');}

    }
});

Route::get('home', function () {
	return redirect('/dashboard');
});

Route::get('welcome', function () {
    return view('welcome');
});

Route::get('calc_uni','UserController@processUnilevel');

// Authentication routes
Route::get('login/{token}', 'Auth\AuthController@getLogin');
Route::get('login', 'Auth\AuthController@getLogin');
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('logout/', 'Auth\AuthController@getLogout');
Route::get('auth/logout/', 'Auth\AuthController@getLogout');

// Registration routes
Route::get('register', 'Auth\AuthController@getRegister');
Route::get('register/{referral?}', 'Auth\AuthController@getRegister');
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
// Registration jquery validation
Route::post('check/referral/{referal}', 'UserController@checkReferral');
Route::post('check/username/{u}', 'UserController@checkUsername');
Route::post('check/email/{email}', 'UserController@checkEmail');
Route::post('check/mobile/{mobile}', 'UserController@checkMobile');
Route::post('check/country/{country}', 'UserController@getCountryCode');

Route::get('verifyEmail/{token}', 'UserController@verifyEmail');

// Password reset link request routes
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

Route::get('downline', 'UserController@getDownline');

// Language routes
Route::get('lang/{locale}', function ($locale) {
    Session::put('locale',$locale);
    return redirect('/login');
});

// Login routes
Route::group(['middleware' => 'auth'], function(){
	Route::get('dashboard', function () {
		if(Auth::check())
		{
			//starting point
			$user = Auth::user();

			//self update gene
			app('App\Http\Controllers\UserController')->selfUpdateGene();

			//count referals and set levels
			$referrals_active = app('App\Http\Controllers\UserController')->countSetActiveReferrals();
			$DSV_amount = app('App\Http\Controllers\UserController')->getDSV();
			$DSV_march = app('App\Http\Controllers\UserController')->getMarchDSV();
			$TopDSV = app('App\Http\Controllers\UserController')->getTopDSV();
         $group_sales = app('App\Http\Controllers\UserController')->getGroupSales();

			app('App\Http\Controllers\UserController')->SetSession($user);

            //check if mobile verified
            if(!$user->mobile_verified)
            {
            	//app('App\Classes\Custom')->popup('Please verify your mobile number before you can proceed.','/settings');
            }

			//view
			return view('dashboard')
				->with('referrals_active',$referrals_active)
				->with('DSV_amount',$DSV_amount)
				->with('DSV_march',$DSV_march)
				->with('TopDSV',$TopDSV)
            ->with('group_sales',$group_sales)
				->with('user',$user);
		}
		else
		{
			return redirect('/login');
		}
	});

	Route::get('reset', function(){
		$user = Auth::user();
		$user = app('App\User')->find($user->id);
	    $user->otp = 0;
	    $user->save();
		//session(['isAdmin' => 'false']);
		//session(['has_admin_access' => 0]);
		app('App\Http\Controllers\UserController')->DestroySession();
    	return redirect('/logout');
	});

	Route::get('reset_title','UserController@resetAllTitle');
	Route::get('wallet','WalletController@getIndex');
	Route::post('wallet/send','WalletController@postSend');

	Route::get('bamboo','BambooController@getIndex');
	Route::post('bamboo/send','BambooController@postSend');
	Route::any('bamboo/buy','BambooController@postCheck');
	Route::post('bamboo/buyx','BambooController@postCheckx');
	Route::post('bamboo/buyy','BambooController@postChecky');
	Route::any('bamboo/check','BambooController@checkUnconfirmBalance');
	Route::get('bamboo/checkajax','BambooController@checkUnconfirmBalanceAjax');

	Route::get('referral','ReferralController@getIndex');
	Route::get('referral/{username}','ReferralController@getReferrals');
	Route::get('referral_bonus','ReferralController@getReferralBonus');

	Route::get('unilevel_bonus','ReferralController@getUnilevelBonus');

	Route::get('provide_help','PhController@getIndex');
	Route::post('provide_help/create','PhController@postCreate');
	Route::post('provide_help/nxtx','PhController@get_next_trans_inmin_inph');

	Route::get('get_help','GhController@getIndex');
	Route::get('get_help/history','GhController@getIndex');
	Route::post('get_help/create/referrals','GhController@postCreateReferrals');
	Route::post('get_help/create/unilevels','GhController@postCreateUnilevels');
	Route::post('get_help/create/earnings','GhController@postCreateEarnings');
	Route::post('add/earnings','PhController@postClaimEarnings');

	Route::get('settings','SettingController@getIndex');
	Route::post('settings/mobile/update','SettingController@postMobileUpdate');
	Route::post('settings/identification/update','SettingController@postIdentificationUpdate');
	Route::post('settings/identification/upload','SettingController@postIdentificationUpload');
	Route::post('settings/youtube/update','SettingController@postYoutubeUpdate');
	Route::post('settings/profile/update','SettingController@postProfileUpdate');
	Route::post('settings/mobile/verify','SettingController@postMobileVerify');
	Route::post('settings/password/update', 'SettingController@postChangePassword');
	Route::post('settings/wallet/update', 'SettingController@postChangeWallet');
	Route::post('settings/messaging/update', 'SettingController@postChangeMessaging');
	Route::post('settings/admin/update', 'SettingController@postChangeAdmin');
   Route::post('settings/admin/updateWallet', 'SettingController@postChangeWalletAdmin');
   Route::get('settings/admin/resendEmail', 'SettingController@resendConfirmationEmail');

	Route::any('sms/otp','SmsController@sendOtp');
	Route::get('tree/{id?}','UserController@getTree');
	Route::get('unitree/{id?}','UserController@getUniTree');
	Route::get('api/getReferrals/{id}','ReferralController@apiReferralsList');
});

// Admin routes
Route::group(['prefix' => 'master','middleware' => ['auth', 'auth.admin']], function(){
	Route::get('/', 'AdminController@getDashboard');
	Route::get('dashboard','AdminController@getDashboard');

	Route::get('users','AdminController@getUserList');
	Route::get('users/q','AdminController@getUserListQuery');
	Route::get('login/id/{id}','AdminController@login');

		//Route::get('login/tree/{id}','AdminController@viewtree');
		Route::get('bamboos','AdminController@getBamboos');
		Route::get('bamboos_daily','AdminController@getBamboosDaily');

		Route::get('ph','AdminController@getPh');
		Route::get('ph_daily','AdminController@getPhDaily');
		Route::get('ph_queue','AdminController@getPhQueue');
		Route::get('updatebalance','AdminController@getBalance');
		Route::get('updatebalanceselected','AdminController@getBalanceSelected');
		Route::get('selectph/{id}','AdminController@getAddPH');
		Route::get('removeph/{id}','AdminController@getRemovePH');
		Route::get('selectallph/','AdminController@getAddAllPH');
		Route::get('removeallph/','AdminController@getRemoveAllPH');
		Route::get('getSumAmtPhSelected','AdminController@getSumAmtPhSelected');

		Route::get('approval/earnings','AdminController@getApprovalEarnings');
		Route::post('approval/earning','AdminController@postApproveEarning');
		Route::post('approval/earning/all','AdminController@postApproveAllEarnings');

		Route::get('approval/referrals','AdminController@getApprovalReferrals');
		Route::post('approval/referral','AdminController@postApproveReferral');
		Route::post('approval/referral/all','AdminController@postApproveAllReferrals');

		Route::get('approval/unilevels','AdminController@getApprovalUnilevels');
		Route::post('approval/unilevel','AdminController@postApproveUnilevel');
		Route::post('approval/unilevel/all','AdminController@postApproveAllUnilevels');

		Route::get('approval/match/{type}','AdminController@getApprovalMatch');
		Route::get('approval/match','AdminController@getApprovalMatch');
		Route::post('approval/match/{gh_id}','GhController@match');

		Route::get('approval/kyc','AdminController@getKyc');
		Route::post('approval/kyc','AdminController@postKyc');
      Route::post('kyc/status/{user_id}','AdminController@doUpdateKycStatus');

		Route::get('resetqueue/{id}','AdminController@resetQueue');

      //Audit
		Route::get('audit_trail','AdminController@auditTrail');
      //Route::get('user_audit_trail','AdminController@userAuditTrail');
		//Report
		Route::get('phbycountry','AdminController@reportPhByCountry');
		Route::post('phbycountry','AdminController@reportPhByCountry');
});

// Test routes
Route::get('test/{to}/{message}','SmsController@send');

//Update level
Route::get('doUpdateLevel','UserController@doUpdateLevel');
