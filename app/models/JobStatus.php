<?php

class JobStatus extends \Eloquent {

	public $table = 'job_status';
	
	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];
}