<?php
// SELECT items.*,categories.Name FROM items
// INNER JOIN categories ON categories.ID=items.Cat_ID
// INNER JOIN
session_start();
if(isset($_SESSION['Username'])){
   $pageTitle='Dashboard';
   
   include "inti.php";
         $numUser=6;
         $latestUsers=getLatest("*","users","UserID",$numUser);
         $numItems=6;
         $latestItems=getLatest("*","items","item_ID",$numItems);

         $numComment=4;
   //Start  Dashbord page
   ?>
               <div class="container home-stats text-center">
                     <h1>Dashboard</h1>
                     <div class="row">
                        <div class="col-md-3">
                           <div class="stat st-members"> 
                              <i class="fa fa-users"></i>
                              <div class="info">
                              Total Members
                              <span><a href="member.php"><?php echo counetItem('UserID','users') ?></a></span>
                           </div>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="stat st-pending">
                              <i class="fa fa-user-plus"></i>
                              <div class="info">
                              Pending Members
                              <span><a href="member.php?do=manege&page=pending">
                                 <?php echo checkItem('RegStatus','users',0) ?>
                                 </a></span>
                              </div>
                              </div>
                        </div>
                        <div class="col-md-3">
                           <div class="stat st-items">
                              <i class="fa fa-tag"></i>
                              <div class="info">
                                 Total Items
                              <span><a href="items.php"><?php echo counetItem('item_ID','items') ?></a></span>
                              </div>

                              </div>
                        </div>
                        <div class="col-md-3">
                           <div class="stat st-comments">
                              <i class="fa fa-comments"></i>
                              <div class="info">
                              Total Comments 
                              <span><a href="comment.php"><?php echo counetItem('c_id','comments') ?></a></span>
                           </div>
                        </div>
                     </div>

               </div>
               <div class="latest">
                     <div class="container">
                           <div class="row" style="text-align: start">
                              <div class="col-sm-6">
                                 <div class="panel panel-default">
                                    
                                       <div class="panel-heading">
                                       <i class="fa fa-users">
                                          </i>Latest  <?php echo $numUser?>
                                          Regestar Users
                                          <span class="toggle-info pull-right">
                                             <i class="fa fa-plus fa-lg"></i>
                                          </span>
                                       </div>
                                       <div class="panel-body">
                                          <ul class="list-unstyled latest-users">
                                    <?php  
                                    if(! empty($latestItems))
                                    {
                                          foreach($latestUsers as $user){
                                             echo '<li>'. $user['UserName'];
                                             echo '<a href="member.php?do=Edit&userid='.$user['UserID'].'">';
                                             echo '<span class="btn btn-success pull-right">';
                                             echo '<i class="fa fa-edit"></i> Edit';
                                             if($user['RegStatus']==0){
                                                echo    "<a href='member.php?do=Activate&userid=".$user['UserID']."' 
                                                         class='btn btn-info pull-right activate'>
                                                         <i class='fa fa-check'></i>Activate</a>";

                                                }
                                             echo' </span>';
                                             echo '</a>'.'</li>';
                                          }
                                    }
                                 else{
                                       echo 'There\'s No Record To Show';
                                 }
                                    ?>
                                    </ul>
                                    </div>
                                 </div>

                              </div>
                              <div class="col-sm-6">
                                 <div class="panel panel-default">
                                       <div class="panel-heading">
                                       <i class="fa fa-tag"> </i>Latest <?php echo $numItems ?> Items
                                          <span class="toggle-info pull-right">
                                             <i class="fa fa-plus fa-lg"></i>
                                          </span>
                                       </div>
                                       <div class="panel-body">
                                       <ul class="list-unstyled latest-users">
                                    <?php  
                                    if(! empty($latestItems)){
                                    foreach($latestItems as $item){
                                       echo '<li>'. $item['Name'];
                                       echo '<a href="items.php?do=Edit&itemid='.$item['item_ID'].'">';
                                       echo '<span class="btn btn-success pull-right">';
                                       echo '<i class="fa fa-edit"></i> Edit';
                                       if($item['Approve']==0){
                                          echo  "<a 
                                                      href='items.php?do=Approve&itemid=".$item['item_ID']."' 
                                                      class='btn btn-info pull-right activate'>
                                                      <i class='fa fa-check'></i>Approve</a>";
                                          }
                                       echo' </span>';
                                       echo '</a>'.'</li>';
                                    }
                                 }else{
                                    echo 'There\'s No Record Comment To Show';
                                 }
                                    ?>
                                    </ul>
                                       </div>
                                 </div>

                              </div>

                           </div>

                           <!-- Start Latest Comments -->
                        
                           <div class="row" style="text-align: start">
                              <div class="col-sm-6">
                                 <div class="panel panel-default">
                                    
                                       <div class="panel-heading">
                                       <i class="fa fa-comments-o">
                                          </i>Latest <?php echo $numComment ?> Comments
                                          <span class="toggle-info pull-right">
                                             <i class="fa fa-plus fa-lg"></i>
                                          </span>
                                       </div>
                                       <div class="panel-body">
                                          <?php 
                                                $stmt=$conn->prepare("SELECT 
                                                                     comments.*,users.UserName AS Member
                                                               FROM 
                                                                     comments
                                                               INNER JOIN
                                                                     users
                                                               ON
                                                                     users.UserID = comments.user_id
                                                                     ORDER BY c_id DESC
                                                                     limit $numComment");
                                                $stmt->execute();
                                                $comments=$stmt->fetchAll();
                                                if(! empty ($comments)){
                                                foreach($comments as $comment){
                                                   echo "<div class='comment-box'>";
                                                   echo '<span class="member-n">
                                                            <a  href="comment.php?do=Edit&comid='.$comment["user_id"].'">
                                                                     ' .$comment['Member'].'</a> </span>';
                                                   echo "<p class='member-c'>".$comment['comment']."</p>";
                                                   echo "</div>";
                                                }
                                          ?>
                                    </div>
                                    <?php 
                                    }else{
                                    echo 'There\'s No Record Comment To Show';
                                 }
                                    ?>
                                 </div>
                              </div>
                        </div>
                  <!-- End Latest Comments -->
                     </div>

                  </div>
   <?php
   include $tpl."footer.php";
}else{
   // echo "You Are Not Authoration To View this Page";
     header('Location : index.php');
     exit();
}