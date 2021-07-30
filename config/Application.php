<?php

namespace app\config;

use app\src\models\Users;
use Plasticbrain\FlashMessages\FlashMessages;

/**
 * Class Application
 * @package app\config
 */
class Application
{
    const EVENT_BEFORE_REQUEST = 'beforeRequest';
    const EVENT_AFTER_REQUEST = 'afterRequest';

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
        $config = [
            'db' => [
                'dsn' => $_ENV['DB_DSN'],
                'user' => $_ENV['DB_USER'],
                'password' => $_ENV['DB_PASSWORD'],
            ]
        ];
        $this->db = new Database($config['db']);

        $this->session = new Session();

        self::$app = $this;

        $this->request = new Request();

        $this->flashMessage = new FlashMessages();
        $this->flashMessage->setMsgWrapper("<div class='%s' style='margin-left: 250px; margin-right: 280px;'><b>%s</b></div>\n");

        $this->response = new Response();

        $this->router = new Router($this->request, $this->response);
    }

    public function getUser(): Users{
        $this->user = new Users();
        $userId = Application::$app->session->get('user');
        if ($userId) {
            return $this->user = $this->user->findOne(['id' => $userId]);
        }
        else{
            return $this->user = new Users();
        }
    }

    public function run()
    {
        $this->triggerEvent(self::EVENT_BEFORE_REQUEST);
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            echo $this->controller::twig()->render('', [
                'exception' => $e,
            ]);
        }
    }

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

    /**
     * @return Controller
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     * @param Controller $controller
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    public function login(UserModel $user)
    {
        $this->user = $user;
        self::$app->session->set('user', $this->user->getId());

        if ($this->getUser()->getRole() === "USER"){
            $this->response->redirect('/alkoma_blog/');
        }
        else $this->response->redirect('/alkoma_blog/me');

        return true;
    }

    public function logout()
    {
        $this->user = null;
        self::$app->session->remove('user');
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }
}