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
            $table->string('referral_id');
            $table->boolean('is_suspended')->default(0);
            $table->double('balance', 0, 2)->default(0.00);
            $table->string('address')->nullable();
            $table->boolean('is_visible_address')->default(1);
            $table->date('birth_date')->nullable();
            $table->boolean('is_visible_birth_date')->default(1);
            $table->string('license_num')->nullable();
            $table->boolean('is_visible_license_num')->default(1);
            $table->text('policies')->nullable();
            $table->boolean('is_visible_policies')->default(1);
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
