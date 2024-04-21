<?php
/*
==========================
== Mange Comment Page
==  You Can Aprove Comments | Edit | Delete from 
====================
*/

        session_start();
        $pageTitle='Comments';
        if(isset($_SESSION['Username'])){
            include "inti.php";
        $do = isset($_GET['do'])?$_GET['do']:"manege";
        if($do == 'manege'){  

        $stmt=$conn->prepare("SELECT 
                                    comments.*,items.Name AS Item_Name,users.UserName AS Member
                                FROM 
                                    comments
                                INNER JOIN 
                                    items
                                ON
                                    items.item_ID = comments.item_id
                                INNER JOIN
                                    users
                                ON
                                    users.UserID = comments.user_id");
        $stmt->execute();
        $commnet=$stmt->fetchAll();
            if(! empty($commnet))
                    {
                                ?>


                            <h1 class="text-center" >Manege Comments</h1>
                            <div class="container">
                                <div class="table-responsive">
                                    <table class="main-table text-center table table-bordered">
                                <tr>
                                    <td>ID</td>
                                    <td>Comment</td>
                                    <td>Item Name</td>
                                    <td>User Name</td>
                                    <td>Added Date</td>
                                    <td>Control</td>
                                </tr>
                                <?php 
                                foreach($commnet as $comm){
                                    echo "<tr>";
                                        echo "<td>". $comm['c_id']."</td>";
                                        echo "<td>". $comm['comment']."</td>";
                                        echo "<td>". $comm['Item_Name']."</td>";
                                        echo "<td>". $comm['Member']."</td>";
                                        echo "<td>".$comm['comment_date'] ."</td>";
                                echo "<td>
                                            <a 
                                                href='comment.php?do=Edit&comid=".$comm['c_id']."' 
                                                class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                                            <a 
                                                href='comment.php?do=Delete&comid=".$comm['c_id']."' 
                                                class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
                                if($comm['status']==0){
                                echo "<a
                                            href='comment.php?do=Approve&comid=".$comm['c_id']."' 
                                            class='btn btn-info activate'>
                                            <i class='fa fa-check'>
                                            </i>Approve
                                        </a>";

                                            }
                                            echo" </td>";
                                    echo "</tr>";
                                            }
                                            ?>
                                            </tr>
                                        </table>
                                    </div>
                                        </div>
                        <?php 
                    }
                        else{
            echo "<div class='container'>";
                echo '<div class="nice-message">There\'s No Record Comments To Show</div>';
            echo "</div>";
                }
                    ?>
        <?php 
        }
    elseif($do == 'Edit'){ // Edit page  from database

        
        $comid=isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
                
            $stmt = $conn->prepare("SELECT * FROM comments WHERE c_id=?");
            $stmt->execute(array($comid));
            $row=$stmt->fetch();
            $count=$stmt->rowCount();
            if($stmt->rowCount()>0){  ?>
                            
                    <h1 class="text-center" >Edit Comment</h1>
                    <div class="container text-center">
                        <form class="form-horizontal" action="?do=update" method="POST">
                            <input type="hidden" name="comid" class="form-control" value="<?php echo $comid ?>"  />
                            <!-- Start UserName Filed-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-lable">Comment</label>
                                <div class="col-sm-10 col-md-6">
                                    <textarea class="form-control" name="comment"><?php echo $row['comment'] ?></textarea>
                                </div>
                            </div>
                            <!-- End UserName Filed-->
                            <!-- Start Submit Filed-->
                            <div class="form-group form-group-lg">
                                <div class="col-sm-offest-2 col-sm-10">
                                    <input type="submit" value="Save" class="btn btn-primary btn-lg" />
                                </div>
                            </div>
                            <!-- End Submit Filed-->
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
                echo "<h1 class='text-center'>Update Comment </h1>";
                echo "<div class='container'>";
                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    $comid=$_POST['comid'];
                    $comment=$_POST['comment'];

                    $stmt = $conn->prepare("UPDATE comments set comment=?  WHERE c_id=?");
                    $stmt->execute(array($comment,$comid));
                    $theMsg= '<div class="alert alert-success">'.$stmt->rowCount(). 'Record Update'."</div>";
                    Rediract($theMsg,'back');
                
                
                    
                
                }else{
                echo "<div class='container'>";
                $theMsg= "sorry You cant Broraser this Page";
                Rediract($theMsg);
                echo "</div>";
            }
            echo "</div>";
        }
      
     
    elseif($do=='Delete'){
                  
                    echo "<h1 class='text-center'>Delete Comment </h1>";
                    echo "<div class='container'>";
                        $comid=isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
                        
                        //$stmt = $conn->prepare("SELECT * FROM users WHERE UserID=? LIMIT 1");
                      //  $stmt->execute(array($userid));
                        //$count=$stmt->rowCount();
                        $check=checkItem('c_id','comments',$comid);
                        if($check>0){  
                        
                        $stmt=$conn->prepare("DELETE FROM comments WHERE  c_id=?");
                        $stmt->execute(array($comid));
                        $thMsg= '<div class="alert alert-success">'.$stmt->rowCount(). 'Record Delete'."</div>";
                        Rediract($thMsg,'back',2);
                        }else{
                            $thMsg= ' !The Id Not Exist';
                             Rediract($thMsg,'back');
                        }
                    echo "</div>";
   
            }
    elseif($do=='Approve'){
           // echo 'Activate';
                echo "<h1 class='text-center'>Approve Comment </h1>";
                    echo "<div class='container'>";
                        $comid=isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
                        $check=checkItem('c_id','comments',$comid);
                        if($check>0){  
                        
                        $stmt=$conn->prepare("UPDATE  comments SET `status`=1 WHERE  c_id=?");
                        $stmt->execute(array($comid));
                        $thMsg= '<div class="alert alert-success">'.$stmt->rowCount(). '  Record Approve'."</div>";
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
