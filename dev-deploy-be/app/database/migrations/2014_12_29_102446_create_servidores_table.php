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
			$table->string('endereco')->nullable();
			$table->string('usuario')->nullable();
			$table->string('senha')->nullable();
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
