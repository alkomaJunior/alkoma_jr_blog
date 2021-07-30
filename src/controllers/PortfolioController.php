<?php


namespace app\src\controllers;


use app\config\Controller;
use app\src\models\Me;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class PortfolioController extends Controller
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function indexPortfolio(){

        echo $this::twig()->render('front-office/portfolio.html.twig', [
            'user'        => $this::$user,
            'me'          => (new Me())->findOne(['id' => 1]),
        ]);
    }

}