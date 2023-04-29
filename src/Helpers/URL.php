<?php

namespace App\Helpers;

use App\Core\Config;

class URL
{
    public static function url(string $path): string
    {
        $baseUrl = Config::config('app.base_url');
        return $baseUrl . $path;
    }

    public static function path(string $path): string
    {
        $basePath = Config::config('app.base_path');
        return $basePath . $path;
    }

    public static function redirect(string $path): void
    {
        header(sprintf("location: %s", $path));
    }
}
