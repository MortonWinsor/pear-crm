<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class WorkTableSeeder extends Seeder {

	public function run()
	{
		$data = array(
					array('name'=>'Service'),
					array('name'=>'Repair'),
					array('name'=>'Service and Repair')
				);

		DB::Table('works')->insert($data);
	}

}