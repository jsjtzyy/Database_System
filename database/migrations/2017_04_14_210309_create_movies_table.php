<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::create('movies', function (Blueprint $table) {
        $table->increments( 'id' );
        $table->integer('userID');
        $table->string('movie_name');
        $table->string('movie_category');
        $table->text('content');
        $table->string('location');
        $table->timestamp('start_at');
        $table->timestamp('end_at');
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
