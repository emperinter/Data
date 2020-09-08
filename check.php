<?php
include 'connection.php';

session_start();

echo '<html>
<head>
<title>loding...</title>
<style type="text/css">   
*{   
    margin: 0;   
    padding: 0;   
    background-color: #EAEAEA;  
}     
.center-in-center{   
    position: absolute;   
    top: 30%;   
    left: 50%;   
    -webkit-transform: translate(-50%, -50%);   
    -moz-transform: translate(-50%, -50%); 
    -ms-transform: translate(-50%, -50%);   
    -o-transform: translate(-50%, -50%);   
    transform: translate(-50%, -50%);   
}   
</style>
    </head><body>   ';
    
if(isset($_SESSION['username'])){
	$user = $_SESSION['username'];
}else{	
	$user = trim($_POST['loginusername']);
	$_SESSION['username'] = $user;
}

if(isset($_SESSION['password'])){
	$pass = $_SESSION['password'];
}else{
	$pass=  trim(md5($_POST['loginpassword']));
	$_SESSION['password'] = $pass;
}


$sql = "select * from user where username = '$user'";

$result = mysqli_query($conn,$sql);

$data = mysqli_fetch_assoc($result);

echo "<div align='center' class='center-in-center'>";

if($data){

	if($pass == trim($data['password'])){
	echo '<div style="font-size:64px;color:green;"><strong>Welcome ' . trim($data['username']) . '</strong>Logined successfully！</div><br/>';
	echo '<h1>It will go to admin panel after <strong id="timeout" style="color:red;">3</strong>second！</h1>';
	echo '<form action="admin.php" method="POST" id="myForm">';
	echo '<input type="hidden" name="loginedusername" value="' . trim($data['username']) .'">';
	echo '</form>';
	echo '
<script>
	time = 3;
function autoSubmit(){
	document.getElementById("timeout").innerHTML = time;
	time--;
	if(time == 0){
		document.getElementById("myForm").submit();
	}
	
	    //action every second ,showTime()  
    setTimeout("autoSubmit()",1000); 	
}
	autoSubmit();
</script>
';
	exit;
	}else{
	        echo 'password is wrong，Please input again !';
        echo '
                <script>
                       function returnHomepage(){
                        window.location.href = "index.php";
                        }
                returnHomepage();
                </script>
';

	}
}else{
	echo 'No user ! Please Sing Up！';
	echo '
		<script>
	               function singup(){
                        window.location.href = "singup.php";
                        }
	singup();
</script>
';}



echo "</body></html>";
mysqli_close($conn);
?>
