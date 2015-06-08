<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	// Add your validation rules here
	public static $rules = [
		'username' => 'sometimes|required|unique:users',
		'email' => 'sometimes|email',
		'password' => 'sometimes|confirmed'
	];

	// Don't forget to fill this array
	protected $fillable = ['username',
							'email',
							'role_id',
							'password',
							'created_by',
							'updated_by'];
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public function role()
	{
		return $this->hasOne('Role', 'id', 'role_id');
	}

}
