<?php

declare(strict_types=1);

namespace App\Modules\Settings\Resources;

use App\Base\Resources\AbstractResource;
use App\Modules\Settings\Models\Page;
use Illuminate\Http\Request;

class PageResource extends AbstractResource
{
    /**
     * @var Page $resource
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     * @throws \Exception
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->resource['id'],
            'title' => $this->resource['title'],
            'description' => $this->resource['description'],
            'slug' => $this->resource['slug'],
            'sort' => $this->resource['sort'],
            'is_deletable' => $this->resource['is_deletable'],
            'blocks' => $this->resource['blocks'],
        ];
    }
}
