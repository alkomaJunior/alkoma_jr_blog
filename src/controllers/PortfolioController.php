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
        $numberOfPages = ceil($totalOfPortfolio/$perPage);

        $currentPage = filter_input(INPUT_GET, 'page');

        if (!isset($currentPage) && !($currentPage > 0) && !($currentPage <= $numberOfPages)){
            $currentPage = 1;
        }

        $portfolio = (new Portfolio())->allPaginate($currentPage, $perPage);

        echo $this::twig()->render('front-office/portfolio.html.twig', [
            'user'              => $this::$user,
            'me'                => (new Me())->findOne(['id' => 1]),
            'portfolio'         => twig_escape_filter($this::twig(), $portfolio, 'html'),
            'numberOfPages'     => addslashes($numberOfPages),
            'currentPage'       => addslashes($currentPage),
        ]);
    }


    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function singlePortfolio(){

        $portfolio = new Portfolio();
        $myPortfolio = $portfolio->findOne(['id' => filter_input(INPUT_GET, 'id')]);

        print_r(
            $this::twig()->render('front-office/portfolioSingle.html.twig', [
            'user'                => $this::$user,
            'me'                  => (new Me())->findOne(['id' => 1]),
            'myPortfolio'         => twig_escape_filter($this::twig(), $myPortfolio, 'html'),
            ])
        );
    }

}