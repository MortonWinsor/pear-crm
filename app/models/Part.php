<?php

class Part extends \Eloquent {

	use SoftDeletingTrait;
	
	// Add your validation rules here
	public static $rules = [
		'name' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['customer_id',
							'job_id',
							'equipment_id',
							'name',
							'order',
							'created_by',
							'updated_by',
							'deleted_by'];

	public function status()
	{
		return $this->hasOne('PartStatus', 'id', 'status_id');
	}
}