<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Wallets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
        CREATE TABLE `wallets` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
        `user_id` int(11) DEFAULT NULL,
        `wallet_address` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
        `current_balance` decimal(16,8) DEFAULT NULL,
        `pending_balance` decimal(16,8) DEFAULT NULL,
        `available_balance` decimal(16,8) DEFAULT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        ');

        DB::statement('
        CREATE TABLE `wallet_bamboos` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
        `user_id` int(11) DEFAULT NULL,
        `wallet_address` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
        `current_balance` decimal(16,8) DEFAULT NULL,
        `pending_balance` decimal(16,8) DEFAULT NULL,
        `available_balance` decimal(16,8) DEFAULT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('wallets');
        Schema::drop('wallet_bamboos');
    }
}
