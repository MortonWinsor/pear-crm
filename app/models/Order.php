<?php

class Order extends \Eloquent {

	// Add your validation rules here
	public static $rules = [ 'customer_id'
	];

	protected $fillable = ['customer_id'];

	public function customer()
	{
		return $this->belongsTo('Customer', 'customer_id', 'id');
	}

	public function items()
	{
		return $this->hasMany('OrderItem', 'order_id', 'id');
	}

	public function jobs()
	{
		return $this->belongsToMany('Job', 'job_order');
	}
}