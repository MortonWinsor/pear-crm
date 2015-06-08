<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommonPartsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('common_parts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('part');
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
		Schema::drop('common_parts');
	}

}
