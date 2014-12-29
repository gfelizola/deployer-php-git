<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServidoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('servidores', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('tipo_acesso');
			$table->string('nome');
			$table->string('endereco');
			$table->string('usuario');
			$table->string('senha');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('servidores');
	}

}
