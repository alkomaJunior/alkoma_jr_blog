<?php


namespace app\config;
use app\src\models\Users;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;


/**
 * Class Controller
 * @package app\config
 */
class Controller
{
    protected static Users $user;

    public function __construct()
    {
        if (!empty(Application::$app->flashMessage->hasMessages())){
            Application::$app->flashMessage->display();
        }

        self::$user = Application::$app->getUser() ?? [];

    }

    public static function twig(): Environment
    {
        $loader = new FilesystemLoader(__DIR__.'/../templates');
        return new Environment($loader, [
            'cache' => false, //'/path/to/compilation_cache',
        ]);
    }
}