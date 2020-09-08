<?php
include 'connection.php';

$id = trim($_POST['noteid']);


$sql = "DELETE FROM note WHERE noteid = $id";

mysqli_query($conn,$sql);

//$data = mysqli_fetch_assoc($result);

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

	echo '<div class="center-in-center"><div style="font-size:64px;color:green;">Deleted successful！</div><br/>';
	echo '	<div><br/><h1>It will back to admin panel after <strong id="timeout" style="color:red;">3</strong>second ！</h1>
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
	';

echo "</div></body></html>";

?>

<?php
mysqli_close($conn);
?>
