<?php


namespace app\src\controllers;


use app\config\Controller;
use app\src\models\Me;
use app\src\models\Portfolio;
use app\src\traits\BackOfficeProtection;
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
        $numberOfPages = ceil($totalOfPortfolio/$perPage);

        $currentPage = filter_input(INPUT_GET, 'page');

        if (!isset($currentPage) && !($currentPage > 0) && !($currentPage <= $numberOfPages)){
            $currentPage = 1;
        }

        return $this::twig()->render('front-office/portfolio.html.twig', [
            'user'              => $this::$user,
            'me'                => (new Me())->findOne(['id' => 1]),
            'portfolio'         => (new Portfolio())->allPaginate($currentPage, $perPage),
            'numberOfPages'     => $numberOfPages,
            'currentPage'       => $currentPage,
        ]);
    }


    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function singlePortfolio(): string
    {

        $portfolio = new Portfolio();

        return $this::twig()->render('front-office/portfolioSingle.html.twig', [
            'user'                => $this::$user,
            'me'                  => (new Me())->findOne(['id' => 1]),
            'myPortfolio'         => $portfolio->findOne(['id' => filter_input(INPUT_GET, 'id')]),
        ]);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function portfolioList(){

        (new BackOfficeProtection())->checkForAdminStatus();

        $portfolio = new Portfolio();
        $portfolioList = $portfolio->all();
        $_token = $this::$easyCSRF->generate('portfolio_csrf_token');

        echo $this::twig()->render('back-office/portfolio/portfolioList.html.twig', [
            'portfolioList'        => $portfolioList,
            'user'                 => $this::$user,
            '_token'               => $_token,
            'me'                   => (new Me())->findOne(['id' => 1]),
        ]);
    }

}