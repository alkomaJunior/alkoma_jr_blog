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

        //form building
        $message = new Messages();
        $messagesForm = new MessagesType($message, "", "post");

        $formBody = $messagesForm->buildForm()['body'];
        $formClose = $messagesForm->buildForm()['end'];

        //form validation
            //check if form is submitted
        if (Application::$app->request->isPost(Application::$app->request->getMethod())){
            //getting form data
            $data = Application::$app->request->getRequestData();

            //hydration of the class
            $message->loadData($data);

            //check if form is valid and do actions
            if ($message->isValid()){
                echo "validate success";
            }
            echo "google";
            var_dump($data);
        }

        echo $this::twig()->render('front-office/home.html.twig', [
            'formOpen' => $messagesForm,
            'field1' => $formBody[0],
            'field2' => $formBody[1],
            'field3' => $formBody[2],
            'field4' => $formBody[3],
            'formClose' => $formClose,
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