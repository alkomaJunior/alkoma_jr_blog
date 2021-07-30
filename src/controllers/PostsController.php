<?php


namespace app\src\controllers;


use app\config\Application;
use app\config\Controller;
use app\src\form\PostsType;
use app\src\models\Me;
use app\src\models\Posts;
use app\src\traits\BackOfficeProtection;
use EasyCSRF\Exceptions\InvalidCsrfTokenException;
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
        echo $this::twig()->render('front-office/posts.html.twig', [
            'user'        => $this::$user,
            'me'          => (new Me())->findOne(['id' => 1]),
        ]);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function singlePosts(){
        echo $this::twig()->render('front-office/postsSingle.html.twig', [
            'user'        => $this::$user,
            'me'          => (new Me())->findOne(['id' => 1]),
        ]);
    }

    public function postsList(){

        (new BackOfficeProtection())->checkForAdminStatus();

        $posts = new Posts();
        $postsList = $posts->all();
        $_token = $this::$easyCSRF->generate('posts_csrf_token');

        echo $this::twig()->render('back-office/posts/postsList.html.twig', [
            'postsList'        => $postsList,
            'user'             => $this::$user,
            '_token'           => $_token,
            'me'          => (new Me())->findOne(['id' => 1]),
        ]);
    }

    public function newPosts(){

        (new BackOfficeProtection())->checkForAdminStatus();

        //form building
        $post = new Posts();
        $postsForm = (new PostsType($post, "posts-new", "post"))->createForm();

        //form validation
        //check if form is submitted
        if (Application::$app->request->isPost(Application::$app->request->getMethod())){
            //getting form data
            $data = Application::$app->request->getRequestData();

            //hydration of the class
            $post->loadData($data);

            //check if form is valid and do actions
            if ($post->isValid()){
                $post->new();
                Application::$app->flashMessage->success('Nouveau post enregistré avec succès.', 'posts-index');
            }
        }

        echo $this::twig()->render('back-office/posts/postsNew.html.twig', [
            'postsForm' => $postsForm,
            'user'        => $this::$user,
            'request'     => 'add',
            'me'          => (new Me())->findOne(['id' => 1]),
        ]);
    }

    public function showPosts(){

        (new BackOfficeProtection())->checkForAdminStatus();

        $post = new Posts();
        $myPost = $post->findOne(['id' => (int)$_GET['id']]);

        echo $this::twig()->render('back-office/posts/postsShow.html.twig', [
            'myPost'      => $myPost,
            'user'        => $this::$user,
            'me'          => (new Me())->findOne(['id' => 1]),
        ]);
    }

    public function editPosts(){

        (new BackOfficeProtection())->checkForAdminStatus();

        $post = (new Posts())->findOne(['id' => (int)$_GET['id']]);
        $postsForm = (new PostsType($post, "posts-edit?id=".(int)$_GET['id']."", "post"))->createForm();

        if (Application::$app->request->isPost(Application::$app->request->getMethod())){
            $data = Application::$app->request->getRequestData();
            $post->loadData($data);
            if ($post->isValid()){
                $post->edit(['id' => $post->getId()]);
                Application::$app->flashMessage->success('Post édité avec succès.', 'posts-index');
            }
        }

        echo $this::twig()->render('back-office/posts/postsNew.html.twig', [
            'postsForm'   => $postsForm,
            'user'        => $this::$user,
            'request'     => 'edit',
            'me'          => (new Me())->findOne(['id' => 1]),
        ]);

    }

    public function deletePosts(){

        $post = (new Posts())->findOne(['id' => (int)$_GET['id']]);

        if (Application::$app->request->isPost(Application::$app->request->getMethod())){

            $data = Application::$app->request->getRequestData();

            if ($data['_method'] === "DELETE"){

                try {
                    $this::$easyCSRF->check('posts_csrf_token', $data['_token'], "", true);
                }
                catch (InvalidCsrfTokenException $e){
                    Application::$app->flashMessage->error($e->getMessage(), 'posts-index');
                }

                $post->remove(['id' => $post->getId()]);
                Application::$app->flashMessage->success('Post supprimé avec succès.', 'posts-index');
            }
        }
    }
}