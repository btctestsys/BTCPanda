<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gh extends Model
{
    protected $table = 'gh';

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function match()
    {
    	return $this->belongsTo('App\Match');
    }
}
