<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BambooTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bamboos', function (Blueprint $table) {
            $table->increments('id');
            $table->nullableTimestamps();
            $table->integer('from');
            $table->integer('to');
            $table->integer('amt');
            $table->integer('from_balance');
            $table->integer('to_balance');
            $table->string('notes');
            $table->decimal('rate', 16, 8);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bamboos');
    }
}
