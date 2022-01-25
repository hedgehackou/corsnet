<?php

declare(strict_types=1);

namespace App\Modules\Casters\Models;

use App\Base\Models\AbstractModel;
use App\Modules\Countries\Models\Country;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name
 * @property string $host
 * @property number $port
 * @property string $operator
 * @property bool $nmea
 * @property int $country_id
 * @property float $latitude
 * @property float $longitude
 * @property string $fallback_host
 * @property int $fallback_port
 * @property string $misc
 * @property Country $country
 */
class Caster extends AbstractModel
{
    protected $table = 'casters';
    protected $fillable = [
        'name',
        'host',
        'port',
        'operator',
        'nmea',
        'country_id',
        'latitude',
        'longitude',
        'fallback_host',
        'fallback_port',
        'misc',
    ];
    protected $casts = [
        'nmea' => 'boolean',
    ];
    public $timestamps = false;

    /**
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
