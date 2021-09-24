<?php


namespace app\src\controllers;

use app\config\Application;
use app\config\Controller;
use app\src\models\Me;
use app\src\models\Messages;
use app\src\traits\BackOfficeProtection;
use EasyCSRF\Exceptions\InvalidCsrfTokenException;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class MessagesController extends Controller
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function messagesList(): string
    {
        (new BackOfficeProtection())->checkForAdminStatus();

        $messages = new Messages();
        $messagesList = $messages->all();

        $_token = $this::$easyCSRF->generate('message_csrf_token');

        return $this::twig()->render('back-office/messages/messagesList.html.twig', [
            'messagesList'  => $messagesList,
            'me'            => (new Me())->findOne(['id' => 1]),
            '_token'        => $_token,
        ]);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function showMessages(): string
    {

        (new BackOfficeProtection())->checkForAdminStatus();

        $myMessage = (new Messages())->findOne(['id' => filter_input(INPUT_GET, 'id')]);

        $myMessage->markIsRead(['id' => $myMessage->getId()]);

        return $this::twig()->render('back-office/messages/messagesShow.html.twig', [
            'myMessage'      => $myMessage,
            'user'           => $this::$user,
            'me'             => (new Me())->findOne(['id' => 1]),
        ]);
    }

    public function deleteMessages()
    {
        (new BackOfficeProtection())->checkForAdminStatus();

        $portfolio = (new Messages())->findOne(['id' => filter_input(INPUT_GET, 'id')]);

        if (Application::$app->request->isPost(Application::$app->request->getMethod())){

            $data = Application::$app->request->getRequestData();

            if ($data['_method'] === "DELETE"){

                try {
                    $this::$easyCSRF->check('message_csrf_token', $data['_token'], "", true);
                }
                catch (InvalidCsrfTokenException $e){
                    Application::$app->flashMessage->error($e->getMessage(), 'messages-index');
                }

                $portfolio->remove(['id' => $portfolio->getId()]);
                Application::$app->flashMessage->success('Message supprimé avec succès.', 'portfolio-index');
            }
        }
    }
}