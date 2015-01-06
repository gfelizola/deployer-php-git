<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServidoresProjetosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('servidores_projetos', function(Blueprint $table)
		{
			$table->integer('projeto_id');
			$table->integer('servidor_id');
			$table->string('root');
			$table->string('tag_atual')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('servidores_projetos');
	}

}
