<?php
class Deploy extends Eloquent {

	const pendente  = 0;
    const aprovado  = 1;
    const reprovado = 2;

	public static $rules = array(
		'tag' => 'required|not_in:0'
	);

	protected $fillable = array(
		'tag', 
		'descricao', 
		'status',
		'infos',
		'user_id',
		'projeto_id',
		'servidor_id',
	);

	public function user() {
		return $this->belongsTo('User');
	}

	public function projeto() {
		return $this->belongsTo('Projeto');
	}

	public function servidor() {
		return $this->belongsTo('Servidor');
	}
}
