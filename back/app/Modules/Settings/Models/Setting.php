<?php

declare(strict_types=1);

namespace App\Modules\Settings\Models;

use App\Base\Models\AbstractModel;

/**
 * @property string $network_name
 */
class Setting extends AbstractModel
{
    protected $table = 'settings';
    public $timestamps = false;

    protected $fillable = [
        'network_name',
    ];
}
