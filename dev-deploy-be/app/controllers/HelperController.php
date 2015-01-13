<?php

use MrRio\ShellWrap as sh;
use MrRio\ShellWrapException;

class HelperController extends \BaseController {

	private $projeto;
	private $servidor;

	private $cmd_retorno;
	private $cmd_saida;

	


	/**
	 * Atualiza os dados do repositório
	 *
	 * @return Response
	 */
	public function remover_repositorio($projeto, $server_id)
	{
		set_time_limit(600);

		$this->projeto  = $projeto;
		$this->servidor = $projeto->servidores->find($server_id);

		echo $this->console_header();

		$this->cmd_saida   = 0;
		$this->cmd_retorno = NULL;

		if( $this->is_local() )
		{
			echo "<pre>";
			try {
				sh::$displayStdout = true;
				sh::$displayStderr = true;
				
				sh::$cwd = $this->servidor->pivot->root;
				sh::whoami();
				sh::pwd();
				sh::rm("-rf", $this->servidor->pivot->root);

			} catch (ShellWrapException $e) {
				$this->cmd_retorno = $e->getMessage();
				$this->cmd_saida   = $e->getCode();
			}
			echo "</pre>";
		}
		else
		{
			$ssh = $this->get_ssh();
			$ssh->run( array(
				"cd " . $servidor->pivot->root,
				"whoami",
				"pwd",
				"rm -rf " . $servidor->pivot->root
			), function($line) {
				echo $this->line2html($line);
			});

			$this->cmd_saida = $ssh->status();
		}

		echo $this->console_footer();
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
	 * Busca o repositório e retorna o objeto tratado
	 *
	 * @param  Projeto $p
	 * @return String
	 */
	public function get_repo_url()
	{
		if( ! strstr("git@", $this->projeto->repo) ){ //usando usuario/senha (não usa chave SSH)
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