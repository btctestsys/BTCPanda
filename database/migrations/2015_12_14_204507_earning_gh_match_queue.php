<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EarningGhMatchQueue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
        CREATE TABLE `earnings` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
        `user_id` int(11) DEFAULT NULL,
        `ph_id` int(11) DEFAULT NULL,
        `amt` decimal(16,8) DEFAULT NULL,
        `status` tinyint(4) DEFAULT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        ');

        DB::statement("
        CREATE TABLE `gh` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
        `amt` decimal(16,8) DEFAULT NULL,
        `amt_filled` decimal(16,8) DEFAULT '0.00000000',
        `status` tinyint(4) DEFAULT NULL,
        `type` tinyint(4) DEFAULT NULL,
        `type_id` int(11) DEFAULT NULL,
        `user_id` int(11) DEFAULT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        ");

        DB::statement('
        CREATE TABLE `matches` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
        `ph_id` int(11) DEFAULT NULL,
        `gh_id` int(11) DEFAULT NULL,
        `amt` decimal(16,8) DEFAULT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        ');

        DB::statement('
        CREATE TABLE `wallet_queues` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
        `deleted_at` timestamp NULL DEFAULT NULL,
        `from` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
        `to` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
        `amt` decimal(16,8) DEFAULT NULL,
        `match_id` bigint(11) DEFAULT NULL,
        `status` tinyint(1) DEFAULT NULL,
        `json` text COLLATE utf8_unicode_ci,
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
        Schema::drop('earnings');
        Schema::drop('gh');
        Schema::drop('matches');
        Schema::drop('wallet_queues');
    }
}
