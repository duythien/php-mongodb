<?php namespace Blog\Functions;


function connect($config)
{
	try{
		if ( !class_exists('Mongo')){
            echo ("The MongoDB PECL extension has not been installed or enabled");
            return false;
        }
		$connection=  new \Mongo($config['connection_string'],array('username'=>$config['username'],'password'=>$config['password']));
    	$dbname    = $connection->selectDB($config['dbname']);
		return $dbname;
	}catch(Exception $e) {
		return false;
	}
}


/*function get($collection,$dbname)
{
	$table = $dbname->selectCollection($collection);
	//$table = $dbname->$collection;
	$stmt  = $table->find();

	return ($stmt->count() > 0) ? $stmt : false;
}*/
             
function getById($id,$collection,$dbname)
{
	$table = $dbname->selectCollection($collection);
	$cursor  = $table->find(array('_id' => new \MongoId($id)));
	$article = $cursor->getNext();

	if (!$article ){
		return $oh = "Sory article not exits";
	}
	return $article;
}
function get($page,$collection,$dbname)
{

	$currentPage = $page;
	$articlesPerPage = 5;

	//number of article to skip from beginning
	$skip = ($currentPage - 1) * $articlesPerPage; 

	$table = $dbname->selectCollection($collection);

	$cursor = $table->find();
	//total number of articles in database
	$totalArticles = $cursor->count(); 
	//total number of pages to display
	$totalPages = (int) ceil($totalArticles / $articlesPerPage); 

	$cursor->sort(array('saved_at' => -1))->skip($skip)->limit($articlesPerPage);
	//$cursor = iterator_to_array($cursor);
	$data=array($currentPage,$totalPages,$cursor);

	return $data;
}
function commentId($id,$collection,$dbname)
{
	$table = $dbname->selectCollection($collection);
	$cursor  = $table->findOne(array('_id' => new \MongoId($id)));
	$article = $cursor->getNext();

	if (!$article ){
		return $oh = "Sory article not exits";
	}
	return $article;
}
