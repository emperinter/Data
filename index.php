<?php

    // session_start();

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

        <link href="index.css" rel="stylesheet">


        <script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.3.1/jquery.slim.min.js"></script>

        <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- 可选的 Bootstrap 主题文件（一般不用引入） -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    </head>

    <body>

    <!-- 头部导航栏 -->
        <nav class="navbar navbar-inverse navbar-expand-lg ">
            <div class="container">
                <a class="navbar-brand" href="https://www.emperinter.cf">Message Board</a>      

                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-control="navr">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>	
                <?php
                    session_start();
                    if(isset($_SESSION['username']) && ($_SESSION['username']) != NULL){
                        echo '
                            <div id="navbar" class="navbar-collapse collapse">
                                <a class="navbar-brand"> <span>|</span> Welcome ! ' . $_SESSION['username'] . '</a>
                                    <form class="navbar-form navbar-right" id="ReturnAdminAtHomePage" action="admin.php" method="POST">
                                        <input type="hidden" name="loginusername" value="' . trim($_SESSION['username']) . '"> 
                                        <button type="submit" class="btn btn-success">后台</button>
                                    </form>
                            </div>				
                        ';
                    }else{
                        echo '        
                            <div id="navbar" class="navbar-collapse collapse">
                                <form class="navbar-form navbar-right" action="#" method="POST">
                                    <div class="form-group">
                                        <input type="text" id="textfield" class="form-control" placeholder="username" name="loginusername" autofocus="autofocus"  required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" placeholder="Password" class="form-control" id="password"   name="loginpassword">
                                    </div>
                                    <button type="submit" class="btn btn-success" name="submit" id="submit">登陆</button>
                                    <button type="button" class="btn btn-success" onClick="window.location.href=' . '\'singup.php\'' . '">注册</button>
                                </form>
                            </div>
                        ';
                    }
                ?>
                <div id="navbar" class="navbar-collapse collapse"></div>
            </div>
        </nav>


            <div>
                <p align="center" style="font-size:50px;color:blue;">MessageBoard</p>
            </div>	

        <hr/>

        <?php
            if ($result && mysqli_num_rows($result)) {
                //存在数据则循环将数据显示出来
                //每一个ID的数据
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<main role="main" class="container">
                    <div class="jumbotron">';
                    echo '<p class="lead">' . $row['note'] . '</p><hr/>';
                    echo '<strong>
                            <table border="0" width="100%" padding="10" align="center">
                                <tr>
                                    <td>Noteid: ' . $row['noteid'] . '</td><span></span>
                                    <td>UserName: ' . $row['username'] . '</td><span></span>
                                    <td>Date: '. date("Y-m-d H:i:s",strtotime($row['date'])) . '</td>
                                </tr>
                            </table>
                        </strong>' ;
                    echo '</div></main>';
                }
                //翻页
                echo '
                    <hr/> 
                    <p align="center" style="font-size:22px;">
                    Page:<strong style="color:red;">' . $page . '</strong> / Total: ' . $total . ' Pages
                    </p>
                    <p align="center" style="font-size:22px;">
                        <button  class="btn btn-md btn-primary" onClick="window.location.href=\'index.php?page=1\'">Home Page</button>

                        <button  class="btn btn-md btn-primary" onClick="window.location.href=\'index.php?page=\''. ($page - 1) . '"> Previous Page </button>  

                        <button  class="btn btn-md btn-primary" onClick="window.location.href=\'index.php?page=\'' . ($page + 1) . '"> Next Page</button>
                        
                        <button  class="btn btn-md btn-primary" onClick="window.location.href=\'index.php?page=\'' . $total . '">Last Page</button>
                    </p>';
            } else {
                echo '<div align="center" style="font-size:88px;color:red;">No Data ! </div>';
            }
        ?>



        <br/>
        <br/>
        <br/>

        <footer class="footer mt-auto py-3">
            <div class="container" align="center" style="text-decoration:none;font-size:22px;">
                <span class="text-muted">Produced By <a style="text-decoration:none;" href="https://www.emperinter.info">emperinter</a>| <a style="text-decoration:none;" href="https://github.com/emperinter/MessageBoard">Github</a> | <a style="text-decoration:none;" href="mailto:blog@emperinter.info">Email</a></a></span>
            </div>
        </footer>


    </body>   
</html>



<?php
    $user = trim($_POST['loginusername']);
    $pass=  trim(md5($_POST['loginpassword']));


    echo'
        <script>
            alert('.$user.$pass.');
        </script>
    ';
    
    if($user != NULL && $pass != NULL){
        $sql = "select * from user where username = '$user'";

        $result = mysqli_query($conn,$sql);

        $data = mysqli_fetch_assoc($result);

        if($data){
            if($pass == trim($data['password'])){
                echo '
                    <form id="Myform" action="admin.php" method="POST" >
                        <input type="hidden" name="loginusername" value="' . trim($data['username']) . '"> 
                    </form>						
                    <script>
                        time = 1;
                        function autoSubmit(){
                            time--;
                            if(time == 0){
                            document.getElementById("Myform").submit();
                        }

                        //action every second ,showTime()  
                        setTimeout("autoSubmit()",1000); 	
                        }
                        autoSubmit();
                    </script>
                ';
                $_SESSION['username'] = $user;
                $_SESSION['password'] = $pass;
                exit;
            }else{
                echo '	
                    <script>
                        alert("Your Password doesn`t Match ! Please Try again !");						
                        time = 3;
                        function autoSubmit(){
                            time--;
                            setTimeout("autoSubmit()",1000); 	
                        }
                        autoSubmit();	
                        window.location.href = "index.php"; 	
                    </script>
                ';
                session_destroy();
            }
        }else{
            echo '	
            <script>
                alert("No User! Please Try again ! Or you can sign up !");						
                time = 3;
                function autoSubmit(){
                    time--;
                    setTimeout("autoSubmit()",1000); 	
                }
                autoSubmit();	
                window.location.href = "index.php"; 	
            </script>
            ';
        }
    }else{

        // echo '	
        // <script>
        //     alert("$user = NULL Or $pass = NULL");						
        // </script>
        // ';
    }
	mysqli_close($conn);
?>

