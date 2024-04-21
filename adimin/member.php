<?php
/*
==========================
== Mange Member Page
==  You Can Add | Edit | Delete from 
====================
*/

        session_start();
        $pageTitle='Members';
        if(isset($_SESSION['Username'])){
            include "inti.php";
        $do = isset($_GET['do'])?$_GET['do']:"manege";
        if($do == 'manege'){  
        $query='';
        if(isset($_GET['page'])&& $_GET['page']=='pending'){
            $query= 'AND RegStatus=0';
        }
        $stmt=$conn->prepare("SELECT * FROM users WHERE GroupID !=1 $query ORDER BY UserID DESC");
        $stmt->execute();
        $rows=$stmt->fetchAll();
        if(! empty($rows)){
    
    ?>


            <h1 class="text-center" >Manege Member</h1>
            <div class="container">
                <div class="table-responsive">
                    <table class="main-table text-center table table-bordered">
                <tr>
                    <td>#ID</td>
                    <td>Username</td>
                    <td>Email</td>
                    <td>Full Name</td>
                    <td>Regestar Date</td>
                    <td>Control</td>
                </tr>
                <?php 
                foreach($rows as $row){
                    echo "<tr>";
                        echo "<td>". $row['UserID']."</td>";
                        echo "<td>". $row['UserName']."</td>";
                        echo "<td>". $row['Email']."</td>";
                        echo "<td>". $row['FullName']."</td>";
                        echo "<td>".$row['Date'] ."</td>";
                            echo "<td>
                            <a href='member.php?do=Edit&userid=".$row['UserID']."' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                            <a href='member.php?do=Delete&userid=".$row['UserID']."' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
                            if($row['RegStatus']==0){
                        echo    "<a href='member.php?do=Activate&userid=".$row['UserID']."' class='btn btn-info activate'><i class='fa fa-check'></i>Activate</a>";

                            }
                            echo" </td>";
                    echo "</tr>";
                }
                ?>
                </tr>
            </table>
        </div>
            <a href="member.php?do=Add"
                class="btn btn-primary">
                <i class="fa fa-plus"></i>New Member</a>
            </div>

        <?php }else{
            echo "<div class='container'>";
                echo '<div class="nice-message">There\'s No Record To Show</div>';
                echo '<a href="member.php?do=Add"
                class="btn btn-primary">
                <i class="fa fa-plus"></i> Add New Member</a>';
            echo "</div>"; 
                }
        }
        elseif($do=="Add"){ ?>

            <h1 class="text-center" >Add New Member</h1>
                        <div class="container text-center">
                            <form class="form-horizontal" action="?do=Insert" method="POST">
                                <!-- Start UserName Filed-->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-lable">Username</label>
                                    <div class="col-sm-10 col-md-6">
                                        <input type="text" name="username" class="form-control" autocomplete="off"  required="required" placeholder="User To Login Into Shop"/>
                                    </div>
                                </div>
                                <!-- End UserName Filed-->
                                    <!-- Start Password Filed-->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-lable">Password</label>
                                    <div class="col-sm-10 col-md-6">
                                        <input type="password" name="password" class="password form-control" autocomplete="new-password" required="required" placeholder="Password Must Hard * Complex"/>
                                       <i class="show-pass fa fa-eye fa-2x"></i>
                                    </div>
                                </div>
                            <!-- End Password Filed-->
                                <!-- Start Email Filed-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-lable">Email</label>
                                <div class="col-sm-10 col-md-6">
                                    <input type="email" name="email" class="form-control" required="required" placeholder="Email Must Be Valid"/>
                                </div>
                            </div>
                            <!-- End Email Filed-->
                            <!-- Start FullName Filed-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-lable">Full Name</label>
                                <div class="col-sm-10 col-md-6">
                                    <input type="text" name="full" class="form-control" required="required" placeholder="Full Name Appear In Your Profile Page "/>
                                </div>
                            </div>
                            <!-- End FullName Filed-->
                                <!-- Start FullName Filed-->
                            <div class="form-group form-group-lg">
                                <div class="col-sm-offest-2 col-sm-10">
                                    <input type="submit" value="Add Member" class="btn btn-primary btn-lg" />
                                </div>
                            </div>
                            <!-- End FullName Filed-->
                        </form>
                    </div>
        <?php 
                }
        elseif($do=='Insert'){
                // insert to database

                        if($_SERVER['REQUEST_METHOD'] == 'POST'){
                        echo "<h1 class='text-center'>Update Member </h1>";
                        echo "<div class='container'>";

                            $user=$_POST['username'];
                            $pass=$_POST['password'];
                            $email=$_POST['email'];
                            $name=$_POST['full'];
                            
                            $hashPass=sha1($_POST['password']);
                            $formErroe=array();
                            if(strlen($user) < 4){
                                $formErroe[]='User Cant Be Lass thin <strong>4 Cherctres</strong>';
                            }
                            if(strlen($user) > 20){
                                $formErroe[]='User Cant Be Lass thin <strong>20 Cherctres</strong>';
                            }
                            if(empty($user)){
                                $formErroe[]='User Cant Be Empty';
                            }
                            if(empty($pass)){
                                $formErroe[]='Password Cant Be Empty';
                            }
                            if(empty($name)){
                                $formErroe[]='Full Name Cant Be Empty';
                            }
                            if(empty($email)){
                                $formErroe[]='Email Cant Be Empty';
                            }
                            foreach($formErroe as $error){
                                echo  '<div class="alert alert-danger">'.$error.'</div>';
                            }
            
            
                            if(empty($formErroe)){
                                //Insert Info User database
                                        
                                $check=checkItem("UserName","users",$user);
                                if($check == 1){
                                    //echo "Sorry This User Is Exist";
                                    $theMsg= "<div class='alert alert-danger>Sorry This User Is Exist Filed</div>";
                                    Rediract($theMsg,'back',2);
                                }else{
                                    $stmt = $conn->prepare("INSERT INTO
                                    users (UserName,Password,Email,FullName,RegStatus,Date)
                                    VALUES (?,?,?,?,1,now())");
                                    $stmt->execute(array($user,$hashPass,$email,$name));
                                    $count=$stmt->rowCount();
                                $theMsg= '<div class="alert alert-success">'.$stmt->rowCount().'Record Inserted'."</div>";
                                    
                                Rediract($theMsg,'back',5);
                                            }
                                        }
                                        
                                        } 
                                        else{
                                            echo '<div class="container">';
                                            $errorMsg= '<div class="alert alert-danger">sorry You cant Broraser this Page</div>';
                                            Rediract($errorMsg); 
                                            echo "</div>";
                                        }

                    echo "</div>"; 
                
            }
        elseif($do == 'Edit'){ // Edit page  from database

        
            $userid=isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
                
            $stmt = $conn->prepare("SELECT * FROM users WHERE UserID=? LIMIT 1");
            $stmt->execute(array($userid));
            $row=$stmt->fetch();
            $count=$stmt->rowCount();
            if($stmt->rowCount()>0){  ?>
                            
                    <h1 class="text-center" >Edit Member</h1>
                    <div class="container text-center">
                        <form class="form-horizontal" action="?do=update" method="POST">
                             <input type="hidden" name="userid" class="form-control" value="<?php echo $userid ?>"  />
                            <!-- Start UserName Filed-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-lable">Username</label>
                                <div class="col-sm-10 col-md-4">
                                    <input type="text" name="username" class="form-control" value="<?php echo $row['UserName'] ?>" autocomplete="off"  required="required"/>
                                </div>
                            </div>
                            <!-- End UserName Filed-->
                                <!-- Start Password Filed-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-lable">Password</label>
                                <div class="col-sm-10 col-md-4">
                                    <input type="hidden" name="OldPassword" value="<?php echo $row['Password'] ?>"/>
                                    <input type="password" name="NewPassword" class="form-control" autocomplete="new-password" placeholder="Leave Blank If You Do Want Chaneg"/>
                                </div>
                            </div>
                        <!-- End Password Filed-->
                            <!-- Start Email Filed-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-lable">Email</label>
                                <div class="col-sm-10 col-md-4">
                                    <input type="email" name="email"  value="<?php echo $row['Email'] ?>" class="form-control" required="required"/>
                                </div>
                            </div>
                            <!-- End Email Filed-->
                            <!-- Start FullName Filed-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-lable">Full Name</label>
                                <div class="col-sm-10 col-md-4">
                                    <input type="text" name="full"  value="<?php echo $row['FullName'] ?>" class="form-control" required="required"/>
                                </div>
                            </div>
                            <!-- End FullName Filed-->
                                <!-- Start FullName Filed-->
                            <div class="form-group form-group-lg">
                                <div class="col-sm-offest-2 col-sm-10">
                                    <input type="submit" value="Save" class="btn btn-primary btn-lg" />
                                </div>
                            </div>
                            <!-- End FullName Filed-->
                        </form>
                    </div>


  <?php 
            }
            else {
                    echo '<div class="container">';
                    $theMsg= '<div class="alert alert-danger">! Not ID This Is The Form</div>';
                    Rediract($theMsg,4);
                    echo "</div>";
            }
  }
    elseif($do == 'update') {

          // Update From DataBase
              echo "<h1 class='text-center'>Update Member </h1>";
                echo "<div class='container'>";
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                 
                    $id=$_POST['userid'];
                    $user=$_POST['username'];
                    $email=$_POST['email'];
                    $name=$_POST['full'];

                       $pass= empty($_POST['NewPassword']) ?  $pass=$_POST['OldPassword'] :   $pass=sha1($_POST['NewPassword']);        
                
                      $formErroe=array();
                    if(strlen($user) < 4){
                        $formErroe[]='User Cant Be Lass thin <strong>4 Cherctres</strong>';
                    }
                    if(strlen($user) > 20){
                        $formErroe[]='User Cant Be Lass thin <strong>20 Cherctres</strong>';
                    }
                    if(empty($user)){
                        $formErroe[]='User Cant Be Empty';
                    } if(empty($name)){
                        $formErroe[]='Full Name Cant Be Empty';
                    }
                     if(empty($email)){
                        $formErroe[]='Email Cant Be Empty';
                    }
                    foreach($formErroe as $error){
                        echo  '<div class="alert alert-danger">'.$error.'</div>';
                    }
    
      
                    if(empty($formErroe)){
                        $stmt2 = $conn->prepare("SELECT 
                                                   * 
                                                    FROM 
                                                        users  
                                                    WHERE
                                                        UserName=?
                                                    AND  UserID !=?");
                        $stmt2->execute(array($user,$id));
                        $counnt=$stmt2->rowCount();
                        if($counnt==1){
                            $theMsg= '<div class="alert alert-danger">'. 'sorry This thise User'."</div>";
                            Rediract($theMsg,'back',5);
                        }else{
                      

                                $stmt = $conn->prepare("UPDATE users set  UserName=?, Email=?, Password=?, FullName=? WHERE UserID=?");
                                $stmt->execute(array($user,$email,$pass,$name,$id));
                                $theMsg= '<div class="alert alert-success">'.$stmt->rowCount(). 'Record Update'."</div>";
                                Rediract($theMsg,'back',5);
                        }
                }
                
                    
                 
               }else{
                echo "<div class='container'>";
                $theMsg= "sorry You cant Broraser this Page";
                 Rediract($theMsg);
                  echo "</div>";
            }
            echo "</div>";
        }
      
     
    elseif($do=='Delete'){
                  
                    echo "<h1 class='text-center'>Delete Member </h1>";
                    echo "<div class='container'>";
                        $userid=isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
                        
                        //$stmt = $conn->prepare("SELECT * FROM users WHERE UserID=? LIMIT 1");
                      //  $stmt->execute(array($userid));
                        //$count=$stmt->rowCount();
                        $check=checkItem('userid','users',$userid);
                        if($check>0){  
                        
                        $stmt=$conn->prepare("DELETE FROM users WHERE  UserID=?");
                        $stmt->execute(array($userid));
                        $thMsg= '<div class="alert alert-success">'.$stmt->rowCount(). 'Record Delete'."</div>";
                        Rediract($thMsg,'back',2);
                        }else{
                            $thMsg= ' !The Id Not Exist';
                             Rediract($thMsg,'back');
                        }
                    echo "</div>";
   
        }
        elseif($do=='Activate'){
           // echo 'Activate';
              echo "<h1 class='text-center'>Activate Member </h1>";
                    echo "<div class='container'>";
                        $userid=isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
                        $check=checkItem('userid','users',$userid);
                        if($check>0){  
                        
                        $stmt=$conn->prepare("UPDATE  users SET RegStatus=1 WHERE  UserID=?");
                        $stmt->execute(array($userid));
                        $thMsg= '<div class="alert alert-success">'.$stmt->rowCount(). 'Activate Record'."</div>";
                        Rediract($thMsg,'back',2);
                        }else{
                            $thMsg= ' !The Id Not Exist';
                             Rediract($thMsg,'back');
                        }
                    echo "</div>";
        }
     include $tpl."footer.php";
}else{
   // echo "You Are Not Authoration To View this Page";
     header('Location : index.php');
     exit();
}
