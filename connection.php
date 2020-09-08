<?php
include 'config.php';

$conn = mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);

// echo mysqli_errno($conn);

if(mysqli_errno($conn)){
	echo mysqli_error($conn);
	exit;
}

mysqli_set_charset($conn,DB_CHARSET);

?>
