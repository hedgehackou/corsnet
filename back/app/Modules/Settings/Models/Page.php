<?php

declare(strict_types=1);

namespace App\Modules\Settings\Models;

use App\Base\Models\AbstractModel;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property string $id
 * @property string $title
 * @property string $description
 * @property string $slug
 * @property string $sort
 * @property boolean $is_deletable
 */
class Page extends AbstractModel
{
    protected $table = 'pages';
    public $timestamps = false;
    public const BLOCKS = [
        'header_blocks',
        'footer_blocks',
        'text_blocks',
        'network_map_blocks',
    ];
    public const HEADER_BLOCK = 'header';
    public const FOOTER_BLOCK = 'footer';
    public const TEXT_BLOCK = 'text';
    public const GOOGLE_MAP_BLOCK = 'google-map';

    protected $fillable = [
        'title',
        'description',
        'slug',
        'sort',
        'is_deletable',
    ];

    protected $casts = [
        'is_deletable' => 'boolean'
    ];

    public function headerBlocks(): MorphToMany
    {
        return $this->morphedByMany(HeaderBlock::class, 'block', 'page_blocks')->withPivot('sort');
    }

    public function textBlocks(): MorphToMany
    {
        return $this->morphedByMany(TextBlock::class, 'block', 'page_blocks')->withPivot('sort');
    }

    public function networkMapBlocks(): MorphToMany
    {
        return $this->morphedByMany(NetworkMapBlock::class, 'block', 'page_blocks')->withPivot('sort');
    }

    public function footerBlocks(): MorphToMany
    {
        return $this->morphedByMany(FooterBlock::class, 'block', 'page_blocks')->withPivot('sort');
    }
}
