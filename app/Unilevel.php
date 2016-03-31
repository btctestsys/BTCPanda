<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unilevel extends Model
{
    protected $table = 'unilevels';

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function referral_user()
    {
    	return $this->belongsTo('App\User');
    }
}
