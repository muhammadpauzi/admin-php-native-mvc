<?php

namespace App\Core;

use App\Helpers\Arr;

final class Flash
{
    public static function set(string $key, mixed $value = null)
    {
        $_SESSION['_flash'][$key] = $value;
    }

    public static function check(string $key)
    {
        return isset($_SESSION['_flash'][$key]);
    }

    public static function get(string $key)
    {
        if (isset($_SESSION['_flash'][$key])) {
            $flash = $_SESSION['_flash'][$key];
            unset($_SESSION['_flash'][$key]);

            return $flash;
        }

        return null;
    }
}
