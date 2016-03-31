<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Verifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
        $table->string('country',2);
        $table->integer('otp');
        $table->string('mobile');
        $table->tinyInteger('mobile_verified');
        $table->string('identification');
        $table->tinyInteger('identification_verified');
        $table->text('youtube');
        $table->tinyInteger('youtube_verified');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
        $table->dropColumn('country');
        $table->dropColumn('otp');
        $table->dropColumn('mobile');
        $table->dropColumn('mobile_verified');
        $table->dropColumn('identification');
        $table->dropColumn('identification_verified');
        $table->dropColumn('youtube');
        $table->dropColumn('youtube_verified');
        });
    }
}