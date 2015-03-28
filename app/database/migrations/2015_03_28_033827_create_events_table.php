<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('events', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('event_category_id');
			$table->integer('user_id');
			$table->integer('city_id');
			$table->integer('default_photo_id');
			$table->integer('cover_photo_id');
			$table->string('name', 40);
			$table->text('description');
			$table->text('stewardship');
			$table->string('location', 100);
			$table->string('email', 40)->nullable();
			$table->string('website_url', 100)->nullable();
			$table->string('social_media_urls', 250)->nullable()->comment('split by ;');
			$table->string('slug', 50);
			$table->integer('started_at');
			$table->integer('ended_at');
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
		Schema::drop('events');
	}

}
