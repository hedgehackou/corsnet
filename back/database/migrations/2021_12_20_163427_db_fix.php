<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

class DbFix extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receivers', function (Blueprint $table) {
            $table->renameColumn('base_station_id', 'base_id');
        });
        Schema::table('antennas', function (Blueprint $table) {
            $table->renameColumn('base_station_id', 'base_id');
        });
        Schema::disableForeignKeyConstraints();
        Artisan::call('db:seed');
        Schema::enableForeignKeyConstraints();
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
