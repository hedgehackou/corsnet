<?php

namespace Database\Seeders;

use App\Modules\BaseStations\Models\SatelliteSystem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SatelliteSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        SatelliteSystem::query()->truncate();
        SatelliteSystem::query()->insert([
            ['alias' => 'GPS'],
            ['alias' => 'GLO'],
            ['alias' => 'GAL'],
            ['alias' => 'BDS'],
            ['alias' => 'QZSS'],
            ['alias' => 'SBAS'],
            ['alias' => 'IRNSS'],
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
