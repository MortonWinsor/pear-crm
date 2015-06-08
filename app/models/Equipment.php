<?php

class Equipment extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		'make' => 'required',
		'model' => 'required',
		'type_id' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['make',
							'model',
							'serial',
							'service_interval',
							'last_service',
							'type_id',
							'us',
							'customer_id',
							'created_by',
							'updated_by',
							'deleted_by'];

	public function equip_type()
	{
		return $this->hasOne('Type', 'id', 'type_id');
	}

	public function parts()
	{
		return $this->hasMany('Part', 'equipment_id', 'id');
	}

	public function customer()
	{
		return $this->belongsTo('Customer', 'customer_id', 'id');
	}

	public function jobs()
	{
		return $this->belongsTo('JobEquipment', 'id', 'equipment_id');
	}

	public function newPivot(Illuminate\Database\Eloquent\Model $parent, array $attributes, $table, $exists)
	{
	    return new JobEquipmentPivot($parent, $attributes, $table, $exists);
	}

}