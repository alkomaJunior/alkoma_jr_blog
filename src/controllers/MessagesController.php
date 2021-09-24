<?php


namespace app\src\controllers;

use app\config\Controller;
use app\src\models\Me;
use app\src\models\Messages;
use app\src\traits\BackOfficeProtection;
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
    public function messagesList()
    {
        (new BackOfficeProtection())->checkForAdminStatus();

        $messages = new Messages();
        $messagesList = $messages->all();

        echo $this::twig()->render('back-office/messages/messagesList.html.twig', [
            'messagesList' => $messagesList,
            'me'          => (new Me())->findOne(['id' => 1]),
        ]);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function showMessages(){

        (new BackOfficeProtection())->checkForAdminStatus();

        $myMessage = (new Messages())->findOne(['id' => (int)$_GET['id']]);

        $myMessage->markIsRead(['id' => $myMessage->getId()]);

        echo $this::twig()->render('back-office/messages/messagesShow.html.twig', [
            'myMessage'      => $myMessage,
            'user'           => $this::$user,
            'me'             => (new Me())->findOne(['id' => 1]),
        ]);
    }
}