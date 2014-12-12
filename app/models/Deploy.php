<?php

use LaravelBook\Ardent\Ardent;

class Deploy extends Ardent {

	protected $fillable = array(
		'tag', 
		'descricao', 
		'status'
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
