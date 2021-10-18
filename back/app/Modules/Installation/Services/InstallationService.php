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

    public function setupSmtp(array $data): bool
    {
        SettingsHelper::setEnv([
            'MAIL_PORT' => $data['port'],
            'MAIL_HOST' => $data['host'],
            'MAIL_USERNAME' => $data['login'],
            'MAIL_PASSWORD' => $data['password'],
            'MAIL_ENCRYPTION' => $data['encryption'],
        ]);

        $customConfig = array_merge(config('mail.mailers.smtp'), [
            "host" => $data['host'],
            "port" => $data['port'],
            "username" => $data['username'],
            "password" => $data['password'],
            "encryption" => $data['encryption'],
        ]);

        config([
            'mail.mailers.test' => $customConfig,
            'mail.default' => 'test',
        ]);
        try {
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}
