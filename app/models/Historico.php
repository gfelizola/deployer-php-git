<?php
class Historico extends Eloquent {

	const TipoUsuario  = 0;
    const TipoDeploy   = 1;
    const TipoRollBack = 2;
    const TipoProjeto  = 3;
    const TipoServidor = 4;

	protected $fillable = array(
		"tipo", 
		"descricao",
		"infos",
		"user_id",
		"projeto_id",
		"deploy_id",
	);

	public function user() {
		return $this->belongsTo("User");
	}

	public function projeto() {
		return $this->belongsTo("Projeto");
	}

	public function deploy() {
		return $this->belongsTo("Deploy");
	}

	public static $rules = array(
		"tipo"      => "required",
		"descricao" => "required",
	);

	public function scopeRollbacks($query)
    {
        return $query->where("tipo", "=", Historico::TipoRollBack);
    }

    public function scopeDeploys($query)
    {
        return $query->where("tipo", "=", Historico::TipoDeploy);
    }

}
