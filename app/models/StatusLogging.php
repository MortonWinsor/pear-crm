<?php

class StatusLogging extends \Eloquent {
	protected $fillable = [];

	protected $guarded = array();

	public $table = 'status_logging';

	static public function storeLog($type, $id, $old, $new){
		$_this = new self;
		$_this->type = $type;
		$_this->other_id = $id;
		$_this->old_status_id = $old;
		$_this->new_status_id = $new;
		$_this->user = Auth::user()->id;
		$_this->created_at = time();
		$_this->updated_at = time();

		$_this->save();

	}
}