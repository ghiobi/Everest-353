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
            $table->increments('id');
            $table->integer('poster_id')->unsigned()->index();
            $table->morphs('postable');
            $table->string('name');
            $table->text('description');
            $table->boolean('one_time');
            $table->boolean('is_request');
            $table->dateTime('departure_date');
            $table->string('departure_pcode');
            $table->string('destination_pcode');
            $table->integer('num_riders')->unsigned();
            $table->float('cost', 8, 2);

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('poster_id')->
                references('id')->on('users');
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
