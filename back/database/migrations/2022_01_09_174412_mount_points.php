<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MountPoints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mount_points', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('base_id');
            $table->string('name');
            $table->string('user_name');
            $table->string('password');
            $table->string('ntrip_version');
            $table->boolean('is_encrypted')->default(false);

            $table->foreign('base_id')->references('id')->on('base_stations');
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
