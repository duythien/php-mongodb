<?php
include 'config.php';
include 'layout.php';
include 'functions.php';

use Blog\Functions;

// Connect to the db
$conn = Functions\connect($config);
if ( !$conn ) die('Problem connecting to the database see file config.php.');
