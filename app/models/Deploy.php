<?php

use LaravelBook\Ardent\Ardent;

class Deploy extends Ardent {

	const pendente  = 0;
    const aprovado  = 1
    const reprovado = 2;

	protected $fillable = array(
		'tag', 
		'descricao', 
		'status',
		'user_id',
		'projeto_id',
	);

	public function user() {
		return $this->belongsTo('User');
	}

	public function projeto() {
		return $this->belongsTo('Projeto');
	}

	public static $rules = array(
		'tag' => 'required'
	);

}