<?php

class Type extends \Eloquent {
	
	// Add your validation rules here
	public static $rules = [
		'name' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['name',
							'created_by',
							'updated_by',
							'deleted_by'];
}