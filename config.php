<?php

	$file = file_get_contents('bcainstance');
	
	define('DB_SERVER', 'localhost');

    define('DB_USERNAME', 'root');

    define('DB_PASSWORD', '');

    define('DB_NAME', $file);
    
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
        echo "error";
    }
?>

