<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'users' , function(Blueprint $table) {
            $table->increments( 'id' );
            $table->rememberToken();
            $table->timestamps();
            $table->string( 'email' )->unique();
            $table->string( 'password' , 64 );
            $table->string( 'name' );
            $table->string( 'phoneNumber' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
