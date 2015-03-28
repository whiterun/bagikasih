<?php

class SocialActionCategoriesSeeder extends Seeder{

	public function run()
	{
		$table = 'social_action_categories';

		DB::table($table)->truncate();

		$data = array(
			0 => array(
				'id'			=> 1,
				'name' 			=> 'Biaya Pengobatan',
				'status' 		=> 1,
				'created_at'	=> time(),
				'updated_at' 	=> time(),
			),
			1 => array(
				'id'			=> 2,
				'name' 			=> 'Pengumpulan Dana',
				'status' 		=> 1,
				'created_at'	=> time(),
				'updated_at' 	=> time(),
			),
		);

		DB::table($table)->insert($data);
	}

}