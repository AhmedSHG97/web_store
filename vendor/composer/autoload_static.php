<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3338e0317a728448e4fd70664d739281
{
    public static $prefixLengthsPsr4 = array (
        'J' => 
        array (
            'JasonGuru\\LaravelMakeRepository\\' => 32,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'JasonGuru\\LaravelMakeRepository\\' => 
        array (
            0 => __DIR__ . '/..' . '/jason-guru/laravel-make-repository/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'JasonGuru\\LaravelMakeRepository\\Exceptions\\GeneralException' => __DIR__ . '/..' . '/jason-guru/laravel-make-repository/src/exceptions/GeneralException.php',
        'JasonGuru\\LaravelMakeRepository\\MakeRepository' => __DIR__ . '/..' . '/jason-guru/laravel-make-repository/src/MakeRepository.php',
        'JasonGuru\\LaravelMakeRepository\\RepositoryServiceProvider' => __DIR__ . '/..' . '/jason-guru/laravel-make-repository/src/RepositoryServiceProvider.php',
        'JasonGuru\\LaravelMakeRepository\\Repository\\BaseRepository' => __DIR__ . '/..' . '/jason-guru/laravel-make-repository/src/repository/BaseRepository.php',
        'JasonGuru\\LaravelMakeRepository\\Repository\\RepositoryContract' => __DIR__ . '/..' . '/jason-guru/laravel-make-repository/src/repository/RepositoryContract.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3338e0317a728448e4fd70664d739281::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3338e0317a728448e4fd70664d739281::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3338e0317a728448e4fd70664d739281::$classMap;

        }, null, ClassLoader::class);
    }
}