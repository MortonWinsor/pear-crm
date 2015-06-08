<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRemindersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reminders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('customer_id');
			$table->integer('equipment_id');
			$table->string('title');
			$table->timestamp('date');
			$table->text('description');
			$table->boolean('is_service');
			$table->timestamps();
			$table->softDeletes();
			$table->integer('created_by');
			$table->integer('updated_by');
			$table->integer('deleted_by');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('reminders');
	}

}
