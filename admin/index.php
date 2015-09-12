<?php
require_once 'auth.php';
require_once '../app.php';
require_once '../vendor/markdown/Markdown.inc.php';

use Michelf\MarkdownExtra,
    Michelf\Markdown;

$url_action = (empty($_REQUEST['action'])) ? 'logIn' : $_REQUEST['action'];

if (isset($url_action)) {
    $action = new Auth;
    if (is_callable(array($action,$url_action))) {
        call_user_func(array($action,$url_action));
    } else {
        echo 'Function does not exist, request terminated';
    }
}

if (is_array($_SESSION) &&$_SESSION['username'] ==UserAuth) {
     $data = array();
     $status = (empty($_GET['status'])) ? 'dashboard':$_GET['status'];

    switch ($status) {
        case 'create':

            if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
                $article               = array();
                $article['title']      = $_POST['title'];
                $article['html']    = Markdown::defaultTransform($_POST['content']);
				$article['content']    =$_POST['content'];

                $article['saved_at'] = new MongoDate();

                if ( empty($article['title']) || empty($article['content']) ) {
                    $data['status'] = 'Please fill out both inputs.';
                }else {
                    // then create a new row in the table
                    $db->create('posts',$article);
                    $data['status'] = 'Row has successfully been inserted.';
                }
            }
            $layout->view('admin/create', $data);
            break;
        case 'edit':
            $id   = $_REQUEST['id'];
            $data['status'] =null;

            if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {

                $article               = array();
                $article['title']      = $_POST['title'];
                $article['html']    = Markdown::defaultTransform($_POST['content']);
                $article['content']    =$_POST['content'];
                $article['saved_at'] = new MongoDate();

                if ( empty($article['title']) || empty($article['content']) ) {
                    $data['status'] = 'Please fill out both inputs.';
                }else {
                    // then create a new row in the table
                    $db->update($id,'posts',$article);
                    $data['status'] = 'Row has successfully been update.';
                }
            }
           $layout->view('admin/edit',array(
                'article' => $db->getById($id,'posts'),
                'status'  => $data['status']
            ));
            break;
        case 'delete':
            $id = $_GET['id'];
            $status = $db->delete($id,'posts');
            if ($status ==TRUE ) {
                header("Location:index");
            }
            break;
        default:
            $currentPage = (isset($_GET['page'])) ? (int) $_GET['page'] : 1; //current page number
            $data = $db->get($currentPage,'posts');


            $layout->view('admin/dashboard',array(
                'currentPage'  => $data[0],
                'totalPages'   => $data[1],
                'cursor'       => $data[2],

            ));
        break;
    }
}
