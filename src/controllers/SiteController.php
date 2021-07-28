<?php


namespace app\src\controllers;


use app\config\Application;
use app\config\Controller;
use app\src\form\MessagesType;
use app\src\models\Messages;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class SiteController
 * @package app\controllers
 */
class SiteController extends Controller
{
    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function home(){

        var_dump($this::$user);
        //form building
        $message = new Messages();
        $messagesForm = (new MessagesType($message, "", "post"))->createForm();

        //form validation
            //check if form is submitted
        if (Application::$app->request->isPost(Application::$app->request->getMethod())){
            //getting form data
            $data = Application::$app->request->getRequestData();

            //hydration of the class
            $message->loadData($data);

            //check if form is valid and do actions
            if ($message->isValid()){
                $message->new();
                Application::$app->flashMessage->success('Votre message a été envoyé avec succès.', '/alkoma_blog/');
            }
        }

        echo $this::twig()->render('front-office/home.html.twig', [
            'messageForm' => $messagesForm,
            'userId'        => $this::$user->getId(),
        ]);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function _404(){
        echo $this::twig()->render('/errors/_404.html.twig');
    }
}