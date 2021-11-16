<?php

declare(strict_types=1);

namespace App\Base\Helpers;

class SettingsHelper
{
    public static function setEnv(array $items)
    {
        foreach ($items as $key => $value) {
            $path = app()->environmentFilePath();

            file_put_contents($path, preg_replace(
                "/^{$key}=.*/m",
                "{$key}={$value}",
                file_get_contents($path)
            ));
        }
    }
}
