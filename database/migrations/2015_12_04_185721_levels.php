<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Levels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
        CREATE TABLE `levels` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(255) DEFAULT NULL,
        `level1` decimal(10,1) DEFAULT NULL,
        `level2` decimal(10,1) DEFAULT NULL,
        `level3` decimal(10,1) DEFAULT NULL,
        `level4` decimal(10,1) DEFAULT NULL,
        `level5` decimal(10,1) DEFAULT NULL,
        `level6` decimal(10,1) DEFAULT NULL,
        `level7` decimal(10,1) DEFAULT NULL,
        `level8` decimal(10,1) DEFAULT NULL,
        `level9` decimal(10,1) DEFAULT NULL,
        `level10` decimal(10,1) DEFAULT NULL,
        `level11` decimal(10,1) DEFAULT NULL,
        `level12` decimal(10,1) DEFAULT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ');

        DB::statement('
        CREATE TABLE `level_referrals` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(255) DEFAULT NULL,
        `referral_rate` int(11) DEFAULT NULL,
        `ph_limit` decimal(16,8) DEFAULT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ');

        DB::statement("
        INSERT INTO `levels` (`id`, `name`, `level1`, `level2`, `level3`, `level4`, `level5`, `level6`, `level7`, `level8`, `level9`, `level10`, `level11`, `level12`)
        VALUES
        (1, 'Helper', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
        (2, 'Fundraiser', 3.0, 2.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
        (3, 'Charity Helper', 3.0, 2.0, 1.5, 1.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
        (4, 'Angel Helper', 3.0, 2.0, 1.5, 1.0, 1.0, 0.5, NULL, NULL, NULL, NULL, NULL, NULL),
        (5, 'Venture Helper', 3.0, 2.0, 1.5, 1.0, 1.0, 0.5, 0.5, 0.5, 0.5, NULL, NULL, NULL),
        (6, 'Philanthropist', 3.0, 2.0, 1.5, 1.0, 1.0, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5);
        ");

        DB::statement("
        INSERT INTO `level_referrals` (`id`, `name`, `referral_rate`, `ph_limit`)
        VALUES
        (1, '0-5', 5, 15.00000000),
        (2, '6-10', 6, 20.00000000),
        (3, '11-15', 7, 25.00000000),
        (4, '16-20', 8, 30.00000000),
        (5, '21-25', 9, 40.00000000),
        (6, '26-30', 10, 50.00000000);
        ");        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('levels');
        Schema::drop('level_referrals');
    }
}
