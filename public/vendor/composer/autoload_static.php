<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite63726634713ca0a6d855f5b8dba7ce6
{
    public static $files = array (
        '7b43e7494e8d43b65b21fcb3798c1b14' => __DIR__ . '/..' . '/windwalker/utilities/src/bootstrap.php',
        '75aa6620ed10fa59191611a76fc9c564' => __DIR__ . '/..' . '/windwalker/edge/src/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'Windwalker\\Utilities\\' => 21,
            'Windwalker\\Edge\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Windwalker\\Utilities\\' => 
        array (
            0 => __DIR__ . '/..' . '/windwalker/utilities/src',
        ),
        'Windwalker\\Edge\\' => 
        array (
            0 => __DIR__ . '/..' . '/windwalker/edge/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite63726634713ca0a6d855f5b8dba7ce6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite63726634713ca0a6d855f5b8dba7ce6::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInite63726634713ca0a6d855f5b8dba7ce6::$classMap;

        }, null, ClassLoader::class);
    }
}
