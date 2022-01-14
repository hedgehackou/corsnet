<?php

declare(strict_types=1);

namespace App\Modules\Users\Models;

use App\Base\Models\AbstractModel;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $user_name
 * @property string $password
 * @property string $ntrip_version
 * @property bool $is_encrypted
 */
class Client extends AbstractModel
{
    public const NTRIP_VERSIONS = ['1', '2', 'universal'];

    protected $table = 'clients';
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'name',
        'user_name',
        'password',
        'ntrip_version',
        'is_encrypted',
    ];
}
