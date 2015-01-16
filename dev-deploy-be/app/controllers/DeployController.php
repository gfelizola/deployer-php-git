<?php

use MrRio\ShellWrap as sh;
use MrRio\ShellWrapException;

class DeployController extends \BaseController {

	private $projeto;
	private $servidor;

	private $cmd_retorno;
	private $cmd_saida;

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
	public function create($projeto, $server_id)
	{
		$tags           = array();
		$this->projeto  = $projeto;
		$this->servidor = $projeto->servidores->find($server_id);
		// $repo    = $this->get_repo($projeto);

		// $repo->fetch();

		// $tags    = $repo->list_tags();

		return View::make("deploy.create", array(
			"projeto"  => $this->projeto, 
			"servidor" => $this->servidor, 
			"tags"     => $tags
		));
	}


	/**
	 * Atualiza os dados do repositório
	 *
	 * @return Response
	 */
	public function fetch($projeto, $server_id)
	{
		set_time_limit(600);

		$this->projeto  = $projeto;
		$this->servidor = $projeto->servidores->find($server_id);

		echo $this->console_header();

		$this->cmd_saida   = 0;
		$this->cmd_retorno = NULL;

		if( $this->is_local() )
		{
			try {
				sh::$displayStdout = true;
				sh::$displayStderr = true;
				
				sh::cd($this->servidor->pivot->root);
			} catch (ShellWrapException $e) {
				$this->cmd_retorno = $e->getMessage();
				$this->cmd_saida   = $e->getCode();
			}
		}
		else
		{
			$ssh = $this->get_ssh();
			$ssh->run( array(
				"cd " . $servidor->pivot->root,
				"pwd"
			), function($line) {
				echo $this->line2html($line);
			});

			$this->cmd_saida = $ssh->status();
		}

	    $remote = $this->get_repo_url($projeto);

		if( $this->cmd_saida !== 0 )
		{
			echo "<br>Pasta não encontrada<br>";
			echo "Iniciar clone do repositório " . $this->trata_url($remote);
			echo "<script>";
			echo "window.top.mostrarCloneModal('" . $this->trata_url($remote) . "', '" . URL::to("deploy", array($projeto->id, $server_id, "clonar") ) . "');";
			echo "</script>";
		}
		else
		{
			echo "Iniciar atualizações para Deploy<br>";

			if( $this->is_local() )
			{
				try {
					sh::$cwd = $this->servidor->pivot->root;
					sh::git("fetch", $remote, "--tags", "--verbose");
				} catch (ShellWrapException $e) {
					$this->cmd_retorno = $e->getMessage();
					$this->cmd_saida   = $e->getCode();
				}
			}
			else
			{
				$ssh->run( array(
					"cd " . $this->servidor->pivot->root,
					"git fetch $remote --tags --verbose"
				), function($line)
				{
				    echo $this->line2html($line);
				});
			}

			if( $this->cmd_saida === 0 )
			{
				echo "\n\n<script>\n";
				echo "window.top.location = '" . URL::to("deploy", array($this->projeto->id, $server_id, "dados") ) . "';";
				echo "\n</script>";
			}
			else
			{
				echo "ERRO";
				echo "\n\n<script>\n";
				echo "alert('Houveram erros ao atualizar, veja as informações no box.');";
				echo "\n</script>";
			}
		}

		echo $this->console_footer();
	}

	/**
	 * Clona o repositório no diretório de destino do servidor
	 *
	 * @return Response
	 */
	public function clonar($projeto, $server_id)
	{
		set_time_limit(600);
		echo $this->console_header();

		$this->projeto     = $projeto;
		$this->servidor    = $projeto->servidores->find($server_id);

		$remote            = $this->get_repo_url();

		echo "<b>Iniciando clonagem.</b><br>Por favor aguarde, o request pode levar algum tempo<br>";

		$this->cmd_retorno = NULL;
		$this->cmd_saida   = 0;

		if( $this->is_local() )
		{
			try {
				sh::$displayStdout = true;
				sh::$displayStderr = true;

				flush();
				ob_flush();
				
				sh::git("clone", $remote, $this->servidor->pivot->root);

			} catch (ShellWrapException $e) {
				$this->cmd_retorno = $e->getMessage();
				$this->cmd_saida   = $e->getCode();
			}
		}
		else
		{
			$ssh = $this->get_ssh();
			$ssh->run("git clone $remote " . $this->servidor->pivot->root, function($line)
			{
			    echo $this->line2html($line);
			});

			$this->cmd_saida = $ssh->status();
		}

		if( $this->cmd_saida === 0 ){
			echo "Clonagem completa, iniciar Deploy<br>";

			echo "<script>";
			echo "window.top.location = '" . URL::to("deploy", array($projeto->id, $server_id, "dados") ) . "');";
			echo "</script>";
		}
		else
		{
			echo "Erro ao clonar.<br>";
		}

		

		echo $this->console_footer();
	}

	/**
	 * Clona o repositório no diretório de destino do servidor
	 *
	 * @return Response
	 */
	public function dados($projeto, $server_id)
	{
		$this->projeto  = $projeto;
		$this->servidor = $projeto->servidores->find($server_id);

		$this->cmd_retorno = NULL;
		$this->cmd_saida   = 0;
		$retorno  = "";

		if( $this->is_local() )
		{
			try {
				sh::$cwd = $this->servidor->pivot->root;
				sh::git("tag", "-l", function($line) use(&$retorno)
				{
				    $retorno .= $line;
				});

			} catch (ShellWrapException $e) {
				$this->cmd_retorno = $e->getMessage();
				$this->cmd_saida   = $e->getCode();
			}
		}
		else
		{
			$ssh = $this->get_ssh();
			$ssh->run( array(
				"cd " . $this->servidor->pivot->root,
				"git tag -l"
			), function($line) use(&$retorno)
			{
			    $retorno .= $line;
			});

			$this->cmd_saida = $ssh->status();
		}

		$this->cmd_retorno = $retorno;

		if( $this->cmd_saida === 0 )
		{
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
		}
		else
		{
			throw new Exception("Não foi possível carregar as tags. " . $this->cmd_retorno, 1);
		}

		$tags = array_slice($tags, 0, 21, true);

		return Response::view("deploy.dados", array(
			"tags" => $tags,
			"projeto" => $this->projeto,
			"servidor" => $this->servidor,
		));
	}


	/**
	 * Realiza deploy de tag
	 *
	 * @return Response
	 */
	public function realizar($projeto, $server_id)
	{
		$validator = Validator::make(Input::all(), Deploy::$rules);

		if ($validator->fails()) 
		{
			return Redirect::to("deploy/{$projeto->id}/$server_id/dados")->withErrors($validator)->withInput( Input::all() );
		}
		else
		{
			$tag        = Input::get("tag");
			$tag_existe = false;//Deploy::where("servidor_id","=",$server_id)->where("tag","=",$tag)->first();

			if( $tag_existe )
			{
				return Redirect::to("deploy/{$projeto->id}/$server_id/dados")
					->withErrors( array("tag_existe" => "A tag <b>$tag</b> já foi carregada no servidor.<br>Escolha outra tag ou crie uma nova tag para realizar o deploy.") )
					->withInput( Input::all() );
			}
			else
			{
				set_time_limit(600);

				$retorno        = "";
				$this->projeto  = $projeto;
				$this->servidor = $projeto->servidores->find($server_id);
				$remote         = $this->get_repo_url();

				$this->verifica_status();

				$this->cmd_retorno = NULL;
				$this->cmd_saida   = 0;

				if( $this->is_local() )
				{
					try {
						sh::$displayStdout = false;
						sh::$displayStderr = true;

						flush();
						ob_flush();
						
						sh::$cwd = $this->servidor->pivot->root;
						echo sh::pwd();
						sh::git("reset", "--hard", "origin/{$this->projeto->repo_branch}", function($line) use(&$retorno)
						{
						    $retorno .= $line;
						});
						sh::git("checkout", "tags/$tag", function($line) use(&$retorno)
						{
						    $retorno .= $line;
						});

					} catch (ShellWrapException $e) {
						$this->cmd_retorno = $e->getMessage();
						$this->cmd_saida   = $e->getCode();
					}
				}
				else
				{
					$ssh = $this->get_ssh();
					$ssh->run( array(
						"cd " . $this->servidor->pivot->root,
						"git reset --hard $remote {$this->projeto->repo_branch}",
						"git checkout " . $tag,
					), 
					function($line) use(&$retorno)
					{
					    $retorno .= $line;
					});

					$this->cmd_saida = $ssh->status();
				}

				echo $this->line2html($retorno);
				echo "<br><hr><br>";

				if( $this->cmd_saida !== 0 ){
					$mensagem = "Houveram erros durante o deploy, por favor valide a mensagem.";
					die($mensagem);
				} else {
					$mensagem = "Deploy realizado com sucesso";
					$infos    = array(
						"log_cmd" => $retorno
					);

					$deploy = Deploy::create( array(
						"tag"         => $tag,
						"descricao"   => Input::get("descricao"),
						"status"      => Deploy::aprovado,
						"user_id"     => Auth::user()->id,
						"projeto_id"  => $this->projeto->id,
						"servidor_id" => $server_id,
						"infos"       => json_encode($infos)
					));

					Historico::create( array(
						"tipo"       => Historico::TipoDeploy,
						"descricao"  => "Deploy realizado.",
						"projeto_id" => $this->projeto->id,
						"deploy_id"  => $deploy->id,
						"user_id"    => Auth::user()->id
					));

					$projeto->servidores()->updateExistingPivot($server_id, array("tag_atual" => $tag));

					return Redirect::to("projeto/{$projeto->id}/deploys")->with("message","$mensagem<br><br>Retorno: <bloquote><pre>$retorno</pre></bloquote>");
				}
			}
		}
	}


	/**
	 * Realiza rollback de tag/versão
	 *
	 * @return Response
	 */
	public function rollback($deploy_id)
	{
		set_time_limit(600); //10 minutos

		$deploy         = Deploy::find($deploy_id);
		$this->projeto  = $deploy->projeto;
		$this->servidor = $this->projeto->servidores->find($deploy->servidor->id);
		$remote         = $this->get_repo_url();
		$tag            = $deploy->tag;
		$retorno        = "";

		if( $this->is_local() )
		{
			try {
				sh::$displayStdout = false;
				sh::$displayStderr = false;

				flush();
				ob_flush();
				
				sh::$cwd = $this->servidor->pivot->root;
				sh::git("checkout", "tags/$tag", function($line) use(&$retorno)
				{
				    $retorno .= $line;
				});

			} catch (ShellWrapException $e) {
				$this->cmd_retorno = $e->getMessage();
				$this->cmd_saida   = $e->getCode();
			}
		}
		else
		{
			$ssh->run( array(
				"cd " . $this->servidor->pivot->root,
				"git checkout $tag",
			), 
			function($line) use(&$retorno)
			{
			    $retorno .= $line;
			});

			$this->cmd_saida = $ssh->status();
		}

		if( $this->cmd_saida !== 0 && ! is_null( $this->cmd_saida ) ){
			$mensagem = "Houveram erros durante o rollback, por favor valide o retorno.";
			echo "$mensagem<br>";
			echo "<br>";
			echo htmlentities($retorno);
			echo "<br>";
			echo "<br>";

			dd($this->cmd_saida);
		} else {
			$mensagem = "Rollback realizado com sucesso";

			Historico::create( array(
				"tipo"       => Historico::TipoRollBack,
				"descricao"  => "Rollback realizado.",
				"projeto_id" => $this->projeto->id,
				"deploy_id"  => $deploy->id,
				"user_id"    => Auth::user()->id
			));

			$this->projeto->servidores()->updateExistingPivot($this->projeto->id, array("tag_atual" => $tag));

		}

		return Redirect::to("projeto/{$this->projeto->id}/deploys")->with("message","$mensagem<br><br>Retorno: <bloquote><pre>$retorno</pre></bloquote>");
	}


	/**
	 * Busca o repositório e retorna o objeto tratado
	 *
	 * @param  Projeto  $p
	 * @return GitRepo
	 */
	public function get_repo()
	{
		if( Config::get("app.WINDOWS") ) Git::windows_mode();

		$repo = Git::open( $this->projeto->server_root );

		if( $repo->test_git() ){
			
			if( ! strstr("git@", $this->projeto->repo) ){ //usando usuario/senha (não usa chave SSH)
				$purl = parse_url($this->projeto->repo);

				if( isset( $this->projeto->repo_usuario ) && ! empty( $this->projeto->repo_usuario ) ){
					$purl["user"] = $this->projeto->repo_usuario;
					$purl["pass"] = $this->projeto->repo_senha;
				}

				$remote = $this->get_repo_url($this->projeto);

				$repo->set_remote( $remote );
				$repo->set_branch( $this->projeto->repo_branch );
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
	public function get_ssh()
	{
		Config::set("remote.connections.runtime.host", $this->servidor->endereco);
		Config::set("remote.connections.runtime.username", $this->servidor->usuario);
		Config::set("remote.connections.runtime.password", $this->servidor->senha);
		Config::set("remote.connections.runtime.root", $this->servidor->pivot->root);

		return SSH::into("runtime");
	}


	/**
	 * Verifica status dos arquivos no servidor antes de realizar o deploy
	 *
	 * @param  Projeto $projeto
	 * @param  Servidor $servidor
	 * @return Boolean
	 */
	public function verifica_status()
	{
		$retorno  = "";

		$this->cmd_retorno = NULL;
		$this->cmd_saida   = 0;
		

		if( $this->is_local() )
		{
			try {
				sh::$displayStdout = false;
				sh::$displayStderr = true;

				flush();
				ob_flush();
				
				sh::$cwd = $this->servidor->pivot->root;
				sh::git("status", "--porcelain", "--untracked-files=no", function($line) use(&$retorno)
				{
				    $retorno .= $line;
				});

			} catch (ShellWrapException $e) {
				$this->cmd_retorno = $e->getMessage();
				$this->cmd_saida   = $e->getCode();
			}
		}
		else
		{
			$ssh = $this->get_ssh();
			$ssh->run( array(
				"cd " . $this->servidor->pivot->root,
				"git status --porcelain --untracked-files=no",
			), 
			function($line) use(&$retorno)
			{
			    $retorno .= $line;
			});

			$this->cmd_saida = $ssh->status();
		}

		echo "<h3>Status</h3><br>";
		echo $this->line2html($retorno);
		echo "<br><hr><br>";

		$linhas = explode("\n", $retorno);
		foreach ($linhas as $k => $l) {
			if( empty(trim($l)) ) unset( $linhas[$k] );
		}

		if( count($linhas) > 0 )
		{
			$gitignore = $this->servidor->pivot->root . "/.gitignore";
			$remote    = $this->get_repo_url();
			$ignore    = "";

			if( $this->is_local() ){
				$ignore = file_get_contents($gitignore);
			} else {
				$ignore = $ssh->getString($gitignore);
			}

			$adicionados = array();

			foreach ($linhas as $linha) {
				$larr    = explode(" ", $linha);
				$arquivo = end( $larr );

				if( strtolower($arquivo) != ".gitignore" ){ //ignorando as mudanças no próprio gitignore
					if( ! stripos($ignore, $arquivo) ){
						$ignore .= "\n$arquivo";
						$adicionados[] = $arquivo;
					}
				}
			}

			if( count($adicionados) > 0 ){
				$retorno = "";

				$this->cmd_retorno = NULL;
				$this->cmd_saida   = 0;

				if( $this->is_local() )
				{
					file_put_contents($gitignore, $ignore);

					try {
						sh::$cwd = $this->servidor->pivot->root;

						foreach ($adicionados as $novo) {
							sh::git("rm","--cached",$novo);
						}

						sh::git("add", $gitignore);
						sh::git("commit", "-m", "'adicionando arquivos ao gitignore pela ferramenta de deploy (" . date('Y/m/d H:i') . ")'");
						sh::git("push", $remote, $this->projeto->repo_branch);

					} catch (ShellWrapException $e) {
						$this->cmd_retorno = $e->getMessage();
						$this->cmd_saida   = $e->getCode();
					}
				}
				else
				{
					$ssh->putString($gitignore, $ignore);

					$comandos = array( "cd " . $this->servidor->pivot->root );

					foreach ($adicionados as $novo) {
						$comandos[] = "git rm --cached $novo";
					}

					$comandos[] = "git add " . $this->servidor->pivot->root . "/.gitignore";
					$comandos[] = "git commit -m 'adicionando arquivos ao gitignore pela ferramenta de deploy (" . date('Y/m/d H:i') . ")'";
					$comandos[] = "git push $remote " . $this->projeto->repo_branch;

					$ssh->run( $comandos, function($line) use(&$retorno)
					{
					    $retorno .= $line;
					});

					$this->cmd_saida = $ssh->status();
				}
			}
		}

		// die();
	}


	/**
	 * Busca o repositório e retorna o objeto tratado
	 *
	 * @param  Projeto $p
	 * @return String
	 */
	public function get_repo_url()
	{
		if( strpos( $this->projeto->repo, "git@" ) === FALSE ){ //usando usuario/senha (não usa chave SSH)
			$purl = parse_url($this->projeto->repo);

			if( isset( $this->projeto->repo_usuario ) && ! empty( $this->projeto->repo_usuario ) ){
				$purl["user"] = $this->projeto->repo_usuario;
				$purl["pass"] = $this->projeto->repo_senha;
			}

			return $purl["scheme"] . "://" . $purl["user"] . ":" . $purl["pass"] . "@" . $purl["host"] . $purl["path"];
		}

		return $this->projeto->repo;
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

	/**
	 * Função helper para validar se estamos rodando em servidor local
	 *
	 * @return Boolean
	 */
	private function is_local()
	{
		return $this->servidor->tipo_acesso == Servidor::TIPO_LOCAL;
	}

	
}