<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAntennasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antennas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('base_station_id');
            $table->string('model');
            $table->string('serial_number');
            $table->decimal('up_eccentricity');
            $table->decimal('north_eccentricity');
            $table->decimal('east_eccentricity');
            $table->decimal('alignment');
            $table->timestamp('installed_at')->nullable();
            $table->timestamp('removed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('antennas');
    }
}
