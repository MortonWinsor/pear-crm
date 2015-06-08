<?php

class JobEquipmentPivot extends \Illuminate\Database\Eloquent\Relations\Pivot {

	use SoftDeletingTrait;

	public $table = 'job_equipment';

	protected $fillable = ['job_id',
							'equipment_id',
							'user_id',
							'works_id',
							'time',
							'hours',
							'notes'];

	public function user()
	{
		return $this->hasOne('User', 'id', 'user_id');
	}

	public function work()
	{
		return $this->hasOne('Work', 'id', 'works_id');
	}
}