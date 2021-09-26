<?php

namespace app\config;

use app\src\models\Users;
use Plasticbrain\FlashMessages\FlashMessages;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class Application
 * @package app\config
 */
class Application
{
    const EVENT_BEFORE_REQUEST = 'beforeRequest';

    protected array $eventListeners = [];

    public Router $router;
    public Request $request;
    public Response $response;
    public Database $db;
    public FlashMessages $flashMessage;
    public static Application $app;
    public Controller $controller;
    public ?UserModel $user;
    public Session $session;

    public function __construct()
    {
        // Database configuration
        $config = [
            'db' => [
                'dsn'      => filter_var(filter_var_array($_ENV)['DB_DSN']),
                'user'     => filter_var(filter_var_array($_ENV)['DB_USER']),
                'password' => filter_var(filter_var_array($_ENV)['DB_PASSWORD']),
            ]
        ];
        $this->db = new Database($config['db']);

        $this->session = new Session();

        self::$app = $this;

        $this->request = new Request();

        $this->flashMessage = new FlashMessages();
        $this->flashMessage->setMsgWrapper("<div class='%s text-center' style='margin-left: 250px; margin-right: 280px; margin-top: 75px;'><b>%s</b></div>\n");

        $this->response = new Response();

        $this->router = new Router($this->request, $this->response);
    }

    public function getUser(): Users{
        $this->user = new Users();
        $userId = Application::$app->session->get('user');
        if ($userId) {
            return $this->user = $this->user->findOne(['id' => $userId]);
        }

        return $this->user = new Users();

    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    // To test if route exist. If not return a 404 page
    public function run()
    {
        $this->triggerEvent(self::EVENT_BEFORE_REQUEST);
        try {
            print $this->router->resolve();
        } catch (\Exception $e) {
            return $this->controller::twig()->render('', [
                'exception' => $e,
            ]);
        }
    }

    // To test and call the appropriate controller when receive request
    public function triggerEvent($eventName)
    {
        $callbacks = $this->eventListeners[$eventName] ?? [];
        foreach ($callbacks as $callback) {
            call_user_func($callback);
        }
    }

    public function on($eventName, $callback)
    {
        $this->eventListeners[$eventName][] = $callback;
    }

    // To log user by role
    public function login(UserModel $user): bool
    {
        $this->user = $user;
        self::$app->session->set('user', $this->user->getId());

        if ($this->getUser()->getRole() === "USER"){

            $this->response->redirect('/alkoma_blog/');
        }
        $this->response->redirect('/alkoma_blog/me');

        return true;
    }

    // To logout user
    public function logout()
    {
        $this->user = null;
        self::$app->session->remove('user');
    }

}