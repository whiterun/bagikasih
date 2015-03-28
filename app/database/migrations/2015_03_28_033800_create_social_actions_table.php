<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialActionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('social_actions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('social_target_id');
			$table->integer('social_action_category_id');
			$table->integer('user_id');
			$table->integer('city_id');
			$table->integer('default_photo_id');
			$table->integer('cover_photo_id');
			$table->string('name', 40);
			$table->text('description');
			$table->text('stewardship');
			$table->string('slug', 50);
			$table->string('currency', 3)->default('IDR');
			$table->double('total_donation_target', 20, 2)->default(0);
			$table->double('total_donation', 20, 2)->default(0);
			$table->integer('expired_at');
			$table->integer('status')->default(0);
			$table->integer('created_at');
			$table->integer('updated_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('social_actions');
	}

}
