<?php

    require_once __DIR__ . '/../vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();

    use app\config\Application;
    use app\src\controllers\SiteController;
    use app\src\controllers\PostsController;
    use app\src\controllers\PortfolioController;
    use app\src\controllers\UsersController;
    use app\src\controllers\PersonalDataController;
    use app\src\controllers\MessagesController;

    $app = new Application();

    $app->router->get('/alkoma_blog/', array(SiteController::class, 'home'));
    $app->router->post('/alkoma_blog/', array(SiteController::class, 'home'));

    $app->router->get('/alkoma_blog/posts', array(PostsController::class, 'indexPosts'));
    $app->router->get('/alkoma_blog/posts-index', array(PostsController::class, 'postsList'));
    $app->router->get('/alkoma_blog/posts-single', array(PostsController::class, 'singlePosts'));
    $app->router->post('/alkoma_blog/posts-single', array(PostsController::class, 'singlePosts'));
    $app->router->get('/alkoma_blog/posts-new', array(PostsController::class, 'newPosts'));
    $app->router->post('/alkoma_blog/posts-new', array(PostsController::class, 'newPosts'));
    $app->router->get('/alkoma_blog/posts-show', array(PostsController::class, 'showPosts'));
    $app->router->get('/alkoma_blog/posts-edit', array(PostsController::class, 'editPosts'));
    $app->router->post('/alkoma_blog/posts-edit', array(PostsController::class, 'editPosts'));
    $app->router->post('/alkoma_blog/posts-del', array(PostsController::class, 'deletePosts'));

    $app->router->get('/alkoma_blog/portfolio', array(PortfolioController::class, 'indexPortfolio'));

    $app->router->get('/alkoma_blog/connexion', array(UsersController::class, 'registerOrLogin'));
    $app->router->post('/alkoma_blog/login', array(UsersController::class, 'registerOrLogin'));
    $app->router->post('/alkoma_blog/register', array(UsersController::class, 'registerOrLogin'));
    $app->router->get('/alkoma_blog/logout', array(UsersController::class, 'logout'));

    $app->router->get('/alkoma_blog/me', array(PersonalDataController::class, 'indexPersonalData'));
    $app->router->get('/alkoma_blog/me-edit', array(PersonalDataController::class, 'meEdit'));
    $app->router->post('/alkoma_blog/me-edit', array(PersonalDataController::class, 'meEdit'));

    $app->router->get('/alkoma_blog/messages-index', array(MessagesController::class, 'messagesList'));
    $app->router->get('/alkoma_blog/messages-show', array(MessagesController::class, 'showMessages'));

    $app->run();

