<?php

    require_once __DIR__ . '/../vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();

    use app\config\Application;
    use app\src\controllers\SiteController;

    $app = new Application();

    $app->router->get('/', array(SiteController::class, 'home'));

    $app->run();

