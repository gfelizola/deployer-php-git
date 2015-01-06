<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeploysTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deploys', function($table)
        {
            $table->increments('id');
            $table->string('tag');
            $table->string('descricao')->nullable();
            $table->string('infos')->nullable();
            $table->integer('projeto_id');
            $table->integer('user_id');
            $table->integer('servidor_id');
            $table->integer('status')->nullable();
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
        Schema::drop('deploys');
    }

}
