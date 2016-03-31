<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $table = 'matches';

    public function ph()
    {
    	return $this->belongsTo('App\Ph');
    }

        public function gh()
    {
    	return $this->belongsTo('App\Gh');
    }
}
