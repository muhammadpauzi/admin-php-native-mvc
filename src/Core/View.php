<?php

namespace App\Core;

use function PHPSTORM_META\type;

final class View
{
    private static array $sections = [];
    private static array $data = [];

    public static function view(string $view, array $data = [])
    {
        self::$data = $data;

        $layout = self::getDefaultLayout($data);

        $data['__view'] = $view . ".php";

        // make a new variables from $data array key
        extract($data);

        $e = function ($value) {
            return $this->escape($value);
        };

        ob_start();

        require_once sprintf(
            "%s/%s/%s/%s",
            BASE_DIR,
            Config::config('views.root_folder'),
            Config::config('views.layouts_folder'),
            $layout . '.php'
        );

        return ob_get_clean();
    }

    public static function load(string $view)
    {
        $data = self::$data;
        // make a new variables from $data array key
        extract($data);

        $e = function ($value) {
            return $this->escape($value);
        };

        require_once sprintf(
            "%s/%s/%s",
            BASE_DIR,
            Config::config('views.root_folder'),
            $view
        );
    }

    public static function section(string $section)
    {
        echo self::$sections[$section];
    }

    public static function loadSection(string $section)
    {
        ob_start(); // the end there on endSection method -> ob_get_clean()
        self::$sections[] = [
            'name' => $section
        ];
    }

    public static function escape($value)
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
    }

    public static function endSection()
    {
        $lastSection = array_pop(self::$sections);
        self::$sections[$lastSection['name']] = ob_get_clean();
    }

    public static function getDefaultLayout($data): string
    {
        return isset($data['__layout']) ? $data['__layout'] : Config::config('views.default_layout');
    }
}
