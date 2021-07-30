<?php


namespace app\src\controllers;


use app\config\Application;
use app\config\Controller;
use app\src\form\MeType;
use app\src\models\Me;
use app\src\traits\BackOfficeProtection;

class PersonalDataController extends Controller
{
    public function indexPersonalData(){

        (new BackOfficeProtection())->checkForAdminStatus();

        $me = new Me();
        $myMe = $me->findOne(['id' => 1]);

        echo $this::twig()->render('back-office/personalData/personalDataList.html.twig', [
                'myMe'      => $myMe,
                'user'        => $this::$user,
                'me'          => (new Me())->findOne(['id' => 1]),
            ]
        );
    }

    public function meEdit(){

        (new BackOfficeProtection())->checkForAdminStatus();

        $me = (new Me())->findOne(['id' => (int)$_GET['id']]);
        $meForm = (new MeType($me, "me-edit?id=".(int)$_GET['id']."", "post"))->createForm();

        if (Application::$app->request->isPost(Application::$app->request->getMethod())){
            $data = Application::$app->request->getRequestData();
            $me->loadData($data);
            if ($me->isValid()){
                $me->edit(['id' => $me->getId()]);
                Application::$app->flashMessage->success('Informations éditées avec succès.', 'me');
            }
        }

        echo $this::twig()->render('back-office/personalData/meEdit.html.twig', [
            'meForm'      => $meForm,
            'user'        => $this::$user,
            'me'          => (new Me())->findOne(['id' => 1]),
        ]);
    }
}