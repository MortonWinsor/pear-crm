<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class TypesTableSeeder extends Seeder {

	public function run()
	{
		$data = array(
					array('name'=>'Lawn Mowers'),
					array('name'=>'Lawn Tractors'),
					array('name'=>'Chainsaws'),
					array('name'=>'Bushcutters'),
					array('name'=>'Blowers'),
					array('name'=>'Hedge Trimmers'),
					array('name'=>'Log Splitters')
				);

		DB::Table('types')->insert($data);
		//Type::create($data);
	}

}