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

        $this->command->info('Tabela de usuarios preenchida');
    }
}

class ServidoresTableSeeder extends Seeder {

    public function run()
    {
        
    }
}

class ProjetoTableSeeder extends Seeder {
	public function run()
    {
        DB::table('servidores')->delete();

        $dev = Servidor::create(array(
            "nome"        => "Dev (230)",
            "endereco"    => "200.185.166.130:22",
            "usuario"     => "diego.camargo",
            "senha"       => "D1390",
            "tipo_acesso" => Servidor::TIPO_SSH,
        ));

        $this->command->info('Tabela de servidores preenchida');


		DB::table('projetos')->delete();    	

    	$projeto = Projeto::create( array(
    		"nome"         => "Estadao", 
    		"repo"         => "https://bitbucket.org/estadao/estadao-2014.git",
    		"repo_usuario" => "gfelizola",
    		"repo_senha"   => "gustavof87",
    		"server_root"  => "D:\localhost\estadao-2014-git\\",
    		"repo_branch"  => "master",
    	));

        $projeto->servidores()->save($dev);

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