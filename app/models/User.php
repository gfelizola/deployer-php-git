<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
// use Illuminate\Auth\Reminders\RemindableTrait;
// use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

use LaravelBook\Ardent\Ardent;

class User extends Eloquent implements UserInterface {

	use UserTrait, SoftDeletingTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	protected $fillable = array('username', 'nome', 'avatar');

	public static $rules = array(
		'username' => 'required'
	);
}
