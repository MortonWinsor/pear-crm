<?php

class Customer extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		 'name' => 'required',
		 'phone' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['name',
							'phone',
							'mobile',
							'email',
							'address',
							'postcode',
							'created_by',
							'updated_by',
							'deleted_by'];

	public function equipment()
	{
		return $this->hasMany('Equipment', 'customer_id', 'id');
	}

	public function jobs()
	{
		return $this->hasMany('Job', 'customer_id', 'id')->orderBy('created_at', 'DESC');
	}

	public function orders()
	{
		return $this->hasMany('Order', 'customer_id', 'id')->orderBy('created_at', 'DESC');
	}
}