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

        <title>singup</title>

        <style>
            .form-control {
                display: block;
                width: 30%;
                height: 34px;
                padding: 6px 12px;
                font-size: 14px;
                line-height: 1.42857143;
                color: #555;
                background-color: #fff;
                background-image: none;
                border: 1px solid #ccc;
                border-radius: 4px;
                margin-top:5px;
                -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
                box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
                -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
                -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
                transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
            }
            .btn-block {
                margin-top:5px;
                display: block;
                width: 32%;
            }
            .btn {
                display: inline-block;
                padding: 6px 12px;
                margin-bottom: 0;
                font-size: 14px;
                font-weight: 400;
                line-height: 1.42857143;
                text-align: center;
                white-space: nowrap;
                vertical-align: middle;
                -ms-touch-action: manipulation;
                touch-action: manipulation;
                cursor: pointer;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                background-image: none;
                background-color: #b9d5d2;
                border: 1px solid transparent;
                border-top-color: transparent;
                border-right-color: transparent;
                border-bottom-color: transparent;
                border-left-color: transparent;
                border-radius: 4px;
            }

            .btn-group-lg > .btn, .btn-lg {
                padding: 10px 16px;
                font-size: 18px;
                line-height: 1.3333333;
                border-radius: 6px;
            }
        </style>

    </head>

    <body>
         <div>
            <p align="center" style="font-size:50px;color:blue;"><a href="index.php">MessageBoard</a></p>
        </div>	
        
        <div style="margin-top:100px"  align="center">
            <h2 style="font-size:32px;font-color:dark" align="center">Sign Up</h2>

            <form  style="margin-top:100px" action = '#' method = 'post'>
                <input type="text" id="inputEmail" class="form-control" placeholder="User Name" name="username" required autofocus>
                <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required>    
                <input type="password" id="inputPassword" class="form-control" placeholder="Repeat Password" name="repassword" required>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
            </form>

        </div> <!-- /container -->
    </body>
</html>

<?php

    $username = trim($_POST['username']);
    
    if($username != NULL){
 
        include 'connection.php';
        
        $sql = "select * from user where username = '$username'";

        $result = mysqli_query($conn,$sql);
        
        $row = mysqli_fetch_assoc($result);
    
        if($row['username'] != NULL && $username != NULL){
            echo'
                <script>
                    alert("Your Name ' . $username .' has been Taken！ Please try another!");
                </script>
            ';
        }else{
            if(trim($_POST['password']) != trim($_POST['repassword'])){
                echo'
                <script>
                    alert("Your PasseWord ndoesn\'t,Please Try Again!");
                </script>
                ';
            }else{
                // $username = trim($_POST['username']);
        
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
                    session_start();
                    //store session data                
                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $password;

                    echo '
                        <script>                    
                            function returnHomepage(){
                                window.location.href = "index.php";
                            }
                            returnHomepage();
                        </script>
                    ';
                }else{
                    echo'
                        <script>
                        alert("Something Wrong!,Please Try Again!");
                        </script>
                    ';
                }
                
                mysqli_close($conn);
            }    
        }
    }
   
?>
