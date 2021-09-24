<?php


namespace app\src\controllers;


use app\config\Application;
use app\config\Controller;
use app\src\form\MeType;
use app\src\models\Me;
use app\src\traits\BackOfficeProtection;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class PersonalDataController extends Controller
{
    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function indexPersonalData(): string
    {

        (new BackOfficeProtection())->checkForAdminStatus();

        $me = new Me();
        $myMe = $me->findOne(['id' => 1]);

        return $this::twig()->render('back-office/personalData/personalDataList.html.twig', [
                'myMe'        => $myMe,
                'user'        => $this::$user,
                'me'          => (new Me())->findOne(['id' => 1]),
            ]
        );
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function meEdit(): string
    {

        (new BackOfficeProtection())->checkForAdminStatus();

        $me = (new Me())->findOne(['id' => filter_input(INPUT_GET, 'id')]);
        $meForm = (new MeType($me, "me-edit?id=".filter_input(INPUT_GET, 'id')."", "post"))->createForm();

        if (Application::$app->request->isPost(Application::$app->request->getMethod())){
            $data = Application::$app->request->getRequestData();
            $me->loadData($data);
            if ($me->isValid()){
                $me->edit(['id' => $me->getId()]);
                Application::$app->flashMessage->success('Informations éditées avec succès.', 'me');
            }

            Application::$app->flashMessage->error("Votre formulaire contient des erreurs....!");
            Application::$app->flashMessage->display();

        }

        return $this::twig()->render('back-office/personalData/meEdit.html.twig', [
            'meForm'      => $meForm,
            'user'        => $this::$user,
            'me'          => (new Me())->findOne(['id' => 1]),
        ]);
    }
}