<?php 
    ob_start();
     session_start();
      $pageTitle='Show Items';
     include "inti.php";

        ////
        $itemid=isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
                
            $stmt = $conn->prepare("SELECT 
                                        items.*,
                                        categories.Name AS Cat_Name,
                                        users.UserName 
                                    FROM 
                                        items
                                    INNER JOIN categories ON categories.ID=items.Cat_ID
                                    INNER JOIN users ON users.UserID=items.Mamber_ID 
                                   WHERE item_ID =?
                                   AND Approve=1");
            
            $stmt->execute(array($itemid));
            $count=$stmt->rowCount();
            if($count >0){
            $item=$stmt->fetch();

        ?>

        <h1 class="text-center"><?php echo $item['Name']?> </h1>
        <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <img class="img-responsive img-thumbnail center-block" src="img2.jpg" alt=""/>
                    </div>
                    <div class="col-md-9 item-info">
                        <h2><?php echo $item['Name']?></h2>
                        <p><?php echo $item['Description']?></p>
                        <ul class="list-unstyled">
                        <li> 
                            <i class="fa fa-calendar fa-fw"></i>
                            <span>Added Date</span>: <?php echo $item['Add_Date']?></li>
                        <li>
                            <i class="fa fa-money fa-fw"></i>
                            <span>Added Price</span>: <?php echo $item['Price']?></li>
                        <li>
                            <i class="fa fa-building fa-fw"></i>
                            <span>Made In</span>: <?php echo $item['Contry_Made']?></li>
                        <li>
                            <i class="fa fa-tags fa-fw"></i>
                            <span>Categories</span>:<a href="categore.php?pageid=<?php echo $item['Cat_ID']?>"><?php echo $item['Cat_Name']?></a></li>
                        <li>
                            <i class="fa fa-user fa-fw"></i>
                            <span>Added By </span>: <a href="#"><?php echo $item['UserName']?></a></li>
                        </ul>
                    </div>
            </div>
            <hr class="custom-hr">
            <!-- Start Add Comments -->
            <?php 
             if(isset($_SESSION['user'])){
                ?>
            <div class="row">
                    <div class="col-md-offset-3">
                        <div class="add-comment">
                        <h3>Add Your Comment</h3>
                        <form action="<?php echo $_SERVER['PHP_SELF'] .'?itemid='.$item['item_ID'] ?>" method="POST">
                            <textarea name="comment" required> </textarea>
                            <input class="btn btn-primary" type="submit" value="Add Comment">
                        </form>
                        <?php
                        if($_SERVER['REQUEST_METHOD']== 'POST'){
            
                           
                                $comment =filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
                                $itemid  =$item['item_ID'];
                                $userid  =$_SESSION['uid'];
                                 if(! empty($comment)){
                                $stmt = $conn->prepare("INSERT INTO
                                    comments (`comment`,`status`,`comment_date`,`item_id`,`user_id`)
                                    VALUES (?,0,now(),?,?)");
                                $stmt->execute(array($comment,$itemid,$userid));
                                if($stmt){
                                echo '<div class="alert alert-success">Comment Added</div>';
                                }
                            }
                            else{
                                 echo '<div class="alert alert-danger">Not Comment Added</div>';
                            }
                        }
                        ?>
                    </div>
                    </div>
        
            </div>
                <!-- End Add Comments -->
                <?php  }else{
                    echo '<a href="login.php"> Login </a> Or <a href="login.php">  Regaistar </a>Add Comments';
                }
                ?>
            <hr class="custom-hr">
                <?php
                        $stmt=$conn->prepare("SELECT 
                                    comments.*,users.UserName AS Member
                                FROM 
                                    comments
                
                                INNER JOIN
                                    users
                                ON
                                    users.UserID = comments.user_id
                                    WHERE item_id=? and `status`=1
                                    ");
        $stmt->execute(array($itemid));
        $commnet=$stmt->fetchAll();
       
                        ?>
                    
                    <?php 
                    foreach($commnet as $comnt){
                        echo '<div class="comment-box">';
                        echo '<div class="row">';
                            echo'<div class="col-sm-2 text-center"> <img class="img-responsive img-thumbnail img-circle center-block" src="img2.jpg" alt=""/> '
                            .$comnt['Member'].'</div>';
                            echo'<div class="col-sm-10"><p class="lead">'.$comnt['comment'].'</p></div>';
                            echo '</div>';
                            echo ' <hr class="custom-hr">';
                        }
                        ?>
                </div>
                 <hr class="custom-hr">
           </div>

    <?php 
            }else{
              echo 'There\'s No Such ID';
            }
   
    include $tpl."footer.php";

    ob_end_flush();
