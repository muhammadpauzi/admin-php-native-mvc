<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc5bfbdd82a396408d7dd47b65fb1240f
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Module\\' => 7,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Module\\' => 
        array (
            0 => __DIR__ . '/../..' . '/modules',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc5bfbdd82a396408d7dd47b65fb1240f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc5bfbdd82a396408d7dd47b65fb1240f::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc5bfbdd82a396408d7dd47b65fb1240f::$classMap;

        }, null, ClassLoader::class);
    }
}