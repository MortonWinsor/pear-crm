<?php

class ReminderLog extends \Eloquent {

	public $table = 'reminder_log';

	protected $fillable = ['equipment_id',
							'customer_id'];
}