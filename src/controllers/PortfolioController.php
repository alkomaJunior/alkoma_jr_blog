<?php


namespace app\src\controllers;


use app\config\Controller;
use app\src\models\Me;
use app\src\models\Portfolio;
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

        $totalOfPortfolio = (new Portfolio())->numberOfModels()[0];
        $perPage = 8;
        $numberOfPages = ceil($totalOfPortfolio/$perPage);
        if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $numberOfPages){
            $currentPage = $_GET['page'];
        }
        else{
            $currentPage = 1;
        }
        $portfolio = (new Portfolio())->allPaginate($currentPage, $perPage);
        echo $this::twig()->render('front-office/portfolio.html.twig', [
            'user'          => $this::$user,
            'me'            => (new Me())->findOne(['id' => 1]),
            'portfolio'         => $portfolio,
            'numberOfPages' => $numberOfPages,
            'currentPage'   => $currentPage,
        ]);
    }

}