<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('donations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->string('type_name', 40)->comment('social_targets / social_actions');
			$table->integer('type_id')->comment('Id of social_targets / social_actions');
			$table->string('currency', 3)->default('IDR');
			$table->double('total', 20, 2)->default(0);
			$table->text('message')->nullable();
			$table->string('bank_name', 40);
			$table->string('bank_branch', 40);
			$table->string('bank_account', 25);
			$table->integer('city_id');
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
		Schema::drop('donations');
	}

}
