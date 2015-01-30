<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddBranchToProjetoServidorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('servidores_projetos', function(Blueprint $table)
		{
			$table->string('branch')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('servidores_projetos', function(Blueprint $table)
		{
			$table->dropColumn('branch');
		});
	}

}
