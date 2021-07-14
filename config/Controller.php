<?php


namespace app\config;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;


/**
 * Class Controller
 * @package app\config
 */
class Controller
{
    public static function twig(): Environment
    {
        $loader = new FilesystemLoader(__DIR__.'/../templates');
        return new Environment($loader, [
            'cache' => false, //'/path/to/compilation_cache',
        ]);
    }
}