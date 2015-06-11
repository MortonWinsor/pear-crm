<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class CommonPartsTableSeeder extends Seeder {

	public function run()
	{
		$data = array(
					//array('part'=>'FExample')
				);

		DB::Table('common_parts')->insert($data);
		//Part::create($data);
	}

}