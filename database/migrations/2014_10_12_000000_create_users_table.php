<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->integer('referral_id');
            $table->string('password', 60);
            $table->rememberToken();
        });

        DB::table('users')->insert([
            'created_at'     =>  date('Y-m-d H:i:s'),
            'name'           =>  'Admin',
            'username'       =>  'admin',
            'password'       =>  '',
            'email'          =>  'admin@btcpanda.com',            
         ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
