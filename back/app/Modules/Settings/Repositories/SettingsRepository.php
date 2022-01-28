<?php

declare(strict_types=1);

namespace App\Modules\Settings\Repositories;

use App\Base\Repositories\AbstractRepository;
use App\Modules\Settings\Models\Page;

class SettingsRepository extends AbstractRepository
{
    public function getPages()
    {
        return Page::query()->where('slug', '')->with([
            'headerBlocks',
            'footerBlocks',
            'networkMapBlocks',
            'textBlocks',
        ])->get();
    }
}
