<?php

function view($path, $data = null) 
{
	if ( $data ) {
		extract($data);
	}

	$path .= '.view.php';

	include "views/layout.php";
}
/*function view_admin($path,$data=null){
	if ($data ) {
		$currentPage = $data[0];
		$totalPages	 =$data[1];
		$cursor = $data[2];
		extract($data);
	}
	    

	///$cursor =$data;
	$path .= '.view.php';

	include "views/layout.php";

}
*/