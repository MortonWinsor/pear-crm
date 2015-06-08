<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJobOrderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('job_order', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('job_id');
			$table->integer('order_id');
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
		Schema::drop('job_order');
	}

}
