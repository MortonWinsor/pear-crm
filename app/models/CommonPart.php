<?php

class CommonPart extends \Eloquent {

	public static $rules = [
		'part' => 'required'
	];

	protected $fillable = ['part',
							'created_by',
							'updated_by',
							'deleted_by'];
}