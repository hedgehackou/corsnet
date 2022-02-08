<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMountPointDescription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists("mount_point_descriptions");
        Schema::create('mount_point_descriptions', function (Blueprint $table) {
            $table->unsignedBigInteger("mount_point_id");
            $table->string('mountpoint')->default("");
            $table->string('identifier')->default("");
            $table->string('format')->default("");
            $table->string('format_details')->default("");
            $table->integer('carrier')->default(0);
            $table->string('nav_system')->default("");
            $table->string('network')->default("");
            $table->string('country')->default("AF");
            $table->decimal('latitude', 5, 2)->default(0);
            $table->decimal('longitude', 5, 2)->default(0);
            $table->integer('nmea')->default(0);
            $table->integer('solution')->default(0);
            $table->string('generator')->default("");
            $table->string('compr_encryp')->default("none");
            $table->string('authentication')->default("B");
            $table->string('fee')->default("N");
            $table->integer('bitrate')->default(0);
            $table->string('misc')->default("");

            $table->foreign('mount_point_id')->references('id')->on('mount_points');
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
