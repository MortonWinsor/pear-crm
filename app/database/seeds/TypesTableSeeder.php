<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class TypesTableSeeder extends Seeder {

	public function run()
	{
		$data = array(
					array('name'=>'Example')
				);

		DB::Table('types')->insert($data);
		//Type::create($data);
	}

}