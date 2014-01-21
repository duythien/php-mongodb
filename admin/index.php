<?php
require_once 'auth.php';

require '../app.php';
use \Michelf\MarkdownExtra,
    \Michelf\Markdown;
    require_once '../vendor/markdown/Markdown.inc.php';


$url_action = (empty($_REQUEST['action'])) ? 'logIn' : $_REQUEST['action'];

if (isset($url_action)) {
    if (is_callable($url_action)) {
        call_user_func($url_action);
    } else {
        echo 'Function does not exist, request terminated';
    }
}

if (is_array($_SESSION) &&$_SESSION['username'] ==UserAuth) {
     $data = array();

    if (isset($_GET['status'])&& $_GET['status']=='create') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $article               = array();
            $article['title']      = $_POST['title'];
            $article['content']    = Markdown::defaultTransform($_POST['content']);
        
            $article['saved_at'] = new MongoDate();
            
            if ( empty($article['title']) || empty($article['content']) ) {
                $data['status'] = 'Please fill out both inputs.';
            }else {
                // then create a new row in the table
                $conn->posts->insert($article);
                $data['status'] = 'Row has successfully been inserted.';
            }
        }
        view('admin/create', $data);
    }elseif(isset($_GET['status'])&& $_GET['status']=='edit'){
        $id   = $_REQUEST['id'];
        $data['status'] =null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $article               = array();
            $article['title']      = $_POST['title'];
            $article['content']    = Markdown::defaultTransform($_POST['content']);
            $article['saved_at'] = new MongoDate();
            
            if ( empty($article['title']) || empty($article['content']) ) {
                $data['status'] = 'Please fill out both inputs.';
            }else {
                // then create a new row in the table
                $conn->posts->update(array('_id' => new MongoId($id)), $article);
                $data['status'] = 'Row has successfully been update.';
            }
        }
        //var_dump(Blog\Functions\getById($id,'posts',$conn));
        
        view('admin/edit',array(
            'article' => Blog\Functions\getById($id,'posts',$conn),
            'status'  => $data['status']
        ));

    }
    else{
        $currentPage = (isset($_GET['page'])) ? (int) $_GET['page'] : 1; //current page number
        $data = Blog\Functions\get($currentPage,'posts',$conn);
       

        view('admin/dashboard',array(
            'currentPage'  => $data[0],
            'totalPages'   => $data[1],
            'cursor'       => $data[2],

        ));

    }   
}
