<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receivers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('base_station_id');
            $table->string('model');
            $table->string('serial_number');
            $table->string('firmware_version');
            $table->integer('cutoff');
            $table->timestamp('installed_at')->nullable();
            $table->timestamp('removed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('base_station_id')->references('id')->on('base_stations');
        });

        Schema::table('satellite_system_receiver', function (Blueprint $table) {
            $table->foreign('satellite_system_id')->references('id')->on('satellite_systems');
            $table->foreign('receiver_id')->references('id')->on('receivers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receiver');
    }
}
