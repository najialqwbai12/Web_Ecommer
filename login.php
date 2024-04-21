<?php 
        ob_start();
        session_start();
       
        $pageTitle='Login';
        if(isset($_SESSION['user'])){
        header('Location: index.php');
        exit();
            }
        include "inti.php";
         //check IF user Coming From HTTP Post Request 
         if($_SERVER['REQUEST_METHOD']== 'POST'){
            if(isset($_POST['login'])){
    $user=$_POST['username'];
    $pass=$_POST['password'];
 
    $hashPass=sha1($pass);
    
    $stmt = $conn->prepare("SELECT 
                                UserID,UserName,`Password`
                            FROM 
                                users 
                            WHERE
                                UserName = ? 
                            AND  `Password`=? 
                        
                            ");

        $stmt->execute(array($user,$hashPass));
        $get=$stmt->fetch();
        $count=$stmt->rowCount();
        if($count>0){
            $_SESSION['user']=$user;
            $_SESSION['uid']=$get['UserID'];
       
            header('Location: index.php');
            exit();
        
            }
        }else{

            
            $formErrors=array();

            $username  =$_POST['Username'];
            $password1 =$_POST['password'];
            $password2 =$_POST['password_again'];
            $email     =$_POST['email'];

            if(isset($username)){
                $filterdUser=filter_var($username,FILTER_SANITIZE_STRING);
                if(strlen($filterdUser)< 4){ 
                    $formErrors[]='Username Must Be Larger Then 4 Charcters';
                }
            }
            if(isset($password1) && isset($password2)){
                if(empty ($password1)){
                    $formErrors[]='Sorry Password Is Not Empty';
                }
                
                if(sha1($password1) !== sha1($password2)){
                    $formErrors[]='Sorry Password Is Not Match';
                }
                }
            if(isset($email)){
                $filterdEmail=filter_var($email,FILTER_SANITIZE_EMAIL);
                if(filter_var($filterdEmail,FILTER_SANITIZE_EMAIL)!= true){ 
                    $formErrors[]='Theis Email Not your Valid';
                }
            }
                if(empty($formErrors)){
                    //Insert Info User database
                            
                    $check=checkItem("UserName","users",$username);
                    if($check == 1){
                        //echo "Sorry This User Is Exist";
                        $formErrors[]='Theis User Is Exit';                    
                    }else{
                        $stmt = $conn->prepare("INSERT INTO
                        users (UserName,Password,Email,RegStatus,Date)
                        VALUES (?,?,?,0,now())");
                        $stmt->execute(array($username,sha1($password1),$email));
                        $count=$stmt->rowCount();
                    $successMsg= 'Congrats Tou Are Now Registard User ';
                        
                
                    
                }
            }
                            
        }
            
        }
        ?>
        <div class="container login-page">
            <h1 class="text-center"> 
                    <span class="selected" data-class="login">Login</span> |<span data-class="signup"> Signup</span>
            <h1>
                <!-- Start Login Page -->
            <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="input-container">
                <input  class="form-control" 
                    type="text" name="username"
                    autocomplete="off"
                    placeholder="Type your username" required/>
                </div>
                <div class="input-container">
                <input class="form-control" 
                    type="password" name="password" 
                    autocomplete="new-password" 
                    placeholder="Type your password" required/>
                </div>
                <input class="btn btn-primary btn-block" type="submit" name="login" value="Login" />
            </form>
                    <!-- End Login Page -->
                    <!-- Start Signip  Page -->
            <form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="input-container">
                <input 
                    pattern=".{4,}"
                    title="Username Must Be large 4 Char"
                    class="form-control" 
                    type="text" name="Username"
                    autocomplete="off"
                    placeholder="Type your username" required/>
                </div>
                <div class="input-container">
                <input
                    minlength="4"
                    class="form-control" 
                    type="password" name="password" 
                    autocomplete="new-password" 
                    placeholder="Type your a Complex password" required/>
                </div>
                <div class="input-container">
                <input 
                    class="form-control" 
                    minlength="4"
                    type="password" name="password_again" 
                    autocomplete="new-password" 
                    placeholder="Type a password again" required/>
                </div>
                <input class="form-control" 
                    type="email" name="email" 
                    placeholder="Type your Valid email"/>
                <input class="btn btn-success btn-block" type="submit" name="signup" value="Signup" />
            </form>
            <!-- Start Signup Page -->
            <div class="the-errors text-center">
                <div class="msg">
            <?php
                if(!empty($formErrors)){
                    foreach($formErrors as $error){
                        echo $error .'<br>';
                    }
                }
                if(isset($successMsg)){
                    echo '<div class="error success">'.$successMsg.'</div>';
                }
            ?>
                </div>
            </div>
        </div>
        <?php
        include $tpl."footer.php";
        ob_end_flush();