<?php

declare(strict_types=1);

namespace App\Base\Services;

abstract class AbstractService
{
    public const MAX_RECORDS = 10;

    public function getPageName(): string
    {
        return 'page';
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        $perPage = request('per_page', 10);

        return (int) ($perPage > self::MAX_RECORDS ? self::MAX_RECORDS : $perPage);
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return (int) request('page', 1);
    }
}
