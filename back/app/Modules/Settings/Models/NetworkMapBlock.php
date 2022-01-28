<?php

declare(strict_types=1);

namespace App\Modules\Settings\Models;

use App\Base\Models\AbstractModel;

/**
 * @property string $title
 * @property string $text
 * @property string $longitude
 * @property string $latitude
 * @property string $zoom
 */
class NetworkMapBlock extends AbstractModel
{
    protected $table = 'network_map_blocks';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'text',
        'longitude',
        'latitude',
        'zoom',
    ];
}
