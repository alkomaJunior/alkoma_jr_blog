<?php


namespace app\src\controllers;


use app\config\Controller;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class PostsController extends Controller
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function indexPosts(){
        echo $this::twig()->render('front-office/posts.html.twig');
    }
}