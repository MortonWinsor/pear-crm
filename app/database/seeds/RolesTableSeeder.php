<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class RolesTableSeeder extends Seeder {

	public function run()
	{
		$data = array(
					array('name'=>'Admin'),
					array('name'=>'Salesperson'),
					array('name'=>'Engineer')
				);

		DB::Table('roles')->insert($data);
		//Role::create($data);
	}

}