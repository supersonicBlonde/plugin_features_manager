<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf832eff0df263f6d55cb445654d283a6
{
    public static $prefixLengthsPsr4 = array (
        'I' => 
        array (
            'Inc\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Inc\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf832eff0df263f6d55cb445654d283a6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf832eff0df263f6d55cb445654d283a6::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}