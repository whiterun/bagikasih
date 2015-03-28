<?php

class EventCategoriesSeeder extends Seeder{

	public function run()
	{
		$table = 'event_categories';

		DB::table($table)->truncate();

		$data = array(
			0 => array(
				'id' 			=> 1,
				'name' 			=> 'Event Umum',
				'status' 		=> 1,
				'created_at'	=> time(),
				'updated_at' 	=> time(),
			),
			1 => array(
				'id' 			=> 2,
				'name' 			=> 'Event Sosial',
				'status' 		=> 1,
				'created_at'	=> time(),
				'updated_at' 	=> time(),
			),
			2 => array(
				'id' 			=> 3,
				'name' 			=> 'Tantangan Sosial',
				'status' 		=> 1,
				'created_at'	=> time(),
				'updated_at' 	=> time(),
			),
		);

		DB::table($table)->insert($data);
	}

}