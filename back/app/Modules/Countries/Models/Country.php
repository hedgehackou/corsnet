<?php

declare(strict_types=1);

namespace App\Modules\Countries\Models;

use App\Base\Models\AbstractModel;

/**
 * @property int $id
 * @property string $name
 * @property string $alpha_2
 * @property string $country_code
 */
class Country extends AbstractModel
{
    public $timestamps = false;

    protected $table = 'countries';
    protected $fillable = [
        'name',
        'alpha_2',
        'country_code',
    ];
}
