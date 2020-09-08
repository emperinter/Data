<?php

session_start();

include 'connection.php';

include 'css.php';

echo '<div align = "center" class="center-in-center">';

if(trim($_POST['password']) != trim($_POST['repassword'])){
	exit('Password not the same，Please Backup！');
}

$username = trim($_POST['username']);

//md5保证密码是不可逆向的；
//md5 make sures that the password can not be conversed ! for security !
$password = trim(md5($_POST['password']));

// $time = time();
$time = date("Y-m-d");

$ip = $_SERVER['REMOTE_ADDR'];

// use for test the connection correct !
// echo $username . '{}' . $password  . '{}' . $time  . '{}' . $ip . '{}' ;

$sql = "insert into user(username,password,createtime,createip) values ('" . $username . " ',' " . $password . " ',' " . $time . " ',' " . $ip ."')";

$result = mysqli_query($conn,$sql);

if($result){
	//store session data
	$_SESSION['username'] = $username;
	$_SESSION['password'] = $password;
	
	echo 'Successful！';
	echo '<script>
		function returnHomepage(){
			window.location.href = "index.php";
			}
		returnHomepage();
		</script>
	';
}else{
	echo 'Something Wrong !!';
	echo $result;
}
echo 'User id is ' . mysqli_insert_id($conn);
mysqli_close($conn);
echo '</div>';

?>
