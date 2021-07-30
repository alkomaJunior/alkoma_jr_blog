<?php


namespace app\src\controllers;


use app\config\Application;
use app\config\Controller;
use app\src\models\Me;
use app\src\models\Messages;
use app\src\traits\BackOfficeProtection;

class MessagesController extends Controller
{
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

    public function showMessages(){

        (new BackOfficeProtection())->checkForAdminStatus();

        $message = new Messages();
        $myMessage = $message->findOne(['id' => (int)$_GET['id']]);

        $myMessage->setIsRead(1);
        $myMessage->edit(['id' => $myMessage->getId()]);

        echo $this::twig()->render('back-office/messages/messagesShow.html.twig', [
            'myMessage'      => $myMessage,
            'user'        => $this::$user,
            'me'          => (new Me())->findOne(['id' => 1]),
        ]);
    }
}