<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Models;

use App\Base\Models\AbstractModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $base_station_id
 * @property string $model
 * @property string $serial_number
 * @property float $up_eccentricity
 * @property float $north_eccentricity
 * @property float $east_eccentricity
 * @property string $alignment
 * @property string $installed_at
 * @property string $removed_at
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class Antenna extends AbstractModel
{
    use SoftDeletes;

    protected $table = 'antennas';
    protected $fillable = [
        'base_station_id',
        'model',
        'serial_number',
        'up_eccentricity',
        'north_eccentricity',
        'east_eccentricity',
        'alignment',
        'installed_at',
        'removed_at',
    ];
}
