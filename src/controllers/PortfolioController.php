<?php


namespace app\src\controllers;


use app\config\Application;
use app\config\Controller;
use app\src\form\PortfolioType;
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

    public function newPortfolio(){

        (new BackOfficeProtection())->checkForAdminStatus();

        //form building
        $portfolio = new Portfolio();
        $portfolioForm = (new PortfolioType($portfolio, "portfolio-new", "post"))->createForm();

        //form validation
        //check if form is submitted
        if (Application::$app->request->isPost(Application::$app->request->getMethod())){
            //getting form data
            $data = Application::$app->request->getRequestData();

            //hydration of the class
            $portfolio->loadData($data);

            //check if form is valid and do actions
            if ($portfolio->isValid()){
                $portfolio->setImage(rand(1, 9));
                $portfolio->new();
                Application::$app->flashMessage->success('Nouveau projet enregistré avec succès.', 'portfolio-index');
            }
            else{
                Application::$app->flashMessage->error("Votre formulaire contient des erreurs....!");
                Application::$app->flashMessage->display();
            }
        }

        echo $this::twig()->render('back-office/portfolio/portfolioNew.html.twig', [
            'portfolioForm'   => $portfolioForm,
            'user'        => $this::$user,
            'request'     => 'add',
            'me'          => (new Me())->findOne(['id' => 1]),
        ]);
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function showPortfolio(){

        (new BackOfficeProtection())->checkForAdminStatus();

        $portfolio = new Portfolio();
        $myPortfolio = $portfolio->findOne(['id' => (int)$_GET['id']]);

        echo $this::twig()->render('back-office/portfolio/portfolioShow.html.twig', [
            'myPortfolio'         => $myPortfolio,
            'user'                => $this::$user,
            'me'                  => (new Me())->findOne(['id' => 1]),
        ]);
    }

}