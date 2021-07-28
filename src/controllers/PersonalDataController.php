<?php


namespace app\src\controllers;


use app\config\Controller;

class PersonalDataController extends Controller
{
    public function indexPersonalData(){
        echo $this::twig()->render('back-office/portfolioList.html.twig');
    }
}