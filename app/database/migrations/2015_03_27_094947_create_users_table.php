<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('default_photo_id')->nullable();
			$table->integer('city_id')->nullable();
			$table->string('firstname', 40);
			$table->string('lastname', 40);
			$table->text('description');
			$table->string('email', 40)->unique();
			$table->string('password', 50);
			$table->string('remember_token', 40)->nullable();
			$table->string('phone_number', 20)->nullable();
			$table->string('slug', 25);
			$table->integer('birthday');
			$table->boolean('is_celebrity')->default(0);
			$table->boolean('is_my_social_target_subscriber')->default(0);
			$table->boolean('is_my_social_action_subscriber')->default(0);
			$table->boolean('is_newsletter_subscriber')->default(0);
			$table->integer('status')->default(1);
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
		Schema::drop('users');
	}

}
