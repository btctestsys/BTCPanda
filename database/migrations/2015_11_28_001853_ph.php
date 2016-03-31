<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Ph extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE TABLE `ph` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
        `ended_at` timestamp NULL DEFAULT NULL,
        `amt` decimal(16,8) DEFAULT NULL,
        `amt_distributed` decimal(16,8) DEFAULT '0.00000000',
        `amt_taken` decimal(16,8) DEFAULT '0.00000000',
        `status` tinyint(4) DEFAULT NULL,
        `user_id` int(11) DEFAULT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ph');
    }
}
