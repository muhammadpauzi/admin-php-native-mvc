<?php

namespace App\Core;

use App\Helpers\Arr;

final class Config
{
    public static function config(string $config)
    {
        // seperate to array by "."
        $configKeys = explode(".", $config);
        // get first keys as a filename on config folder
        $configFilename = $configKeys[0];

        // remove first key or config file name
        array_shift($configKeys);

        // join into a string again
        $configKeys = join(".", $configKeys);

        // get array from the config folder file
        $configs = include (sprintf("%s/config/%s.php", BASE_DIR, $configFilename)) ?? [];

        // get multi dimentional array by given config keys with array helper
        $values = Arr::getValueByKey(
            $configKeys,
            $configs
        );

        return $values;
    }

    public static function isDev()
    {
        return self::config('app.env') != 'prod';
    }
}
