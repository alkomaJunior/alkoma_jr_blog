<?php


namespace app\src\controllers;


use app\config\Application;
use app\config\Controller;
use app\src\form\AuthType;
use app\src\form\UsersType;
use app\src\models\Auth;
use app\src\models\Me;
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
        $usersRegisterForm = (new UsersType($user, "register", "post"))->createForm();

        //form building for login
        $auth = new Auth();
        $authForm = (new AuthType($auth, "login", "post"))->createForm();

        //form validation
        //check if form is submitted
        if (Application::$app->request->isPost(Application::$app->request->getMethod())){
            //getting form data
            $data = Application::$app->request->getRequestData();

            if (!empty($data['register']))
            {
                //hydration of the class
                $user->loadData($data);

                //check if form is valid and do actions
                if ($user->isValid()){
                    $user->setRole("USER");
                    $user->setPassword(password_hash($user->getPassword(), PASSWORD_ARGON2ID));
                    $user->new();
                    Application::$app->flashMessage->success('Thanks for registration', '/alkoma_blog/');
                }
            }
            else
            {
                $auth->loadData($data);
                $user->setEmailAddress($auth->getEmailC());
                $user->setPassword($auth->getPasswordC());

                if ($auth->isValid()){

                    $user = $user->findOne(['emailAddress' => $user->getEmailAddress()]);

                    if (!$user){

                        $auth->addError('emailC', 'Email ou Mot de passe incorrect');
                        $auth->addError('passwordC', 'Email ou Mot de passe incorrect');

                        echo $this::twig()->render('front-office/connexion.html.twig', [
                            'usersRegisterForm' => $usersRegisterForm,
                            'authForm' => $authForm,
                            'me'          => (new Me())->findOne(['id' => 1]),
                        ]);

                        return false;
                    }

                    if (!password_verify($auth->getPasswordC(), $user->getPassword())){

                        $auth->addError('emailC', 'Email ou Mot de passe incorrect');
                        $auth->addError('passwordC', 'Email ou Mot de passe incorrect');

                        echo $this::twig()->render('front-office/connexion.html.twig', [
                            'usersRegisterForm' => $usersRegisterForm,
                            'authForm' => $authForm,
                            'me'          => (new Me())->findOne(['id' => 1]),
                        ]);

                        return false;
                    }

                    return Application::$app->login($user);
                }
            }
        }

        echo $this::twig()->render('front-office/connexion.html.twig', [
            'usersRegisterForm' => $usersRegisterForm,
            'authForm' => $authForm,
            'user'        => $this::$user,
            'me'          => (new Me())->findOne(['id' => 1]),
        ]);

        return "";
    }

    public function logout(){
        Application::$app->logout();
        Application::$app->response->redirect('/alkoma_blog/');
    }
}