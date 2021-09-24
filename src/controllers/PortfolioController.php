<?php


namespace app\src\controllers;


use app\config\Application;
use app\config\Controller;
use app\src\form\PortfolioType;
use app\src\models\Me;
use app\src\models\Portfolio;
use app\src\traits\BackOfficeProtection;
use EasyCSRF\Exceptions\InvalidCsrfTokenException;
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
    public function indexPortfolio(): string
    {

        $totalOfPortfolio = (new Portfolio())->numberOfModels()[0];
        $perPage = 9;
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
    public function portfolioList(): string
    {

        (new BackOfficeProtection())->checkForAdminStatus();

        $portfolio = new Portfolio();
        $portfolioList = $portfolio->all();
        $_token = $this::$easyCSRF->generate('portfolio_csrf_token');

        return $this::twig()->render('back-office/portfolio/portfolioList.html.twig', [
            'portfolioList'        => $portfolioList,
            'user'                 => $this::$user,
            '_token'               => $_token,
            'me'                   => (new Me())->findOne(['id' => 1]),
        ]);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function newPortfolio(): string
    {

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

            Application::$app->flashMessage->error("Votre formulaire contient des erreurs....!");
            Application::$app->flashMessage->display();

        }

        return $this::twig()->render('back-office/portfolio/portfolioNew.html.twig', [
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
    public function showPortfolio(): string
    {

        (new BackOfficeProtection())->checkForAdminStatus();

        $portfolio = new Portfolio();
        $myPortfolio = $portfolio->findOne(['id' => filter_input(INPUT_GET, 'id')]);

        return $this::twig()->render('back-office/portfolio/portfolioShow.html.twig', [
            'myPortfolio'         => $myPortfolio,
            'user'                => $this::$user,
            'me'                  => (new Me())->findOne(['id' => 1]),
        ]);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function editPortfolio(): string
    {

        (new BackOfficeProtection())->checkForAdminStatus();

        $portfolio = (new Portfolio())->findOne(['id' => filter_input(INPUT_GET, 'id')]);
        $portfolioForm = (new PortfolioType($portfolio, "portfolio-edit?id=".filter_input(INPUT_GET, 'id')."", "post"))->createForm();

        if (Application::$app->request->isPost(Application::$app->request->getMethod())){
            $data = Application::$app->request->getRequestData();
            $portfolio->loadData($data);
            if ($portfolio->isValid()){
                $portfolio->edit(['id' => $portfolio->getId()]);
                Application::$app->flashMessage->success('Projet édité avec succès.', 'portfolio-index');
            }

            Application::$app->flashMessage->error("Votre formulaire contient des erreurs....!");
            Application::$app->flashMessage->display();

        }

        return $this::twig()->render('back-office/portfolio/portfolioEdit.html.twig', [
            'portfolioForm'   => $portfolioForm,
            'user'            => $this::$user,
            'request'         => 'edit',
            'me'              => (new Me())->findOne(['id' => 1]),
        ]);

    }

    public function deletePortfolio()
    {
        (new BackOfficeProtection())->checkForAdminStatus();

        $portfolio = (new Portfolio())->findOne(['id' => filter_input(INPUT_GET, 'id')]);

        if (Application::$app->request->isPost(Application::$app->request->getMethod())){

            $data = Application::$app->request->getRequestData();

            if ($data['_method'] === "DELETE"){

                try {
                    $this::$easyCSRF->check('portfolio_csrf_token', $data['_token'], "", true);
                }
                catch (InvalidCsrfTokenException $e){
                    Application::$app->flashMessage->error($e->getMessage(), 'portfolio-index');
                }

                $portfolio->remove(['id' => $portfolio->getId()]);
                Application::$app->flashMessage->success('projet supprimé avec succès.', 'portfolio-index');
            }
        }
    }

}