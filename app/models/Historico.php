<?php
use LaravelBook\Ardent\Ardent;

class Historico extends Ardent {

	const pendente  = 0;
    const aprovado  = 1
    const reprovado = 2;

	protected $fillable = array(
		'tipo', 
		'descricao', 
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
