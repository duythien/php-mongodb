<?php

require 'app.php';
use Blog\Functions;

$id = $_POST['article_id'];
$postCollection = $conn->posts;
$post = $postCollection->findOne(array('_id' => new MongoId($id)));

if (isset($post['comments'])) {
	$comments = $post['comments'];
}else{
	$comments = array();
}

$comment = array(
                  	'name' => $_POST['fName'], 
                    'email' => $_POST['fEmail'],
                    'comment' => $_POST['fComment'],
                    'posted_at' => new MongoDate()
                );
                
array_push($comments, $comment);

$postCollection->update(
						array('_id' => new MongoId($id)), 
						array('$set' => array('comments' => $comments)));
header('Location: single.php?id='.$id);