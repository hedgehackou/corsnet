<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaseStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('base_stations');

        Schema::create('base_stations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('city');
            $table->decimal('latitude');
            $table->decimal('longitude');
            $table->decimal('height');
            $table->boolean('is_online');
            $table->unsignedBigInteger('status_id');
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
        Schema::dropIfExists('base_stations');
    }
}
