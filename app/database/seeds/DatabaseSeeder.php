<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// DB::table('deploys')->delete();
		// DB::table('historicos')->delete();

		$this->call('UserTableSeeder');
		$this->call('ProjetoTableSeeder');
	}
}

class UserTableSeeder extends Seeder {

    public function run()
    {
		DB::table('users')->delete();    	

        User::create(array(
        	"username" => "gfelizola",
        	"nome"     => "Gustavo Felizola",
        	"avatar"   => "https://secure.gravatar.com/avatar/50fda58027e786277d6e06ce77aa5d86?d=https%3A%2F%2Fd3oaxc4q5k2d6q.cloudfront.net%2Fm%2F902c81e8bd81%2Fimg%2Fdefault_avatar%2F32%2Fuser_blue.png&s=120",
        	"skin"     => User::SKIN_BLUE,
        	"layout"   => User::LAYOUT_FIXED,
        ));
    }
}

class ProjetoTableSeeder extends Seeder {
	public function run()
    {
		DB::table('projetos')->delete();    	

        for ($i=0; $i < 30; $i++) { 
        	Projeto::create( array(
        		"nome"         => "Teste $i", 
        		"repo"         => "http://repo/$i",
        		"repo_usuario" => "teste",
        		"repo_senha"   => "123123",
        		"server_root"  => "/var/www",
        		"repo_branch"  => "master",
        	));
        }
        
    }
}