<?php

declare(strict_types=1);

namespace App\Modules\Settings\Services;

use App\Base\Services\AbstractService;
use App\Modules\Settings\Models\Setting;

class SettingsService extends AbstractService
{
    /**
     * @return Setting
     */
    public function getSettings(): Setting
    {
        return Setting::firstOrFail();
    }

    /**
     * @param array $data
     *
     * @return void
     */
    public function updateSettings(array $data): Setting
    {
        /** @var Setting $settings */
        $settings = Setting::firstOrFail();
        $settings->update($data);

        return $settings;
    }
}
