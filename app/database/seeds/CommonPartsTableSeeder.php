<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class CommonPartsTableSeeder extends Seeder {

	public function run()
	{
		$data = array(
					array('part'=>'Fuel Filter'),
					array('part'=>'Oil Filter'),
					array('part'=>'Air Filter'),
					array('part'=>'Spark Plug'),
					array('part'=>'Sharpening'),
					array('part'=>'Labour')
				);

		DB::Table('common_parts')->insert($data);
		//Part::create($data);
	}

}