<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Referrals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
        CREATE TABLE `referrals` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
        `user_id` int(11) DEFAULT NULL,
        `referral_user_id` int(11) DEFAULT NULL,
        `ph_id` int(11) DEFAULT NULL,
        `amt` decimal(16,8) DEFAULT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;;
        ');

        DB::statement('
        CREATE TABLE `unilevels` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
        `user_id` int(11) DEFAULT NULL,
        `referral_user_id` int(11) DEFAULT NULL,
        `ph_id` int(11) DEFAULT NULL,
        `amt` decimal(16,8) DEFAULT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('referrals');
        Schema::drop('unilevels');
    }
}
