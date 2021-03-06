<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table)
    	{
	        $table->increments('id');
	        $table->string('nome')->nullable();
	        $table->string('username')->unique();
	        $table->string('avatar')->nullable();
	        $table->string('layout')->default("fixed");
	        $table->string('skin')->default("blue");
	        $table->rememberToken();
	        $table->timestamps();
	        $table->softDeletes();
	    });
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
