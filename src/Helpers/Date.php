<?php

namespace App\Helpers;

use App\Core\Config;

class Date
{
    public static function format(string $format = "d F Y H:i", ?string $date = null): string
    {
        $timestamp = is_null($date) ? $date : strtotime($date);

        return date($format, $timestamp);
    }
}
