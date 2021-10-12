<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('taxonomy_id');
			$table->text('post_title');
			$table->text('post_title_slug');
			$table->text('post_excerpt')->nullable();
			$table->text('post_content');
			$table->unsignedInteger('post_views');
			$table->unsignedTinyInteger('post_status')->default(0); // 0, 1
			$table->unsignedTinyInteger('comment_status')->default(1); // 0, 1
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('taxonomy_id')->references('id')->on('taxonomies');
		});
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('posts');
	}
}
