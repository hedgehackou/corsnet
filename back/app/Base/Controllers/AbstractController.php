<?php

declare(strict_types=1);

namespace App\Base\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Settings\Models\Setting;

abstract class AbstractController extends Controller
{
    protected function resolveLang() {
        try {
            /** @var Setting $setting */
            $setting = Setting::query()->firstOrFail();
            $lang = $setting->lang;
        } catch (\Exception $exception) {
            $lang = 'en';
        }
        if (!in_array($lang, ['en', 'ru'])) {
            $lang = 'en';
        }

        app()->setLocale($lang);
    }
}
