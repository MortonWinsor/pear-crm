<?php

class JobEquipment extends \Eloquent {

	use SoftDeletingTrait;

	public $table = 'job_equipment';

	protected $fillable = ['job_id',
							'equipment_id',
							'user_id',
							'works_id',
							'time',
							'hours',
							'notes'];

}