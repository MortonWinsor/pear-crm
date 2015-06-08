<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJobEquipmentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('job_equipment', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('job_id');
			$table->integer('equipment_id');
			$table->integer('works_id');
			$table->string('time');
			$table->integer('user_id');
			$table->text('notes')
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
		Schema::drop('job_equipment');
	}

}
