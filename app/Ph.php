<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ph extends Model
{
    protected $table = 'ph';

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function match()
    {
    	return $this->belongsTo('App\Match');
    }
}
