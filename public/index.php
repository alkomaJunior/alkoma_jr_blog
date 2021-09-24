<?php

    require_once __DIR__ . '/../vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();

    use app\config\Application;
use app\src\controllers\CommentsController;
use app\src\controllers\SiteController;
    use app\src\controllers\PostsController;
    use app\src\controllers\PortfolioController;
    use app\src\controllers\UsersController;
    use app\src\controllers\PersonalDataController;
    use app\src\controllers\MessagesController;

    $app = new Application();

    $app->router->get('/', array(SiteController::class, 'home'));
    $app->router->post('/', array(SiteController::class, 'home'));

    $app->router->get('/posts', array(PostsController::class, 'indexPosts'));
    $app->router->get('/posts-index', array(PostsController::class, 'postsList'));
    $app->router->get('/posts-single', array(PostsController::class, 'singlePosts'));
    $app->router->post('/posts-single', array(PostsController::class, 'singlePosts'));
    $app->router->get('/posts-new', array(PostsController::class, 'newPosts'));
    $app->router->post('/posts-new', array(PostsController::class, 'newPosts'));
    $app->router->get('/posts-show', array(PostsController::class, 'showPosts'));
    $app->router->get('/posts-edit', array(PostsController::class, 'editPosts'));
    $app->router->post('/posts-edit', array(PostsController::class, 'editPosts'));
    $app->router->post('/posts-del', array(PostsController::class, 'deletePosts'));

    $app->router->post('/comments-del', array(CommentsController::class, 'deleteComments'));

    $app->router->get('/portfolio', array(PortfolioController::class, 'indexPortfolio'));
    $app->router->get('/portfolio-index', array(PortfolioController::class, 'portfolioList'));
    $app->router->get('/portfolio-single', array(PortfolioController::class, 'singlePortfolio'));
    $app->router->get('/portfolio-new', array(PortfolioController::class, 'newPortfolio'));
    $app->router->post('/portfolio-new', array(PortfolioController::class, 'newPortfolio'));
    $app->router->get('/portfolio-show', array(PortfolioController::class, 'showPortfolio'));
    $app->router->get('/portfolio-edit', array(PortfolioController::class, 'editPortfolio'));
    $app->router->post('/portfolio-edit', array(PortfolioController::class, 'editPortfolio'));
    $app->router->post('/portfolio-del', array(PortfolioController::class, 'deletePortfolio'));

    $app->router->get('/connexion', array(UsersController::class, 'registerOrLogin'));
    $app->router->post('/login', array(UsersController::class, 'registerOrLogin'));
    $app->router->post('/register', array(UsersController::class, 'registerOrLogin'));
    $app->router->get('/logout', array(UsersController::class, 'logout'));

    $app->router->get('/me', array(PersonalDataController::class, 'indexPersonalData'));
    $app->router->get('/me-edit', array(PersonalDataController::class, 'meEdit'));
    $app->router->post('/me-edit', array(PersonalDataController::class, 'meEdit'));

    $app->router->get('/messages-index', array(MessagesController::class, 'messagesList'));
    $app->router->get('/messages-show', array(MessagesController::class, 'showMessages'));
    $app->router->post('/messages-del', array(MessagesController::class, 'deleteMessages'));

    $app->run();

