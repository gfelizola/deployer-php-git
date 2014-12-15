<?php
use Carbon\Carbon;

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
		$this->call('HistoricoTableSeeder');
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
        	"skin"     => User::SKIN_BLACK,
        	"layout"   => User::LAYOUT_FIXED,
        ));    	

        for ($i=0; $i < 5; $i++) { 
        	User::create( array(
        		"nome"     => "Teste $i", 
        		"username" => "teste$i",
        		"skin"     => User::SKIN_BLUE,
        		"layout"   => User::LAYOUT_FIXED,
        	));
        }

        $this->command->info('Tabela de usuários preenchida');
    }
}

class ProjetoTableSeeder extends Seeder {
	public function run()
    {
		DB::table('projetos')->delete();    	

        for ($i=0; $i < 5; $i++) { 
        	Projeto::create( array(
        		"nome"         => "Teste $i", 
        		"repo"         => "http://repo/$i",
        		"repo_usuario" => "teste",
        		"repo_senha"   => "123123",
        		"server_root"  => "/var/www",
        		"repo_branch"  => "master",
        	));
        }

        $this->command->info('Tabela de projetos preenchida');
        
    }
}

class HistoricoTableSeeder extends Seeder {

	public function run()
    {
    	$usuario = User::all()->first();
    	$projeto = Projeto::all()->first();

		DB::table('historicos')->delete();    	

        for ($i=0; $i < 30; $i++) { 
        	Historico::create( array(
        		"tipo"       => Historico::TipoUsuario, 
        		"descricao"  => "Usuário novo $i",
        		"user_id"    => $usuario->id
        	));

        	Historico::create( array(
        		"tipo"       => Historico::TipoProjeto, 
        		"descricao"  => "Novo projeto $i",
        		"user_id"    => $usuario->id,
        		"projeto_id" => $projeto->id
        	));

        	Historico::create( array(
        		"tipo"       => Historico::TipoDeploy, 
        		"descricao"  => "Deploy novo $i",
        		"user_id"    => $usuario->id,
        		"projeto_id" => $projeto->id
        	));

        	if ( $i < 20 ) {
        		Historico::create( array(
	        		"tipo"       => Historico::TipoRollBack, 
	        		"descricao"  => "Rollback novo $i",
	        		"user_id"    => $usuario->id,
	        		"projeto_id" => $projeto->id
	        	));
        	}
        }

        $this->command->info('Tabela de historicos preenchida');
        
    }
}