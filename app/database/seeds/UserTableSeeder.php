<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class UserTableSeeder extends Seeder {

	public function run()
	{
		$data = array(
					array('username' => 'admin', 
							'password' => Hash::make('admin'), 
							'email' => 'admin@example.com', 
							'role_id' => '1')
				);

		DB::Table('users')->insert($data);
	}

}