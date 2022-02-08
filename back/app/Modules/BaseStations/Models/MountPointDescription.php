<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Models;

use App\Base\Models\AbstractModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $mount_point_id
 * @property string $mountpoint
 * @property string $identifier
 * @property string $format
 * @property string $format_details
 * @property integer $carrier
 * @property string $nav_system
 * @property string $network
 * @property string $country
 * @property float $latitude
 * @property float $longitude
 * @property int $nmea
 * @property int $solution
 * @property string $generator
 * @property string $compr_encryp
 * @property string $authentication
 * @property string $fee
 * @property int $bitrate
 * @property string $misc
 * @property MountPoint $mountPoint
 */
class MountPointDescription extends AbstractModel
{
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = null;
    protected $table = 'mount_point_descriptions';
    protected $fillable = [
        'mountpoint',
        'identifier',
        'format',
        'format_details',
        'carrier',
        'nav_system',
        'network',
        'country',
        'latitude',
        'longitude',
        'nmea',
        'solution',
        'generator',
        'compr_encryp',
        'authentication',
        'fee',
        'bitrate',
        'misc',
    ];

    public function mountPoint(): BelongsTo
    {
        return $this->belongsTo(MountPoint::class, 'mount_point_id');
    }
}
