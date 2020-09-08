<?php

session_start();

include 'connection.php';

$count_sql = 'select count(noteid) as c from note';

$result = mysqli_query($conn, $count_sql);

$data = mysqli_fetch_assoc($result);

//得到总的note数
$count = $data['c'];

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

//每页显示数
$num = 8;

//得到总页数
$total = ceil($count / $num);


if ($page <= 1) {
	$page = 1;
}
if ($page >= $total) {
	$page = $total;
}
$offset = ($page - 1) * $num;

$sql = "select  noteid,username,note,date  from note order by noteid  desc limit $offset , $num";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>MessageBoard</title>

 <!-- Bootstrap core CSS -->
    <link href="BT/docs/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="BT/docs/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="sticky-footer.css" rel="stylesheet">
    <link href="jumbotron.css" rel="stylesheet">

	
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">

	  <!--<a class="navbar-brand" href="https://www.emperinter.cf">Message Board</a>       -->



<div class="navbar-header">
       <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-control="navr">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
       </div>	
<?php

//session_start();

if(isset($_SESSION['username'])){
	echo '
		<div class="navbar-collapse collapse" align="right">
		<a style="font-size:18px;color:green;">Welcome ! ' . $_SESSION['username'] . '</a>
		<form>
			<button type="button" class="btn btn-success" align="right" onClick="admin()">后台</button>
		</form>
		</div>
			';
}else{
	echo '        
		 <div id="navbar" class="navbar-collapse collapse">
          <form class="navbar-form navbar-right" action="check.php" method="POST">
            <div class="form-group">
              <input type="text" id="textfield" class="form-control" placeholder="username" name="loginusername" autofocus="autofocus"  required autofocus>
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password" class="form-control" id="password"   name="loginpassword">
            </div>
            <button type="submit" class="btn btn-success" name="submit" id="submit">登陆</button>
			<button type="button" class="btn btn-success" onClick="singup()">注册</button>
          </form>
        </div><!--/.navbar-collapse -->
		';
	}
?>
        <div id="navbar" class="navbar-collapse collapse">

      </div>
    </nav>

    <!-- Main jumbotron for a primary marketing message or call to action -->
<!--    <div class="jumbotron">-->
         <!-- Begin page content -->

      <div>
        <p align="center" style="font-size:50px;color:blue;">MessageBoard</p>
      </div>	
	  
	  <hr/>
	  
	  
	 

<?php
if ($result && mysqli_num_rows($result)) {
	//存在数据则循环将数据显示出来
	while ($row = mysqli_fetch_assoc($result)) {
	echo '<main role="main" class="container">
		<div class="jumbotron">';
		echo '<p class="lead">' . $row['note'] . '</p><hr/>';
		echo '<strong><table><tr><td>Noteid:' . $row['noteid'] . '</td><td>UserName:' . $row['username'] . '</td><td>Date:'. date("Y-m-d H:i:s",strtotime($row['date'])) . '</td></tr><</table></strong>' ;
		echo '</div></main>';
	}
	echo '<p align="center" style="font-size:22px;"><a href="index.php?page=1">Home page</a>  <a href="index.php?page=' . ($page - 1) . '">Previous Page</a>   <a href="index.php?page=' . ($page + 1) . '">Next Page</a>  <a href="index.php?page=' . $total . '">Last Page</a><br/> The <strong style="color:red;">' . $page . '</strong> Page/Total' . $total . 'Page';
} else {
	echo '<div align="center">No Data ! </div>';
}

?>


<footer class="footer mt-auto py-3">
  <div class="container" align="center" style="text-decoration:none;font-size:22px;">
    <span class="text-muted">Produced By <a style="text-decoration:none;" href="https://www.emperinter.info">emperinter</a>| <a style="text-decoration:none;" href="https://github.com/emperinter/MessageBoard">Github</a> | <a style="text-decoration:none;" href="mailto:blog@emperinter.info">Email</a></a></span>
  </div>
</footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="EU/BT/docs/assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="BT/docs/dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="BT/docs/assets/js/ie10-viewport-bug-workaround.js"></script>	


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="EU/BT/docs/dist/js/vendor/jquery-slim.min.js"><\/script>')</script>
<script src="BT/docs/dist/js/bootstrap.bundle.min.js"></script></body>


    <!--open singup-->
    <script>
        function singup(){
            window.location= "singup.php";
        }
    </script>
    <!--open admin-->
    <script>
        function admin(){
            window.location= "admin.php";
        }
    </script>
    
  </body>
</html>

