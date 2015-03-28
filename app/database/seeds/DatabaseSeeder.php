<?php

class DatabaseSeeder extends Seeder {

	protected $seeds = array(
		'CountriesTableSeeder',
		'CitiesTableSeeder',
		'EventCategoriesSeeder',
		'SocialActionCategoriesSeeder',
		'SocialTargetCategoriesSeeder',
	);

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		foreach($this->seeds as $seed) {
			$this->command->info('Seeding : '.$seed);
			$this->call($seed);
		}
	}
}