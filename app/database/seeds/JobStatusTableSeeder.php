<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class JobStatusTableSeeder extends Seeder {

	public function run()
	{
		$data = array(
					array('name'=>'Work Pending'),
					array('name'=>'Work Completed'),
					array('name'=>'Customer Contacted'),
					array('name'=>'History'),
					array('name'=>'Waiting Parts')
				);

		DB::Table('job_status')->insert($data);
		//Status::create($data);
	}

}