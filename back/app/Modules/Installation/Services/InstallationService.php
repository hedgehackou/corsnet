<?php

declare(strict_types=1);

namespace App\Modules\Installation\Services;

use App\Base\Helpers\SettingsHelper;
use App\Base\Services\AbstractService;
use Illuminate\Support\Facades\Config;
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

        $customConfig = array_merge(config('database.connections.mysql'), [
            "host" => $data['host'],
            "database" => $data['database'],
            "username" => $data['username'],
            "password" => $data['password'],
        ]);

        config([
            'database.connections.test' => $customConfig,
            'database.default' => 'test',
        ]);
        try {
            DB::connection('test')->getPdo();
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}
