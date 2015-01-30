<?php
class Servidor extends Eloquent {

	const TIPO_LOCAL = "local";
	const TIPO_SSH   = "ssh";

	protected $table = 'servidores';

	public static $rules = array(
		'nome'        => 'required', 
		'tipo_acesso' => 'required', 
		'endereco'    => 'required_if:tipo_acesso,ssh', 
		'usuario'     => 'required_if:tipo_acesso,ssh', 
		'senha'       => 'required_if:tipo_acesso,ssh', 
		// 'key'       => 'required_if:tipo_acesso,ssh', 
	);

	protected $fillable = array(
		'nome', 
		'tipo_acesso', 
		'endereco', 
		'usuario', 
		'senha'
	);

    public function projetos()
    {
        return $this->belongsToMany('Projeto', "servidores_projetos")->withPivot("root","tag_atual","branch");
    }
}
