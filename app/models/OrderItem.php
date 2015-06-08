<?php

class OrderItem extends \Eloquent {

	use SoftDeletingTrait;
	
	protected $fillable = ['order_id',
							'part_number',
							'name',
							'status_id',
							'created_by',
							'updated_by',
							'deleted_by'];

	public function status()
	{
		return $this->hasOne('PartStatus', 'id', 'status_id');
	}
}