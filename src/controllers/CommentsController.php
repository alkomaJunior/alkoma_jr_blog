<?php


namespace app\src\controllers;


use app\config\Application;
use app\config\Controller;
use app\src\models\Comments;
use EasyCSRF\Exceptions\InvalidCsrfTokenException;

class CommentsController extends Controller
{
    public function deleteComments(){

        $comment = (new Comments())->findOne(['id' => (int)$_GET['id']]);

        if (Application::$app->request->isPost(Application::$app->request->getMethod())){

            $data = Application::$app->request->getRequestData();

            if ($data['_method'] === "DELETE"){

                try {
                    $this::$easyCSRF->check('comments_csrf_token', $data['_token'], "", true);
                }
                catch (InvalidCsrfTokenException $e){
                    Application::$app->flashMessage->error($e->getMessage(), 'posts-index');
                }

                $comment->remove(['id' => $comment->getId()]);
                Application::$app->flashMessage->success('Commentaire supprimé avec succès.', 'posts-show?id='.$data['_postId']);
            }
        }
    }

}