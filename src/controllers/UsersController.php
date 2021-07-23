<?php


namespace app\src\controllers;


use app\config\Application;
use app\config\Controller;
use app\src\form\AuthType;
use app\src\form\UsersType;
use app\src\models\Auth;
use app\src\models\Users;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class UsersController extends Controller
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function registerOrLogin(){

        //form building for register
        $user = new Users();
        $usersForm = new UsersType($user, "register", "post");

        $formBody = $usersForm->buildForm()['body'];
        $formClose = $usersForm->buildForm()['end'];

        //form building for login
        $auth = new Auth();
        $authForm = new AuthType($auth, "login", "post");

        $formContent = $authForm->buildForm()['body'];
        $formClose_ = $authForm->buildForm()['end'];

        //form validation
        //check if form is submitted
        if (Application::$app->request->isPost(Application::$app->request->getMethod())){
            //getting form data
            $data = Application::$app->request->getRequestData();

            if (!empty($data['register'])){
                //hydration of the class
                $user->loadData($data);

                //check if form is valid and do actions
                if ($user->isValid()){
                    echo "validate success register";
                }
                echo "googleR";
                var_dump($data);
            }
            else{
                $auth->loadData($data);

                if ($auth->isValid()){
                    echo "validate success login";
                }
                echo "googleL";
                var_dump($data);
            }
        }

        echo $this::twig()->render('front-office/connexion.html.twig', [
            'formOpen' => $usersForm,
            'fistName' => $formBody[0],
            'lastName' => $formBody[1],
            'email' => $formBody[2],
            'tel' => $formBody[3],
            'pass' => $formBody[4],
            'confirmPass' => $formBody[5],
            'formClose' => $formClose,
            'formOpen_' => $authForm,
            'emailC' => $formContent[0],
            'passwordC' => $formContent[1],
            'formClose_' => $formClose_,
        ]);
    }
}