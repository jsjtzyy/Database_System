<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('userID');
        $table->string('restaurant_name');
        $table->string('dish_category');
        $table->text('content');
        $table->string('location');
        $table->timestamp('start_at');
        $table->timestamp('created_at');
        $table->string('phone_number');
        $table->string('Email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
