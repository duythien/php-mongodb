<?php

require 'app.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {

	$id = $_POST['article_id'];
	$comment = array(
              	'name' => $_POST['fName'], 
                'email' => $_POST['fEmail'],
                'comment' => $_POST['fComment'],
                'posted_at' => new MongoDate()
	);
	$status = $db->commentId($id,'posts',$comment);

	if ($status == TRUE) {
		header('Location: single.php?id='.$id);
	}
		

}
