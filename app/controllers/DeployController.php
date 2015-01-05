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

		// $repo->fetch();

		// $tags    = $repo->list_tags();

		return View::make("deploy.create", array(
			"projeto"  => $projeto, 
			"servidor" => $servidor, 
			"tags"     => $tags
		));
	}


	/**
	 * Atualiza os dados do repositório
	 *
	 * @return Response
	 */
	public function fetch($projeto_id, $server_id)
	{
		set_time_limit(600);

		$projeto  = Projeto::find($projeto_id);
		$servidor = $projeto->servidores->find($server_id);
		$ssh      = $this->get_ssh($servidor);
		
		echo $this->console_header();
		
		$ssh->run( array(
			"cd " . $servidor->pivot->root,
			"pwd"
		), function($line) use ($ssh, $projeto, $servidor, $projeto_id, $server_id)
		{
			echo $this->line2html($line);
		});

	    $remote = $this->get_repo_url($projeto);

		if( $ssh->status() !== 0 )
		{
			echo "Pasta não encontrada<br>";
			echo "Iniciar repositório from " . $this->trata_url($remote);
			echo "<script>";
			echo "window.top.mostrarCloneModal('" . $this->trata_url($remote) . "', '" . URL::to("deploy", array($projeto_id, $server_id, "clonar") ) . "');";
			echo "</script>";
		}
		else
		{
			echo "Iniciar atualizações para Deploy<br>";

				
			$ssh->run( array(
				"cd " . $servidor->pivot->root,
				"git fetch " . $remote
			), function($line)
			{
			    echo $this->line2html($line);
			});

			echo "\n\n<script>\n";
			echo "window.top.location = '" . URL::to("deploy", array($projeto_id, $server_id, "dados") ) . "';";
			echo "\n</script>";
		}

		echo $this->console_footer();
	}

	/**
	 * Clona o repositório no diretório de destino do servidor
	 *
	 * @return Response
	 */
	public function clonar($projeto_id, $server_id)
	{
		set_time_limit(600);

		$projeto  = Projeto::find($projeto_id);
		$servidor = $projeto->servidores->find($server_id);

		echo $this->console_header();

		$remote  = $this->get_repo_url($projeto);
		$comando = "git clone $remote " . $servidor->pivot->root;

		$ssh = $this->get_ssh($servidor);
		$ssh->run($comando, function($line)
		{
		    echo $this->line2html($line);
		});

		echo "Verificação completa, iniciar Deploy<br>";

		echo "<script>";
		echo "window.top.location = '" . URL::to("deploy", array($projeto_id, $server_id, "dados") ) . "');";
		echo "</script>";

		echo $this->console_footer();
	}

	/**
	 * Clona o repositório no diretório de destino do servidor
	 *
	 * @return Response
	 */
	public function dados($projeto_id, $server_id)
	{
		$projeto  = Projeto::find($projeto_id);
		$servidor = $projeto->servidores->find($server_id);

		$remote   = $this->get_repo_url($projeto);
		$ssh      = $this->get_ssh($servidor);

		$retorno  = "";
		$ssh->run( array(
				"cd " . $servidor->pivot->root,
				"git tag -l"
			), function($line) use(&$retorno)
			{
			    $retorno .= $line;
			});

		$tagArray = explode("\n", $retorno);
		$tags = array();
		foreach ($tagArray as $i => &$tag) {
			$tag = trim($tag);
			if ($tag != '') {
				$tags[$tag] = $tag;
			}
		}

		$tags[""] = "Selecione a tag";
		arsort($tags);

		return Response::view("deploy.dados", array(
			"tags" => $tags,
			"projeto" => $projeto,
			"servidor" => $servidor,
		));
	}


	/**
	 * Realiza deploy de tag
	 *
	 * @return Response
	 */
	public function realizar($projeto_id, $server_id)
	{
		$validator = Validator::make(Input::all(), Deploy::$rules);

		if ($validator->fails()) 
		{
			return Redirect::to("deploy/$projeto_id/$server_id/dados")->withErrors($validator)->withInput( Input::all() );
		}
		else
		{
			set_time_limit(600);

			$projeto  = Projeto::find($projeto_id);
			$servidor = $projeto->servidores->find($server_id);

			$remote   = $this->get_repo_url($projeto);
			$ssh      = $this->get_ssh($servidor);

			$tag      = Input::get("tag");

			echo $this->console_header();

			$ssh->run( array(
				"cd " . $servidor->pivot->root,
				"git checkout " . $projeto->repo_branch,
				"git pull $remote tags/$tag -v",
			), function($line)
			{
			    echo $this->line2html($line);
			});

			echo $this->console_footer();
		}
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

				$remote = $this->get_repo_url($projeto);

				$repo->set_remote( $remote );
				$repo->set_branch( $projeto->repo_branch );
			}
		}

		return $repo;
	}


	/**
	 * Configura e retorna a instância de SSH
	 *
	 * @param  Servidor $servidor
	 * @return SSH
	 */
	public function get_ssh($servidor)
	{
		Config::set("remote.connections.runtime.host", $servidor->endereco);
		Config::set("remote.connections.runtime.username", $servidor->usuario);
		Config::set("remote.connections.runtime.password", $servidor->senha);
		Config::set("remote.connections.runtime.root", $servidor->pivot->root);

		return SSH::into("runtime");
	}


	/**
	 * Busca o repositório e retorna o objeto tratado
	 *
	 * @param  Projeto $p
	 * @return String
	 */
	public function get_repo_url($projeto)
	{
		if( ! strstr("git@", $projeto->repo) ){ //usando usuario/senha (não usa chave SSH)
			$purl = parse_url($projeto->repo);

			if( isset( $projeto->repo_usuario ) && ! empty( $projeto->repo_usuario ) ){
				$purl["user"] = $projeto->repo_usuario;
				$purl["pass"] = $projeto->repo_senha;
			}

			return $purl["scheme"] . "://" . $purl["user"] . ":" . $purl["pass"] . "@" . $purl["host"] . $purl["path"];
		}

		return $projeto->repo;
	}


	/**
	 * Função que esconde a senha para mostrar a url ao usuário
	 *
	 * @param  String $texto
	 * @return String
	 */
	private function trata_url($texto = "")
	{
		// $reg_exUrl = "_^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}-\x{ffff}0-9]-*)*[a-z\x{00a1}-\x{ffff}0-9]+)(?:\.(?:[a-z\x{00a1}-\x{ffff}0-9]-*)*[a-z\x{00a1}-\x{ffff}0-9]+)*(?:\.(?:[a-z\x{00a1}-\x{ffff}]{2,})))(?::\d{2,5})?(?:/\S*)?$";
		$reg_exUrl = '_(^|[\s.:;?\-\]<\(])(https?://[-\w;/?:@&=+$\|\_.!~*\|"()\[\]%#,☺]+[\w/#](\(\))?)(?=$|[\s",\|\(\).:;?\-\[\]>\)])_i';
		return preg_replace_callback($reg_exUrl, function($matches){
			$purl = parse_url( trim($matches[0]) );

			return " " . $purl["scheme"] . "://" . $purl["user"] . ":******@" . $purl["host"] . $purl["path"];
		}, $texto);
	}


	/**
	 * Função que trata saida para o console (quebras de linha = <br>)
	 *
	 * @param  String $line
	 * @return String
	 */
	private function line2html($line)
	{
		return implode( "<br>", explode( "\n", $line ) ) . "<br>";
	}

	/**
	 * Função que monta o header do console padrão
	 *
	 * @return String
	 */
	private function console_header()
	{
		$saida = "<!DOCTYPE html>\n<html>\n";
		$saida .= Response::view("layouts.head")->getOriginalContent();
		$saida .= "\n<body class='bg-black console'>";
		$saida .= "\n\n";

		return $saida;
	}

	/**
	 * Função que monta o header do console padrão
	 *
	 * @return String
	 */
	private function console_footer()
	{
		$saida = "\n\n" . Response::view("layouts.footer")->getOriginalContent();
		$saida .= "\n</body></html>";

		return $saida;
	}
}