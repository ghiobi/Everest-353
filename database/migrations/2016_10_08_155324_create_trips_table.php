<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });

        Schema::create('trip_user', function (Blueprint $table) {
            $table->integer('trip_id')->unsigned()->index();
            $table->integer('rider_id')->unsigned()->index();

            $table->foreign('trip_id')->references('id')
                ->on('trips');
            $table->foreign('rider_id')->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips');
    }
}
