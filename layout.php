<?php namespace Blog\Layout;

class Layout
{
	/**
	* @var array
	*/
	public $data;

	public function view($path,$data) 
	{
		if (isset($data)) {
			extract($data);
		}

		$path .= '.view.php';

		include "views/layout.php";
	}

}