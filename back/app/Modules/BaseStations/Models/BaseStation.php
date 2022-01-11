<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Models;

use App\Base\Models\AbstractModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property string $city
 * @property float $latitude
 * @property float $longitude
 * @property float $height
 * @property bool $is_online
 * @property int $status_id
 * @property string $created_at
 * @property string $updated_at
 */
class BaseStation extends AbstractModel
{
    use SoftDeletes;

    public const ACTIVE_STATUS = 1;
    public const DISABLED_STATUS = 2;

    public const STATUSES = [
        'active' => self::ACTIVE_STATUS,
        'disabled' => self::DISABLED_STATUS,
    ];

    protected $table = 'base_stations';
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
