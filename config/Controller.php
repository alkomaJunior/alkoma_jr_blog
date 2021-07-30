<?php


namespace app\config;
use app\src\models\Users;
use EasyCSRF\EasyCSRF;
use EasyCSRF\NativeSessionProvider;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;


/**
 * Class Controller
 * @package app\config
 */
class Controller
{
    protected static Users $user;
    protected static NativeSessionProvider $sessionProvider;
    protected static EasyCSRF $easyCSRF;

    public function __construct()
    {

        self::$sessionProvider = new NativeSessionProvider();
        self::$easyCSRF = new EasyCSRF(self::$sessionProvider);

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