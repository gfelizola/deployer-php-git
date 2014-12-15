<?php
use LaravelBook\Ardent\Ardent;

class Historico extends Ardent {

	const TipoUsuario  = 0;
    const TipoDeploy   = 1;
    const TipoRollBack = 2;
    const TipoProjeto  = 3;

	protected $fillable = array(
		'tipo', 
		'descricao',
		'user_id',
	);

	public function user() {
		return $this->belongsTo('User');
	}

	public function projeto() {
		return $this->belongsTo('Projeto');
	}

	public static $rules = array(
		'tipo'      => 'required',
		'descricao' => 'required',
	);

}
