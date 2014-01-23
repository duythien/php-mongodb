<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'app.php';
try {
	$currentPage = (isset($_GET['page'])) ? (int) $_GET['page'] : 1; //current page number
         $data = $db->get($currentPage,'posts');
       

        $layout->view('index',array(
            'currentPage'  => $data[0],
            'totalPages'   => $data[1],
            'cursor'       => $data[2],
            'name'		=>	'Duy Thien'

    ));

	
} catch (Exception $e) {
	 echo 'Caught exception: ',  $e->getMessage(), "\n";
}
