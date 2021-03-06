<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("historicos", function($table)
    	{
	        $table->increments("id");
	        $table->integer("tipo");
	        $table->string("descricao");
	        $table->string('infos')->nullable();
	        $table->integer("projeto_id")->nullable();
	        $table->integer("deploy_id")->nullable();
	        $table->integer("user_id");
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
		Schema::drop("historicos");
	}

}
