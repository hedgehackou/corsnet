<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Casters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('casters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('host');
            $table->unsignedBigInteger('port');
            $table->string('operator');
            $table->boolean('nmea');
            $table->unsignedBigInteger('country_id');
            $table->decimal('latitude');
            $table->decimal('longitude');
            $table->string('fallback_host');
            $table->unsignedBigInteger('fallback_port');
            $table->string('misc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
