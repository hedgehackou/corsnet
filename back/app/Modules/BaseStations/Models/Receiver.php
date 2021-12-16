<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Models;

use App\Base\Models\AbstractModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $base_station_id
 * @property string $model
 * @property string $serial_number
 * @property string $firmware_version
 * @property int $cutoff
 * @property string $installed_at
 * @property string $removed_at
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class Receiver extends AbstractModel
{
    use SoftDeletes;

    protected $table = 'receivers';
    protected $fillable = [
        'base_station_id',
        'model',
        'serial_number',
        'firmware_version',
        'cutoff',
        'installed_at',
        'removed_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $casts = [];
}
