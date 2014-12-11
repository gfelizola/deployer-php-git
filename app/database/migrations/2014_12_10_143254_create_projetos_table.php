<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjetosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('projetos', function($table)
    	{
	        $table->increments('id');
	        $table->string('nome');
	        $table->string('server_root');
	        $table->string('repo');
	        $table->string('repo_usuario');
	        $table->string('repo_senha');
	        $table->string('repo_key');
	        $table->string('repo_branch');
	        $table->string('deploy_key');
	        $table->timestamps();
	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('projetos');
	}

}
