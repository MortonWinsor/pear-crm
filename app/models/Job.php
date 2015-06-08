<?php

class Job extends \Eloquent {
	
	// Add your validation rules here
	public static $rules = [
		'customer_id' => 'required',
		'description' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['description',
							'notes',
							'status_id',
							'works_id',
							'customer_id',
							'status_date',
							'user_id',
							'created_by',
							'updated_by',
							'deleted_by'];

	public function customer()
	{
		return $this->belongsTo('Customer', 'customer_id', 'id');
	}

	public function status()
	{
		return $this->hasOne('JobStatus', 'id', 'status_id');
	}

	public function equipments()
	{
		return $this->belongsToMany('Equipment', 'job_equipment')->whereNull('job_equipment.deleted_at')->withTimestamps()->withPivot('works_id', 'time', 'user_id', 'notes');
	}


}