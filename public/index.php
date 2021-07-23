<?php

    require_once __DIR__ . '/../vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();

    use app\config\Application;
    use app\src\controllers\SiteController;
    use app\src\controllers\PostsController;
    use app\src\controllers\PortfolioController;
    use app\src\controllers\UsersController;

    $app = new Application();

    $app->router->get('/alkoma_blog/', array(SiteController::class, 'home'));
    $app->router->post('/alkoma_blog/', array(SiteController::class, 'home'));
    $app->router->get('/alkoma_blog/posts', array(PostsController::class, 'indexPosts'));
    $app->router->get('/alkoma_blog/portfolio', array(PortfolioController::class, 'indexPortfolio'));
    $app->router->get('/alkoma_blog/connexion', array(UsersController::class, 'registerOrLogin'));
    $app->router->post('/alkoma_blog/login', array(UsersController::class, 'registerOrLogin'));
    $app->router->post('/alkoma_blog/register', array(UsersController::class, 'registerOrLogin'));

    $app->run();

