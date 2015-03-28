<?php

class SocialTargetCategoriesSeeder extends Seeder{

	public function run()
	{
		$table = 'social_target_categories';

		DB::table($table)->truncate();

		$data = array(
			0 => array(
				'id'			=> 1,
				'name' 			=> 'Panti Asuhan',
				'status' 		=> 1,
				'created_at'	=> time(),
				'updated_at' 	=> time(),
			),
			1 => array(
				'id'			=> 2,
				'name' 			=> 'Panti Jompo',
				'status' 		=> 1,
				'created_at'	=> time(),
				'updated_at' 	=> time(),
			),
			2 => array(
				'id'			=> 3,
				'name' 			=> 'Yayasan Difabel',
				'status' 		=> 1,
				'created_at'	=> time(),
				'updated_at' 	=> time(),
			),
			3 => array(
				'id'			=> 4,
				'name' 			=> 'Lembaga Sosial',
				'status' 		=> 1,
				'created_at'	=> time(),
				'updated_at' 	=> time(),
			),
			4 => array(
				'id'			=> 5,
				'name' 			=> 'Orang Sakit',
				'status' 		=> 1,
				'created_at'	=> time(),
				'updated_at' 	=> time(),
			),
		);

		DB::table($table)->insert($data);
	}

}