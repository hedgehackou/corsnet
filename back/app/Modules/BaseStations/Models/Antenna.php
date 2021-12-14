<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Models;

use App\Base\Models\AbstractModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $model
 * @property string $serial_number
 * @property float $up_eccentricity
 * @property float $north_eccentricity
 * @property float $east_eccentricity
 * @property string $alignment
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
        'name',
        'city',
        'latitude',
        'longitude',
        'height',
        'is_online',
        'status_id',
    ];
    protected $casts = [
        'is_online' => 'boolean',
    ];
}
