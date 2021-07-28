<?php


namespace app\src\controllers;


use app\config\Application;
use app\config\Controller;
use app\src\models\Messages;
use app\src\models\Users;

class MessagesController extends Controller
{
    public function indexMessages()
    {
        if (empty($this::$user) || $this::$user->getRole() != "ADMIN")
        {
            Application::$app->flashMessage->error('Vous n\'avez pas accès à cette ressource', '/alkoma_blog/');
        }

        $messages = new Messages();
        $messagesList = $messages->all();

        echo $this::twig()->render('back-office/messagesList.html.twig', [
            'messagesList' => $messagesList,
        ]);
    }
}