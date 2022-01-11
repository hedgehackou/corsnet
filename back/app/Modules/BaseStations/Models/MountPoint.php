<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Models;

use App\Base\Models\AbstractModel;

/**
 * @property int $id
 * @property int $base_id
 * @property string $name
 * @property string $user_name
 * @property string $password
 * @property string $ntrip_version
 * @property boolean $is_encrypted
 */
class MountPoint extends AbstractModel
{
    public const NTRIP_VERSIONS = ['1', '2', 'universal'];

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
}
