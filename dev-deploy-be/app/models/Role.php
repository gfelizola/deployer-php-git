<?php
class Role extends Eloquent {

	public static $rules = array(
		'nome'        => 'required'
	);

	protected $fillable = array(
		'nome'
	);
	
    public function users()
    {
        return $this->belongsToMany('User', "role_user");
    }
}
