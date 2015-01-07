<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

use LaravelBook\Ardent\Ardent;

class User extends Eloquent implements UserInterface {

	const SKIN_BLUE     = "blue";
	const SKIN_BLACK    = "black";
	const LAYOUT_FIXED  = "fixed";
	const LAYOUT_SCROLL = "scroll";

	use UserTrait, SoftDeletingTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	protected $fillable = array('username', 'nome', 'avatar', 'layout', 'skin');

	public static $rules = array(
		'username' => 'required'
	);

	public function roles()
    {
        return $this->belongsToMany('Role', "role_user");
    }

    public function is_admin()
    {
    	return $this->roles->contains(1);
    }
}
