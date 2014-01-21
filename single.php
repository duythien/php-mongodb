<?php

require 'app.php';
use Blog\Functions;
// Fetch all the posts
$post = Functions\getById($_GET['id'],'posts',$conn);
if ( $post ) {	
	view('single', array(
		'article' => $post
	));
} else {
	//header('location:/');
}
