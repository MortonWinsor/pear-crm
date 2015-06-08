<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('CommonPartsTableSeeder');
		$this->call('RolesTableSeeder');
		$this->call('JobStatusTableSeeder');
		$this->call('TypesTableSeeder');
		$this->call('WorkTableSeeder');
		$this->call('UserTableSeeder');
		$this->call('PartStatusTableSeeder');
	}

}
