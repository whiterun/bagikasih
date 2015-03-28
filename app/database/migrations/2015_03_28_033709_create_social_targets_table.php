<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialTargetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('social_targets', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('social_target_category_id');
			$table->integer('user_id');
			$table->integer('city_id');
			$table->integer('default_photo_id');
			$table->integer('cover_photo_id');
			$table->string('name', 40);
			$table->text('description');
			$table->text('stewardship');
			$table->string('address', 100);
			$table->string('phone_number', 20)->nullable();
			$table->string('email', 40)->nullable();
			$table->string('social_media_urls', 250)->nullable()->comment('split by ;');
			$table->text('bank_account_description')->nullable();
			$table->string('slug', 50);
			$table->string('currency', 3)->default('IDR');
			$table->double('total_donation', 20, 2)->default(0);
			$table->integer('total_running_social_actions')->default(0);
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
		Schema::drop('social_targets');
	}

}
