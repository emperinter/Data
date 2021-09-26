<?php
    define('DB_HOST','localhost');

    define('DB_USER','notebook');

    define('DB_PWD','notebook');

    define('DB_NAME','notebook');

    define('DB_CHARSET','utf8');

	$conn = mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);

	// echo mysqli_errno($conn);

	if(mysqli_errno($conn)){
		echo mysqli_error($conn);
		exit;
	}

	mysqli_set_charset($conn,DB_CHARSET);

?>
