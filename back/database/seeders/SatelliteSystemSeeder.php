<?php

namespace Database\Seeders;

use App\Modules\BaseStations\Models\SatelliteSystem;
use Illuminate\Database\Seeder;

class SatelliteSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
    }
}
