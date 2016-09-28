<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('password');
            $table->string('email')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('avatar')->nullable();
            $table->string('timezone')->default('us/eastern');
            $table->boolean('is_suspended')->default(0);
            $table->double('balance', 0, 2);
            $table->string('address')->nullable();
            $table->boolean('isvisible_address')->default(1);
            $table->date('birth_date')->nullable();
            $table->boolean('isvisible_birth_date')->default(1);
            $table->string('license_num')->nullable();
            $table->boolean('is_visible_license_num')->default(1);
            $table->json('policies');
            $table->boolean('is_visible_policies');
            $table->string('external_email')->nullable();
            $table->boolean('is_visible_external_email')->default(1);
            $table->rememberToken();
            $table->timestamps();
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
