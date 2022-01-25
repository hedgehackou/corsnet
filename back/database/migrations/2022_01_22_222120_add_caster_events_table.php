<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCasterEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caster_events', function (Blueprint $table) {
            $table->unsignedBigInteger('caster_id');
            $table->string('name');
            $table->timestamp('timestamp');
            $table->json('data');
            $table->foreign('caster_id')->references('id')->on('casters');
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
