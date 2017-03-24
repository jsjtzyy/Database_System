<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfferRideTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messageOfferRide', function (Blueprint $table) {
            $table->increments('msgID');
            $table->string('category');
            $table->text('content');
            $table->date('date');
            $table->time('time');
            $table->string('destination');
            $table->string('curLocation');
            $table->integer('seatsNumber');
            $table->integer('userID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('messageOfferRide');
    }
}
