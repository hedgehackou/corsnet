<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Models;

use App\Base\Models\AbstractModel;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $base_id
 * @property string $name
 * @property string $user_name
 * @property string $password
 * @property string $ntrip_version
 * @property boolean $is_encrypted
 * @property MountPointDescription $mountPointDescription
 */
class MountPoint extends AbstractModel
{
    public const NTRIP_VERSIONS = ['1', '2', 'universal'];
    public const CARRIERS = [
        0 => 'No',
        1 => 'Yes, L1',
        2 => 'Yes, L1&L2'
    ];
    public const NMEA = [
        0 => 'Client must not send NMEA message with approximate position to Caster',
        1 => 'Client must send NMEA GGA',
    ];
    public const SOLUTION = [
        0 => 'Single base',
        1 => 'Network',
    ];
    public const FEE = [
        'N' => 'No user fee',
        'Y' => 'Usage is charged',
    ];

    protected $table = 'mount_points';
    protected $fillable = [
        'base_id',
        'name',
        'user_name',
        'password',
        'ntrip_version',
        'is_encrypted',
    ];
    protected $casts = [
        'is_encrypted' => 'boolean',
    ];
    public $timestamps = false;

    /**
     * @return HasOne
     */
    public function mountPointDescription(): HasOne
    {
        return $this->hasOne(MountPointDescription::class, 'mount_point_id');
    }
}
