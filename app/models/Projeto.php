<?php
use LaravelBook\Ardent\Ardent;

class Projeto extends Ardent {

	protected $fillable = array(
		'nome', 
		'server_root', 
		'repo', 
		'repo_usuario', 
		'repo_senha', 
		'repo_key', 
		'repo_branch', 
		'deploy_key'
	);

	public static $rules = array(
		'nome'        => 'required',
		'server_root' => 'required',
		'repo'        => 'required',
		'repo_branch' => 'required',
	);

}
