<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Status extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('referrals', function ($table) {        
        $table->tinyInteger('status');
        });

        Schema::table('unilevels', function ($table) {        
        $table->tinyInteger('status');
        });        

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('referrals', function ($table) {        
        $table->dropColumn('status');
        });

        Schema::table('unilevels', function ($table) {        
        $table->dropColumn('status');
        });
    }
}
