<?php


namespace app\src\controllers;


use app\config\Application;
use app\config\Controller;
use app\src\form\CommentsType;
use app\src\form\PostsType;
use app\src\models\Comments;
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
    public function indexPosts(): string
    {
        $totalOfPosts = (new Posts())->numberOfModels()[0];
        $perPage = 8;
        $numberOfPages = ceil($totalOfPosts/$perPage);

        $currentPage = filter_input(INPUT_GET, 'page');

        if (!isset($currentPage) && !($currentPage > 0) && !($currentPage <= $numberOfPages)){
            $currentPage = 1;
        }

        $posts = (new Posts())->allPaginate($currentPage, $perPage);

        return $this::twig()->render('front-office/posts.html.twig', [
            'user'          => $this::$user,
            'me'            => (new Me())->findOne(['id' => 1]),
            'posts'         => $posts,
            'numberOfPages' => $numberOfPages,
            'currentPage'   => $currentPage,
        ]);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function singlePosts(): string
    {

        $post = new Posts();
        $commentByPost = new Comments();
        $myPost = $post;
        $method = "";

        $totalOfComment = (new Comments())->numberOfModels()[0];
        $perPage = 8;
        $numberOfPages = ceil($totalOfComment/$perPage);

        $currentPage = filter_input(INPUT_GET, 'page');

        if (!isset($currentPage) && !($currentPage > 0) && !($currentPage <= $numberOfPages)){
            $currentPage = 1;
        }

        if (Application::$app->request->isGet(Application::$app->request->getMethod())){
            $myPost = $post->findOne(['id' => filter_input(INPUT_GET, 'id')]);
            $method = "get";

            $commentByPost = (new Comments())->findByIdPaginate(['idPosts' => $myPost->getId(), 'isValid' => 1], $currentPage, $perPage);

        }

        //form building
        $comment = new Comments();
        $commentForm = (new CommentsType($comment, "posts-single", "post"))->createForm();

        //form validation
        //check if form is submitted
        if (Application::$app->request->isPost(Application::$app->request->getMethod())){
            //getting form data
            $data = Application::$app->request->getRequestData();

            $myPost = $post->findOne(['id' => $data['id']]);
            $method = "post";

            //$commentByPost = (new Comments())->findByIdPaginate(['idPosts' => $myPost->getId(), 'isValid' => 1], $currentPage, $perPage);

            //hydration of the class
            $comment->loadData($data);

            //check if form is valid and do actions
            if ($comment->isValid()){
                $comment->setIdUsers(Application::$app->getUser()->getId());
                $comment->setIdPosts($myPost->getId());
                $comment->setAuthor(Application::$app->getUser()->getFirstName().' '.Application::$app->getUser()->getLastName());
                $comment->new();
                Application::$app->flashMessage->success('Post commenté avec succès. Il sera publié après validation.', 'posts-single?id='.$myPost->getId().'&page=1');
            }

            Application::$app->flashMessage->error("Votre formulaire contient des erreurs....!");
            Application::$app->flashMessage->display();

        }

        return $this::twig()->render('front-office/postsSingle.html.twig', [
            'commentsForm'  => $commentForm,
            'user'          => $this::$user,
            'me'            => (new Me())->findOne(['id' => 1]),
            'myPost'        => $myPost,
            'method'        => $method,
            'commentByPost' => $commentByPost,
            'numberOfPages' => $numberOfPages,
            'currentPage'   => $currentPage,
            'totalOfComment' => $totalOfComment,
        ]);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function postsList(): string
    {

        (new BackOfficeProtection())->checkForAdminStatus();

        $posts = new Posts();
        $postsList = $posts->all();
        $_token = $this::$easyCSRF->generate('posts_csrf_token');

        return $this::twig()->render('back-office/posts/postsList.html.twig', [
            'postsList'        => $postsList,
            'user'             => $this::$user,
            '_token'           => $_token,
            'me'          => (new Me())->findOne(['id' => 1]),
        ]);
    }

    public function newPosts(): string
    {

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
                $post->setImage(rand(1, 9));
                $post->new();
                Application::$app->flashMessage->success('Nouveau post enregistré avec succès.', 'posts-index');
            }

            Application::$app->flashMessage->error("Votre formulaire contient des erreurs....!");
            Application::$app->flashMessage->display();

        }

        return $this::twig()->render('back-office/posts/postsNew.html.twig', [
            'postsForm'   => $postsForm,
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
    public function showPosts(): string
    {

        (new BackOfficeProtection())->checkForAdminStatus();

        $post = new Posts();
        $myPost = $post->findOne(['id' => filter_input(INPUT_GET, 'id')]);

        $_token = $this::$easyCSRF->generate('comments_csrf_token');

        $totalOfComment = (new Comments())->numberOfModels()[0];
        $perPage = 8;
        $numberOfPages = ceil($totalOfComment/$perPage);

        $currentPage = filter_input(INPUT_GET, 'page');

        if (!isset($currentPage) && !($currentPage > 0) && !($currentPage <= $numberOfPages)){
            $currentPage = 1;
        }

        $commentByPost = (new Comments())->findByIdPaginate(['idPosts' => $myPost->getId()], $currentPage, $perPage);

        return $this::twig()->render('back-office/posts/postsShow.html.twig', [
            'myPost'         => $myPost,
            'user'           => $this::$user,
            'me'             => (new Me())->findOne(['id' => 1]),
            'commentByPost'  => $commentByPost,
            'numberOfPages'  => $numberOfPages,
            'currentPage'    => $currentPage,
            'totalOfComment' => $totalOfComment,
            '_token'         => $_token,
        ]);
    }


    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function editPosts(): string
    {

        (new BackOfficeProtection())->checkForAdminStatus();

        $post = (new Posts())->findOne(['id' => filter_input(INPUT_GET, 'id')]);
        $postsForm = (new PostsType($post, "posts-edit?id=".filter_input(INPUT_GET, 'id')."", "post"))->createForm();

        if (Application::$app->request->isPost(Application::$app->request->getMethod())){
            $data = Application::$app->request->getRequestData();
            $post->loadData($data);
            if ($post->isValid()){
                $post->edit(['id' => $post->getId()]);
                Application::$app->flashMessage->success('Post édité avec succès.', 'posts-index');
            }

            Application::$app->flashMessage->error("Votre formulaire contient des erreurs....!");
            Application::$app->flashMessage->display();

        }

        return $this::twig()->render('back-office/posts/postsEdit.html.twig', [
            'postsForm'   => $postsForm,
            'user'        => $this::$user,
            'request'     => 'edit',
            'me'          => (new Me())->findOne(['id' => 1]),
        ]);

    }

    public function deletePosts(){

        (new BackOfficeProtection())->checkForAdminStatus();

        $post = (new Posts())->findOne(['id' => filter_input(INPUT_GET, 'id')]);

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