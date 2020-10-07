<?php
	include 'connection.php';

	include 'css.php';

	$user = trim($_POST['username']);

	$post = trim($_POST['post']);

	$time = date('Y-m-d H:i:s');


	$sql = "insert into note(username,note,date) values ('$user','$post','$time')";


	$result = mysqli_query($conn,$sql);


	echo "<div align='center' class='center-in-center'>";

	if($result){
		
		echo '	
		<div><br/><h1>It will return admin panel after <strong id="timeout" style="color:red;">3</strong>second！</h1>
			<script>
				time = 3;
				function autoSubmit(){
					document.getElementById("timeout").innerHTML = time;
					time--;
					if(time == 0){
						history.back();
					}
					//每秒执行一次,showTime()
					setTimeout("autoSubmit()",1000);
				}
				autoSubmit();
			</script>
		</div>
	';
	}else{
		echo '<div style="font-size:64px;color:red">Insert unsuccesful！</div>';
	}

	echo "</div>";

	mysqli_close($conn);

?>
