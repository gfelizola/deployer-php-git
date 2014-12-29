<?php
class Projeto extends Eloquent {

	public static $rules = array(
		'nome'        => 'required', 
		'server_root' => 'required', 
		'repo'        => 'required', 
		'repo_branch' => 'required', 
		'repo_senha'  => 'required_with:repo_usuario', 
		// 'repo_key'    => 'required_without_all:repo_usuario,repo_senha', 
	);

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

	public function deploys()
    {
        return $this->hasMany('Deploy');
    }
}
