<?php

declare(strict_types=1);

namespace App\Modules\Installation\Services;

use App\Base\Helpers\SettingsHelper;
use App\Base\Services\AbstractService;
use Illuminate\Support\Facades\DB;

class InstallationService extends AbstractService
{
    /**
     * @param array $data
     *
     * @return bool
     */
    public function connectToDatabase(array $data): bool
    {
        SettingsHelper::setEnv([
            'DB_HOST' => $data['host'],
            'DB_DATABASE' => $data['database'],
            'DB_USERNAME' => $data['username'],
            'DB_PASSWORD' => $data['password'],
        ]);

        try {
            DB::connection()->getPdo();
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}
