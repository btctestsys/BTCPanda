<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    protected $redirectPath = '/dashboard';
    protected $loginPath = '/login';
    protected $redirectAfterLogout = '/login';
    
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'country' => 'required',
            'password' => 'required|confirmed|min:6',
            'referral' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::where('username',$data['referral'])->first();
        
        if($user)
        {        
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
				'mobile' => $data['mobile'],
                'country' => $data['country'],
				'verify_email_token' => $data['_token'],
                'password' => bcrypt($data['password']),
                'username' => str_replace(' ','_',$data['username']),
                'referral_id' => $user->id,
        ]);
        }
        else
        {            
            abort(500,"Referral username does not exist");
        }
    }
}
