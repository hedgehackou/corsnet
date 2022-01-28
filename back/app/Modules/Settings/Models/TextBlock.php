<?php

declare(strict_types=1);

namespace App\Modules\Settings\Models;

use App\Base\Models\AbstractModel;

/**
 * @property string $title
 * @property string $text
 */
class TextBlock extends AbstractModel
{
    protected $table = 'text_blocks';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'text',
    ];
}
