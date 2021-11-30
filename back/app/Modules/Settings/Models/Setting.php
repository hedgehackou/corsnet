<?php

declare(strict_types=1);

namespace App\Modules\Settings\Models;

use App\Base\Models\AbstractModel;

/**
 * @property string $network_name
 * @property string $lang
 */
class Setting extends AbstractModel
{
    protected string $table = 'settings';
    public $timestamps = false;

    protected array $fillable = [
        'network_name',
        'lang'
    ];
}
