<?php

declare(strict_types=1);

namespace App\Modules\Casters\Models;

use App\Base\Models\AbstractModel;

/**
 * @property int $caster_id
 * @property string $name
 * @property string $timestamp
 * @property string $data
 */
class CasterEvent extends AbstractModel
{
    protected $table = 'caster_events';
    protected $fillable = [
        'name',
        'caster_id',
        'timestamp',
        'data',
    ];
    protected $casts = [
        'data' => 'array',
    ];
    public $timestamps = false;
}
