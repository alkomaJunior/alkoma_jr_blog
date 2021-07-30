<?php


namespace app\src\traits;


use app\config\Application;
use app\config\Controller;

class BackOfficeProtection extends Controller
{
    public function checkForAdminStatus(){
        if (empty($this::$user) || $this::$user->getRole() != "ADMIN")
        {
            Application::$app->flashMessage->error('Vous n\'avez pas accès à cette ressource', '/alkoma_blog/');
        }
    }

}