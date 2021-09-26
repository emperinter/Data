<?php

	include 'connection.php';

	session_start();

	if(isset($_SESSION['username']) && ($_SESSION['username'] != NULL)){
		$username=$_SESSION['username'];
	}else{
		$username = trim($_POST['loginusername']);

		//GET 
		if($username == NULL  && $username == ''){
			$username = trim($_POST['username']);
			$_SESSION['username'] =  $username;
		}	
	}

	if(is_null($username)){
		exit;
	}
	
	// 删除POST
	$get_id = trim($_POST['noteid']);

	if($get_id != NULL){
		$sql = "DELETE FROM note WHERE noteid = $get_id";
		mysqli_query($conn,$sql);
	}

	// 插入POST
	$get_post = trim($_POST['post']);

	if($get_post != NULL ){

		$time = date('Y-m-d H:i:s');

		$sql = "insert into note(username,note,date) values ('$username','$get_post','$time')";

		$result = mysqli_query($conn,$sql);

		if(!($result)){
			echo'
				<script>
					alert("Insert Wrong ! Please Try Again !");
				</script>
			';
		}else{
			//
		}
	}else{
	// 	echo'
	// 	<script>
	// 		alert("Please Input Something !");
	// 	</script>
	// ';
	}



?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<!--<div align="center"><a href="index.php">MessageBoard</a></div>-->
		<title>MessageBoard Background</title>

		<link href="index.css" rel="stylesheet">

		<script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.3.1/jquery.slim.min.js"></script>

		<!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- 可选的 Bootstrap 主题文件（一般不用引入） -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

		<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


		<!--markdwwn需要-->
		<script src="https://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
		<script src="js/editor.md-master/editormd.min.js"></script>

		<!--markdwwn需要-->
		<link rel="stylesheet" href="js/editor.md-master/css/editormd.css" />

	</head>

	<body>

		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container">
					<!-- <a href="index.php">HomePage</a> -->
					<span></span>
					<a class="navbar-brand" style="font-size:32px;">Hello,<?php echo $username; ?>!    <span>Wanna Say Something ?</a>
					<div  align="right">
						<form>
							<button type="button" class="btn btn-danger btn-lg" align="right" onClick="exit()">exit</button>
						</form>
					</div>
			</div>
		</nav>
		<hr/>

		<br/>
			
		<div align="center">
			<form action="" method="POST">
				<table border="1" width="95%">
					<tr>
						<?php echo '<input type="hidden" name="username" value="' . $username . '"/>';	?>
						<div id="test-editor">
							<textarea style="display:none;" name="mark">### 关于 Editor.md**Editor.md
** 是一款开源的、可嵌入的 Markdown 在线编辑器（组件），基于 CodeMirror、jQuery 和 Marked 构建。**
> print("hello world !")
</textarea>
		<!-- 第二个隐藏文本域，用来构造生成的HTML代码，方便表单POST提交，这里的name可以任意取，后台接受时以这个name键为准 -->
							<textarea class="editormd-html-textarea" name="post"></textarea>
						</div>
					</tr>
					<tr>
						<input type="submit" class="btn btn-success btn-lg" value="Submit" style="font-size:32px;">
					</tr>
				</table>
			</form>
		</div>

		<hr/>

		<div align="center" style="font-size:32px;color:blue;">Message Left By You !</div>
		<br/>
		<div align="center">
			<div align="center">
				<?php
					$sql = "select * from note where username =  '$username' order by noteid desc";

					$result = mysqli_query($conn, $sql);

				
					if ($result && mysqli_num_rows($result)) {					
						//存在数据则循环将数据显示出来
						echo '<table class="table"  align="center" border="1" width="95%" >';
						echo '<tr><td>noteid</td><td>note</td><td>date</td><td style="color:red;"><strong>delete?</strong></td></tr>'; 
						while ($row = mysqli_fetch_assoc($result)) {
							$id = $row['noteid'];
							echo '<tr>';
							echo '<td style="text-align:center;">' .$row['noteid'] .'</td>';
							echo '<td>' . $row['note'] . '</td>';
							echo "<td style='text-align:center;'>" . date("Y-m-d H:i:s",strtotime($row['date'])) . "</std>";
							echo '
								<td style="text-align:center;">
									<form action="" method="POST">
										<input type="hidden" name="noteid" value="' . $id . '"> 
										<input type="hidden" name="username" value="' . $username . '"> 						
                                        <button type="submit" class="btn  btn-warning" align="right">' . $id . '</button>					
									</form>
								</td>';
							echo '</tr>';
						}
						echo '</table>';

					} else {
						echo '<div align="center" style="font-size:88px;color:red;">No Data ! <br>Wanna Say Something ?
						</div>';
					}
				?>

			</div>
		</div>

        <br/>
        <br/>
        <br/>

		<footer class="footer mt-auto py-3">
			<div class="container" align="center" style="text-decoration:none;font-size:22px;">
				<span class="text-muted">Produced By <a style="text-decoration:none;" href="https://www.emperinter.info">emperinter</a>| <a style="text-decoration:none;" href="https://github.com/emperinter/MessageBoard">Github</a> | <a style="text-decoration:none;" href="mailto:blog@emperinter.info">Email</a></a></span>
			</div>
		</footer>

		<script type="text/javascript">
			$(function() {
				var editor = editormd("test-editor", {
					width  : "95%",
						height : 350,
				path   : "js/editor.md-master/lib/",
				saveHTMLToTextarea : true
				});
			});
		</script>




		<!-- 退出 -->
		<script>
			function exit(){
				<?php
				session_destroy();
				// unset($_SESSION['username']);
				// unset($_SESSION['password']);
				mysqli_close($conn);
				echo 'window.location.href = "index.php"';
				?>
			}
		</script>		
	
		<?php
			$_SESSION['username'] = $username;
			echo '<script>
				function home(){
					window.location.href = "index.php";
					}
				</script>
			';
		?>
		
	</body>
</html>

<?php
	// mysqli_close($conn);
?>
