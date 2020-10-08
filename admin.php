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

	// if(is_null($username)){
	// 	exit;
	// }
	
	// 删除POST
	$get_id = trim($_POST['noteid']);

	// if($username == NULL){
	// 	$username = trim($_GET['username']);
	// 	$_SESSION['username'] =  $username;
	// }

	if($get_id != NULL){
		$sql = "DELETE FROM note WHERE noteid = $get_id";
		mysqli_query($conn,$sql);
	}
	// mysqli_close($conn);

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

		<!-- Bootstrap core CSS -->
		<link href="BT/docs/dist/css/bootstrap.min.css" rel="stylesheet">

		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<link href="BT/docs/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="sticky-footer.css" rel="stylesheet">
		<link href="jumbotron.css" rel="stylesheet">

		<!--<link rel="stylesheet" type="text/css" href="EU/themes/default/easyui.css">-->
		<!-- <link rel="stylesheet" type="text/css" href="EU/themes/icon.css">
		<link rel="stylesheet" type="text/css" href="EU/demo.css">
		<script type="text/javascript" src="EU/jquery.min.js"></script>
		<script type="text/javascript" src="EU/jquery.easyui.min.js"></script> -->

		<!--markdwwn需要-->
		<link rel="stylesheet" href="js/editor.md-master/css/editormd.css" />

	</head>

	<body>

		<!--<nav class="navbar navbar-inverse navbar-fixed-top">-->
		<nav>
			<div class="container">
					<a class="navbar-brand" style="font-size:32px;color:red;"><?php echo $username; ?>'s Admin Panel	</a>
					<div  align="right">
						<form>
							<button type="button" class="navbar-collapse" align="right" onClick="exit()">exit</button>
						</form>
					</div>
			</div>
		</nav>
		<hr/>
		<!--<div align="center" style="font-size:32px;color:blue;">MessageBoardBackground</div>-->
		<br/>
			
		<div align="center">
			<form action="#" method="POST">
				<table border="1" width="95%">
					<tr>
						<?php echo '<input type="hidden" name="username" value="' . $username . '"/>';	?>
						<div id="test-editor">
                    <textarea style="display:none;" name="mark">### 关于 Editor.md
**Editor.md** 是一款开源的、可嵌入的 Markdown 在线编辑器（组件），基于 CodeMirror、jQuery 和 Marked 构建。</textarea>
<!-- 第二个隐藏文本域，用来构造生成的HTML代码，方便表单POST提交，这里的name可以任意取，后台接受时以这个name键为准 -->

                    <textarea class="editormd-html-textarea" name="post"></textarea>
                </div>
					</tr>
					<tr>
						<input type="submit" value="Submit" style="font-size:32px;">
					</tr>
				</table>
			</form>
		</div>

		<div align="center" style="font-size:32px;color:blue;">Message Left By You !</div>
		<br/>
		<div align="center">
			<div align="center">
				<?php
					$sql = "select * from note where username =  '$username' order by noteid desc";

					$result = mysqli_query($conn, $sql);

					// $row = mysqli_fetch_assoc($result);

					if ($result && mysqli_num_rows($result)) {					
						//存在数据则循环将数据显示出来
						echo '<table  align="center" border="1" width="95%" style="text-align:center;">';
						echo '<tr><td>noteid</td><td>note</td><td>date</td><td>delete</td></tr>'; 
						// while ($row = mysqli_fetch_assoc($result)) {
						while ($row = mysqli_fetch_assoc($result)) {
							$id = $row['noteid'];
							echo '<tr>';
							echo '<td>' .$row['noteid'] .'</td>';
							echo '<td>' . $row['note'] . '</td>';
							echo "<td>" . date("Y-m-d H:i:s",strtotime($row['date'])) . "</td>";
							// echo '<td><a href="edit.php?id=' . $row['noteid'] . '">编辑</a></td>';
							//	echo '<td><a href="delete.php?id='  . $row['noteid'] . '">删除</a></td>';
							echo '
								<td>
									<form action="#" method="POST">
										<input type="hidden" name="noteid" value="' . $id . '"> 
										<input type="hidden" name="username" value="' . $username . '"> 						
                                        <button type="submit" class="btn btn-success" align="right">' . $id . '</button>					
									</form>
								</td>';
							echo '</tr>';
						}
						echo '</table>';

					} else {
						echo 'No Data';
					}
				?>

			</div>
		</div>


		<!--   <footer class="footer" style="font-size:18px">-->
			<!--<p class="text-muted" align="center">Produced By<a style="text-decoration:none;" href="https://www.emperinter.info">emperinter</a>| <a style="text-decoration:none;" href="https://github.com/emperinter/MessageBoard">Github</a></p>-->
		<!--   </footer>-->

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


		<!--markdwwn需要-->
		<script src="https://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
		<script src="js/editor.md-master//editormd.min.js"></script>


		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="BT/docs/assets/js/vendor/jquery.min.js"><\/script>')</script>
		<script src="BT/docs/dist/js/bootstrap.min.js"></script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<script src="BT/docs/assets/js/ie10-viewport-bug-workaround.js"></script>		

		<!-- 退出 -->
		<script>
			function exit(){
				<?php
				session_destroy();
				// unset($_SESSION['username']);
				// unset($_SESSION['password']);
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

	
	// $get_id = trim($_GET['noteid']);
	// $_SESSION['username'] =  trim($_GET['username']);

	// if($get_id != NULL){
	// 	$sql = "DELETE FROM note WHERE noteid = $get_id";

	// 	mysqli_query($conn,$sql);
	// }
	// mysqli_close($conn);

?>
