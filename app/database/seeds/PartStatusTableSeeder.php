<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class PartStatusTableSeeder extends Seeder {

	public function run()
	{
		$data = array(
					array('name'=>'Part Required'),
					array('name'=>'Part Ordered'),
					array('name'=>'Part Recieved'),
					array('name'=>'Part Picked Up')
				);

		DB::Table('parts_status')->insert($data);
		//Status::create($data);
	}

}