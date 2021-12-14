<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Models;

use App\Base\Models\AbstractModel;

/**
 * @property int $id
 * @property string $alias
 */
class SatelliteSystem extends AbstractModel
{
    protected $table = 'satellite_systems';
    protected $fillable = [
        'alias',
    ];

    public $timestamps = false;
}
