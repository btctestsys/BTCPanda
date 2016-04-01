<?php 

namespace App;

use DB;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'country', 'password','username','referral_id','verify_email_token','mobile'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token','verify_email_token'];

    public function wallet()
    {
        return $this->hasOne('App\Wallet');
    }

    public function walletBamboo()
    {
        return $this->hasOne('App\WalletBamboo');
    }

    public function level()
    {
        return $this->belongsTo('App\Level');
    }

    public function levelReferral()
    {
        return $this->belongsTo('App\LevelReferral');
    }

    public function isAdmin()
    {
        //$admins = explode(',', env('PAPABEARS'));
        
        //return in_array($this->id, $admins);
        return $this->adm;
    }

    public function isIDAdmin($thisid)
    {
        //$admins = explode(',', env('PAPABEARS'));
        
        //return in_array($thisid, $admins);
        $user = DB::table('users')->where('id',$thisid)->first();
        return $user->adm;

    }
}
