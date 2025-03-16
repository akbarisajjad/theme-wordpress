<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2183873200296315f29891cffc1afa04
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Seokar\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Seokar\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2183873200296315f29891cffc1afa04::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2183873200296315f29891cffc1afa04::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2183873200296315f29891cffc1afa04::$classMap;

        }, null, ClassLoader::class);
    }
}
