<?php

declare(strict_types=1);

namespace App\Modules\Settings\Models;

use App\Base\Models\AbstractModel;

/**
 * @property string $address
 * @property string $phone
 * @property string $email
 * @property boolean $is_deletable
 */
class FooterBlock extends AbstractModel
{
    protected $table = 'footer_blocks';
    public $timestamps = false;

    protected $fillable = [
        'address',
        'phone',
        'email',
        'is_deletable',
    ];

    protected $casts = [
        'is_deletable' => 'boolean'
    ];
}
