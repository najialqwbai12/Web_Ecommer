<?php

        /*
        ======================
        ===  Catgories Page
        =====================

        */
ob_start();
session_start();
$pageTitle='Categories';
if(isset($_SESSION['Username'])){

     include "inti.php";
     $do=isset($_GET['do'])?$_GET['do']:'manege';

    if($do=='manege'){
        $sort='ASC';
        $sort_array=array('ASC','DESC');
        if(isset($_GET['sort'])&&in_array($_GET['sort'],$sort_array)){
            $sort=$_GET['sort'];
        }
        $stmt=$conn->prepare("SELECT * FROM categories ORDER BY Ordering $sort");
        $stmt->execute();
        $cats=$stmt->fetchAll(); 
        if(! empty($cats)){
        ?>
           
            <h1 class="text-center"> Manege Catgories</h1>
            <div class="container catgories">
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-edit"></i>
                    Manege Catgories
                    <div class="option pull-right">
                       <i class="fa fa-sort"></i> Ordering : [
                        <a class="<?php if($sort=='ASC'){echo 'active';}?>" href="?sort=ASC">Asc</a>
                        <a class="<?php if($sort=='DESC'){echo 'active';}?>" href="?sort=DESC">Desc</a>]
                        <i class="fa fa-close"></i>View:[
                        <span class="active" data-view="full">Full</span>
                         <span data-view="classic">Classic</span>]
                    </div>
                </div>
                <div class="panel-body">
                    <?php 
                        foreach($cats as $cat){
                    echo "<div class='cat'>";
                        echo  '<div class="hidden-buttons">';
                            echo '<a href="categories.php?do=Edit&catid='.$cat["ID"].'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i>Edit</a>';
                            echo '<a href="categories.php?do=Delete&catid='.$cat["ID"].'" class="confirm btn btn-xs btn-danger"><i class="fa fa-close"></i>Delete</a>';

                        echo '</div>';
                            echo "<h3>".$cat["Name"].'</h3>';
                            echo "<div class='full-view'>";
                            echo  "<p>";if($cat["Description"]==''){echo "This Cargory has no description";}else{echo $cat["Description"];} echo'</p>';
                            if($cat['Visibilty']==1){echo "<span class='visbility'><i class='fa fa-eye'></i>Hidden</span>";}
                            if($cat['Allow_Comment']==1){echo "<span class='comment'><i class='fa fa-close'></i>Comment Disbaled</span>";}
                            if($cat['Allow_Ads']==1){echo "<span class='advertises'><i class='fa fa-close'></i>Ads Disbaled</span>";}
                        echo "</div>";
                    echo "</div>";
                    echo "<hr>";
                    }
                    ?>
                </div>

                </div>
              <a class="add-category btn btn-primary" href="categories.php?do=Add"><i class="fa fa-plus"></i>Add New Categories</a>
            </div>
            <?php } 
            else{
            echo "<div class='container'>";
                echo '<div class="nice-message">There\'s No Record To Show</div>';
                echo '<a class="add-category btn btn-primary" href="categories.php?do=Add"><i class="fa fa-plus"></i>Add New Categories</a>';

            echo "</div>";
                }  
            ?>
    <?php
    }elseif($do=='Add'){  ?>
    
     <h1 class="text-center" >Add New Catgory</h1>
                        <div class="container text-center">
                            <form class="form-horizontal" action="?do=Insert" method="POST">
                                <!-- Start Name Filed-->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-lable">Name</label>
                                    <div class="col-sm-10 col-md-6">
                                        <input type="text" name="name" class="form-control" autocomplete="off"  required="required" placeholder="Name Of The Catgoreis"/>
                                    </div>
                                </div>
                                <!-- End Name Filed-->
                                    <!-- Start Description Filed-->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-lable">Description</label>
                                    <div class="col-sm-10 col-md-6">
                                        <input type="text" name="description" class="form-control" autocomplete="new-password" placeholder="Description Of The Catgoreis"/>
                                    
                                    </div>
                                </div>
                            <!-- End Description Filed-->
                                <!-- Start Ordering Filed-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-lable">Ordering</label>
                                <div class="col-sm-10 col-md-6">
                                    <input type="text" name="ordering" class="form-control" placeholder="Number To Arrange THe Cargories "/>
                                </div>
                            </div>
                            <!-- End Ordering Filed-->
                            <!-- Start Visiblity Filed-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-lable">Visible</label>
                                <div class="col-sm-10 col-md-6">
                                    <div>
                                        <input id="vis-yes" type="radio" name="visiblity" value="0" checked />
                                        <label for="vis-yes">Yes</label>
                                    </div>
                                    <div>
                                        <input  id="vis-no" type="radio" name="visiblity" value="1"/>
                                        <label for="vis-no">No</label>
                                    </div>
                                </div>
                            </div>
                            <!-- End Visible Filed-->
                            <!-- Start Commenting Filed-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-lable">Allow Commenting</label>
                                <div class="col-sm-10 col-md-6">
                                    <div>
                                        <input id="com-yes" type="radio" name="commenting" value="0" checked />
                                        <label for="com-yes">Yes</label>
                                    </div>
                                    <div>
                                        <input  id="com-no" type="radio" name="commenting" value="1"/>
                                        <label for="com-no">No</label>
                                    </div>
                                </div>
                            </div>
                            <!-- End Visible Filed-->
                            <!-- Start Ads Filed-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-lable">Allow Ads</label>
                                <div class="col-sm-10 col-md-6">
                                    <div>
                                        <input id="ads-yes" type="radio" name="ads" value="0" checked />
                                        <label for="ads-yes">Yes</label>
                                    </div>
                                    <div>
                                        <input  id="ads-no" type="radio" name="ads" value="1" checked/>
                                        <label for="ads-no">No</label>
                                    </div>
                                </div>
                            </div>
                            <!-- End Ads Filed-->
                                <!-- Start Submits Filed-->
                            <div class="form-group form-group-lg">
                                <div class="col-sm-offest-2 col-sm-10">
                                    <input type="submit" value="Add Catgories" class="btn btn-primary btn-lg" />
                                </div>
                            </div>
                            <!-- End FullName Filed-->
                        </form>
                    </div>

<?php
    }elseif($do=='Insert'){
             
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                echo "<h1 class='text-center'>Insert Caregory </h1>";
                echo "<div class='container'>";

                    $name    =$_POST['name'];
                    $desc    =$_POST['description'];
                    $order   =$_POST['ordering'];
                    $visible =$_POST['visiblity'];
                    $comment =$_POST['commenting'];
                    $ads     =$_POST['ads'];
                    

                        $check=checkItem("Name","categories",$name);
                        if($check == 1){
                            //echo "Sorry This User Is Exist";
                            $theMsg= "<div class='alert alert-danger>Sorry This Categories Is Exist</div>";
                            Rediract($theMsg,'back',2);
                        }else{
                            $stmt = $conn->prepare("INSERT INTO
                        categories (`Name`,`Description`,Ordering,Visibilty,Allow_Comment,Allow_Ads)
                        VALUES (?,?,?,?,?,?)");
                            $stmt->execute(array($name,$desc,$order,$visible,$comment,$ads));
                            $count=$stmt->rowCount();
                        $theMsg= '<div class="alert alert-success">'.$stmt->rowCount().'Categories Inserted'."</div>";
                            
                        Rediract($theMsg,'back',5);
                                    }
                            
                            } 
                            else{
                                echo '<div class="container">';
                            $errorMsg= '<div class="alert alert-danger">sorry You cant Broraser this Page</div>';
                                Rediract($errorMsg,5); 
                                echo "</div>";
                                }

            echo "</div>"; 

    }elseif($do=='Edit'){


        $catid=isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
                
            $stmt = $conn->prepare("SELECT * FROM categories WHERE ID=?");
            $stmt->execute(array($catid));
            $cat=$stmt->fetch();
            $count=$stmt->rowCount();
            if($stmt->rowCount()>0){ 
             ?>
                    
     <h1 class="text-center" >Edit  Catgory</h1>
                        <div class="container text-center">
                            <form class="form-horizontal" action="?do=Update" method="POST">
                                <!-- Start ID Filed-->
                             
            
                                        <input type="hidden" name="catid" class="form-control"    value="<?php echo $cat['ID']; ?>"/>
                                
                                <!-- End ID Filed-->
                            <!-- Start Name Filed-->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-lable">Name</label>
                                    <div class="col-sm-10 col-md-6">
                                        <input type="text" name="name" class="form-control"   required="required" value="<?php echo $cat['Name']; ?>" placeholder="Name Of The Catgoreis"/>
                                    </div>
                                </div>
                                <!-- End Name Filed-->
                                    <!-- Start Description Filed-->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-lable">Description</label>
                                    <div class="col-sm-10 col-md-6">
                                        <input type="text" name="description" class="form-control" autocomplete="new-password"  value="<?php echo $cat['Description']; ?>" placeholder="Description Of The Catgoreis"/>
                                    
                                    </div>
                                </div>
                            <!-- End Description Filed-->
                                <!-- Start Ordering Filed-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-lable">Ordering</label>
                                <div class="col-sm-10 col-md-6">
                                    <input type="text" name="ordering" class="form-control"  value="<?php echo $cat['Ordering']; ?>" placeholder="Number To Arrange THe Cargories "/>
                                </div>
                            </div>
                            <!-- End Ordering Filed-->
                            <!-- Start Visiblity Filed-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-lable">Visible</label>
                                <div class="col-sm-10 col-md-6">
                                    <div>
                                        <input id="vis-yes" type="radio" name="visiblity" value="0" <?php if($cat['Visibilty']==0){echo 'checked';} ?> />
                                        <label for="vis-yes">Yes</label>
                                    </div>
                                    <div>
                                        <input  id="vis-no" type="radio" name="visiblity" value="1"  <?php if($cat['Visibilty']==1){echo 'checked';} ?>/>
                                        <label for="vis-no">No</label>
                                    </div>
                                </div>
                            </div>
                            <!-- End Visible Filed-->
                            <!-- Start Commenting Filed-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-lable">Allow Commenting</label>
                                <div class="col-sm-10 col-md-6">
                                    <div>
                                        <input id="com-yes" type="radio" name="commenting" value="0"  <?php if($cat['Allow_Comment']==0){echo 'checked';} ?> />
                                        <label for="com-yes">Yes</label>
                                    </div>
                                    <div>
                                        <input  id="com-no" type="radio" name="commenting" value="1"  <?php if($cat['Allow_Comment']==1){echo 'checked';} ?>/>
                                        <label for="com-no">No</label>
                                    </div>
                                </div>
                            </div>
                            <!-- End Visible Filed-->
                            <!-- Start Ads Filed-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-lable">Allow Ads</label>
                                <div class="col-sm-10 col-md-6">
                                    <div>
                                        <input id="ads-yes" type="radio" name="ads" value="0"  <?php if($cat['Allow_Ads']==0){echo 'checked';} ?> />
                                        <label for="ads-yes">Yes</label>
                                    </div>
                                    <div>
                                        <input  id="ads-no" type="radio" name="ads" value="1"  <?php if($cat['Allow_Ads']==1){echo 'checked';} ?>/>
                                        <label for="ads-no">No</label>
                                    </div>
                                </div>
                            </div>
                            <!-- End Ads Filed-->
                                <!-- Start Submits Filed-->
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
                        $theMsg= '<div class="alert alert-danger">! Not ID This Such The Form</div>';
                        Rediract($theMsg,4);
                        echo "</div>";
                }

    }elseif($do=='Update'){

        echo "<h1 class='text-center'>Update Categories </h1>";
                echo "<div class='container'>";
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                 
                    $id      =$_POST['catid'];
                    $name    =$_POST['name'];
                    $desc    =$_POST['description'];
                    $order   =$_POST['ordering'];
                    $visible =$_POST['visiblity'];
                    $comment =$_POST['commenting'];
                    $ads     =$_POST['ads'];
                
                      $formErroe=array();
                   if(empty($name)){
                        $formErroe[]='Full Name Cant Be Empty';
                    }
                    
                    foreach($formErroe as $error){
                        echo  '<div class="alert alert-danger">'.$error.'</div>';
                    }
    
      
                    if(empty($formErroe)){
                     $stmt = $conn->prepare("UPDATE categories set  `Name`=?, `Description`=?, Ordering=?, Visibilty=?,Allow_Comment=?,Allow_Ads=? WHERE ID=?");
                    $stmt->execute(array($name,$desc,$order,$visible,$comment,$ads,$id));
                    $theMsg= '<div class="alert alert-success">'.$stmt->rowCount(). 'Record Update Categories'."</div>";
                     Rediract($theMsg,'back',5);
                }
                
                    
                 
               }else{
                echo "<div class='container'>";
                $theMsg= "sorry You cant Broraser this Page";
                 Rediract($theMsg);
                  echo "</div>";
            }
            echo "</div>";

    }elseif($do=='Delete'){
            
             
                    echo "<h1 class='text-center'>Delete Category </h1>";
                    echo "<div class='container'>";
                        $catid=isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
                        
                        //$stmt = $conn->prepare("SELECT * FROM users WHERE UserID=? LIMIT 1");
                      //  $stmt->execute(array($userid));
                        //$count=$stmt->rowCount();
                        $check=checkItem('ID','categories',$catid);
                        if($check>0){  
                        
                        $stmt=$conn->prepare("DELETE FROM categories WHERE  ID=?");
                        $stmt->execute(array($catid));
                        $thMsg= '<div class="alert alert-success">'.$stmt->rowCount(). 'Record Delete'."</div>";
                        Rediract($thMsg,'back',2);
                        }else{
                            $thMsg= ' !The Id Not Exist';
                             Rediract($thMsg,'back');
                        }
                    echo "</div>";
   
      
    }

      include $tpl.'footer.php';

}else{
    header('Location: index.php');
    exit();
}

ob_end_flush();

?>