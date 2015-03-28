<?php

class CountriesTableSeeder extends Seeder{

	public function run()
	{
		$table = 'countries';

		DB::table($table)->truncate();

		$data = array(
			0 => array(
				'id' 			=> 1,
				'name' 			=> 'Indonesia',
				'status' 		=> 1,
				'created_at'	=> time(),
				'updated_at' 	=> time(),
			)
		);

		DB::table($table)->insert($data);
	}

}