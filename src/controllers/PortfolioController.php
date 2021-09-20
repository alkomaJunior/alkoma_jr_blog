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
        $perPage = 2;
        $currentPage = filter_input(INPUT_GET, 'page');
        $numberOfPages = ceil($totalOfPortfolio/$perPage);
        if (isset($currentPage) && $currentPage > 0 && $currentPage <= $numberOfPages){
            $currentPage = filter_input(INPUT_GET, 'page');
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


    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function singlePortfolio(){
        $portfolio = new Portfolio();
        $myPortfolio = $portfolio->findOne(['id' => $_GET['id']]);

        echo $this::twig()->render('front-office/portfolioSingle.html.twig', [
            'user'          => $this::$user,
            'me'            => (new Me())->findOne(['id' => 1]),
            'myPortfolio'         => $myPortfolio,
        ]);
    }

}