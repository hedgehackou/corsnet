<?php

declare(strict_types=1);

namespace App\Modules\Settings\Models;

use App\Base\Models\AbstractModel;

/**
 * @property string $network_name
 * @property string $lang
 * @property string $google_map_key
 */
class Setting extends AbstractModel
{
    protected $table = 'settings';
    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = [
        'network_name',
        'lang',
        'google_map_key'
    ];
}
