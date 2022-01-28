<?php

declare(strict_types=1);

namespace App\Modules\Settings\Models;

use App\Base\Models\AbstractModel;

/**
 * @property string $logo
 * @property string $title
 * @property boolean $is_deletable
 */
class HeaderBlock extends AbstractModel
{
    protected $table = 'header_blocks';
    public $timestamps = false;

    protected $fillable = [
        'logo',
        'title',
        'is_deletable',
    ];

    protected $casts = [
        'is_deletable' => 'boolean'
    ];
}
