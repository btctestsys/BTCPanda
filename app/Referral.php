<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    protected $table = 'referrals';

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function referral_user()
    {
    	return $this->belongsTo('App\User');
    }
}
