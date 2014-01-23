<?php

require 'app.php';

// Fetch all the posts
$post = $db->getById($_GET['id'],'posts');
if ($post == FALSE) {	
	header('Location: index.php');
	
} else {
	
	$layout->view('single', array(
		'article' => $post
	));
}
