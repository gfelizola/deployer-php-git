<?php

class DeployController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make("deploy.index");
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($projeto_id, $server_id)
	{
		$tags     = array();
		$projeto  = Projeto::find($projeto_id);
		$servidor = Servidor::find($server_id);
		// $repo    = $this->get_repo($projeto);

		$repo->fetch();

		$tags    = $repo->list_tags();

		return View::make("deploy.create", array(
			"projeto"  => $projeto, 
			"servidor" => $servidor, 
			"tags"     => $tags
		));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function fetch($projeto_id, $server_id)
	{
		$projeto  = Projeto::find($projeto_id);
		$servidor = Servidor::find($server_id);
		// $repo    = $this->get_repo($projeto);

		// @ini_set("implicit_flush",1);
		// @ob_end_clean();
		// set_time_limit(0);
		// ob_implicit_flush(1);

		echo "<!DOCTYPE html><html>";
		echo Response::view("layouts.head")->getOriginalContent();
		echo '<body class="bg-black console">';

		$servidor = $projeto->servidores->first();
		// dd( $servidor );

		list( $servidor_ip, $servidor_port ) = explode( ":", $servidor->endereco );

		Config::set("remote.connections.runtime.host", $servidor_ip);
		Config::set("remote.connections.runtime.port", $servidor_port);
		Config::set("remote.connections.runtime.username", $servidor->usuario);
		Config::set("remote.connections.runtime.password", $servidor->senha);
		Config::set("remote.connections.runtime.root", $projeto->server_root);

		echo "Conectando no servidor<br>";

		SSH::into("runtime")->run(array(
		    "cd " . $projeto->server_root,
		    "pwd",
		    "git status",
		),  function($line)
		{
			$saida = implode( "<br>", explode( "\n", $line ) );
		    echo "$saida<br>".PHP_EOL;
		});

		// try {
		// 	// $cmd = "ping 127.0.0.1";
		// 	$cmd = "git fetch https://gfelizola:gustavof87@bitbucket.org/estadao/estadao-2014.git";

		// 	chdir( $projeto->server_root );

		// 	echo getcwd() . " > " . $this->trata_url( $cmd, " " );
		// 	die;
		// 	flush();

	 //        $handle = popen($cmd, "r");

	 //        if (ob_get_level() == 0) 
	 //            ob_start();

	 //        while(!feof($handle)) {

	 //            $buffer = fgets($handle);
	 //            $buffer = trim(htmlspecialchars($buffer));

	 //            echo $buffer . "<br />";
	 //            echo str_pad("", 4096);    

	 //            ob_flush();
	 //            flush();
	 //            sleep(1);
	 //        }

	 //        pclose($handle);
	 //        ob_end_flush();
		// } catch (Exception $e) {
		// 	var_dump($e);
		// }

		echo Response::view("layouts.footer")->getOriginalContent();
		echo "</body></html>";
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


	/**
	 * Busca o repositório e retorna o objeto tratado
	 *
	 * @param  Projeto  $p
	 * @return GitRepo
	 */
	public function get_repo($projeto)
	{
		if( Config::get("app.WINDOWS") ) Git::windows_mode();

		$repo = Git::open( $projeto->server_root );

		if( $repo->test_git() ){
			
			if( ! strstr("git@", $projeto->repo) ){ //usando usuario/senha (não usa chave SSH)
				$purl = parse_url($projeto->repo);

				if( isset( $projeto->repo_usuario ) && ! empty( $projeto->repo_usuario ) ){
					$purl["user"] = $projeto->repo_usuario;
					$purl["pass"] = $projeto->repo_senha;
				}

				$remote = $purl["scheme"] . "://" . $purl["user"] . ":" . $purl["pass"] . "@" . $purl["host"] . $purl["path"];

				$repo->set_remote( $remote );
				$repo->set_branch( $projeto->repo_branch );
			}
		}

		return $repo;
	}

	private function trata_url($texto = "", $prefix = "")
	{
		// $reg_exUrl = "_^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}-\x{ffff}0-9]-*)*[a-z\x{00a1}-\x{ffff}0-9]+)(?:\.(?:[a-z\x{00a1}-\x{ffff}0-9]-*)*[a-z\x{00a1}-\x{ffff}0-9]+)*(?:\.(?:[a-z\x{00a1}-\x{ffff}]{2,})))(?::\d{2,5})?(?:/\S*)?$";
		$reg_exUrl = '_(^|[\s.:;?\-\]<\(])(https?://[-\w;/?:@&=+$\|\_.!~*\|"()\[\]%#,☺]+[\w/#](\(\))?)(?=$|[\s",\|\(\).:;?\-\[\]>\)])_i';
		return preg_replace_callback($reg_exUrl, function($matches){
			$purl = parse_url( trim($matches[0]) );

			return " " . $purl["scheme"] . "://" . $purl["user"] . ":******@" . $purl["host"] . $purl["path"];
		}, $texto);
	}
}