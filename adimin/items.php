<?php

        /*
        ======================
        ===  Items Page
        =====================

        */
ob_start();
session_start();
$pageTitle='Items';
if(isset($_SESSION['Username'])){

     include "inti.php";
     $do=isset($_GET['do'])?$_GET['do']:'manege';

    if($do=='manege'){
        
        
            $stmt=$conn->prepare("SELECT 
                                        items.*,
                                        categories.Name AS Cat_Name,
                                        users.UserName 
                                    FROM 
                                        items
                                    INNER JOIN categories ON categories.ID=items.Cat_ID
                                    INNER JOIN users ON users.UserID=items.Mamber_ID ORDER BY item_ID DESC");
            $stmt->execute();
            $items=$stmt->fetchAll();
            if(! empty($items)){
            ?>
    

                <h1 class="text-center" >Manege Items</h1>
                <div class="container">
                    <div class="table-responsive">
                <table class="main-table text-center table table-bordered">
                    <tr>
                        <td>#item_ID</td>
                        <td>Name</td>
                        <td>Description</td>
                        <td>Price</td>
                        <td>Adding Date</td>
                        <td>Category</td>
                        <td>UserName</td>
                        <td>Control</td>
                    </tr>
                    <?php 
                    foreach($items as $item){
                        echo "<tr>";
                            echo "<td>". $item['item_ID']."</td>";
                            echo "<td>". $item['Name']."</td>";
                            echo "<td>". $item['Description']."</td>";
                            echo "<td>". $item['Price']."</td>";
                            echo "<td>".$item['Add_Date'] ."</td>";
                            echo "<td>". $item['Cat_Name']."</td>";
                            echo "<td>".$item['UserName'] ."</td>";
                            echo "<td>
                            <a href='items.php?do=Edit&itemid=".$item['item_ID']."' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                            <a href='items.php?do=Delete&itemid=".$item['item_ID']."' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
                        if($item['Approve']==0){
                        echo "<a href='items.php?do=Approve&itemid=".$item['item_ID']."' class='btn btn-info activate'><i class='fa fa-check'></i>Approve
                        </a>";

                                        }
                                        echo" </td>";
                                    echo "</tr>";
                                }
                                ?>
                                </tr>
                            </table>
                        </div>
                            <a href="items.php?do=Add" 
                            class="btn btn-sm btn-primary">
                            <i class="fa fa-plus"></i> New Items</a>
                    </div>
            <?php }
            else{
            echo "<div class='container'>";
                echo '<div class="nice-message">There\'s No Record Items To Show</div>';
              echo  '<a href="items.php?do=Add" 
                            class="btn btn-sm btn-primary">
                            <i class="fa fa-plus"></i>Add New Items</a>';
            echo "</div>";
                }
            ?>

<?php
    }
    elseif($do=='Add'){ 
            ?>  
        <h1 class="text-center" >Add New Items</h1>
                <div class="container text-center">
                    <form class="form-horizontal" action="?do=Insert" method="POST">
                        <!-- Start Name Filed-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-lable">Name</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="name" class="form-control"   required="required" placeholder="Name Of The Item"/>
                            </div>
                        </div>
                        <!-- End Name Filed-->
                        <!-- Start Description Filed-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-lable">Description</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="description" class="form-control" required="required" placeholder="Description Of The Item"/>
                            </div>
                        </div>
                        <!-- End Description Filed-->
                        <!-- Start Price Filed-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-lable">Price</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="price" class="form-control" required="required"  placeholder="Price Of The Item"/>
                            </div>
                        </div>
                        <!-- End Price Filed-->
                        <!-- Start Contry Made Filed-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-lable">Country</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="country" class="form-control"  required="required" placeholder="Country Of Made The Item"/>
                            </div>
                        </div>
                        <!-- End Contry Made Filed-->
                        <!-- Start Status Filed-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-lable">Status</label>
                            <div class="col-sm-10 col-md-6">
                                <select class="form-control" name="status">
                                    <option value="0">...</option>
                                    <option value="1">New</option>
                                    <option value="2">Like New</option>
                                    <option value="3">Used</option>
                                    <option value="4">Very Old</option>
                                </select>
                            </div>
                        </div>
                        <!-- End Status Filed-->
                        <!-- Start Member Filed-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-lable">Member</label>
                            <div class="col-sm-10 col-md-6">
                                <select class="form-control" name="member">
                                    <option value="0">...</option>
                                    <?php 
                                        $stmt=$conn->prepare("SELECT * FROM users");
                                        $stmt->execute();
                                        $users=$stmt->fetchAll();
                                        foreach($users as $user){
                                            echo "<option value='".$user['UserID']."'>".$user['UserName']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- End Status Filed-->
                        <!-- Start Categories Filed-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-lable">Category</label>
                            <div class="col-sm-10 col-md-6">
                                <select class="form-control" name="category">
                                    <option value="0">...</option>
                                    <?php 
                                        $stmt2=$conn->prepare("SELECT * FROM categories");
                                        $stmt2->execute();
                                        $cats=$stmt2->fetchAll();
                                        foreach($cats as $cat){
                                            echo "<option value='".$cat['ID']."'>".$cat['Name']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- End Status Filed-->
                    
                        <!-- Start Submits Filed-->
                    <div class="form-group form-group-lg">
                        <div class="col-sm-offest-2 col-sm-10">
                            <input type="submit" value="Add Item" class="btn btn-primary btn-sm" />
                        </div>
                    </div>
                    <!-- End FullName Filed-->
                </form>
            </div>


  <?php
    }elseif($do=='Insert'){

        
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                echo "<h1 class='text-center'>Insrt Items </h1>";
                echo "<div class='container'>";

                $name      =$_POST['name'];
                $desc      =$_POST['description'];
                $price     =$_POST['price'];
                $country   =$_POST['country'];
                $status    =$_POST['status'];
                $member    =$_POST['member'];
                $category  =$_POST['category'];
                
                $formErroe=array();
            
                if(empty($name)){
                    $formErroe[]='Name Cant Be Empty';
                }
                if(empty($desc)){
                    $formErroe[]='description Cant Be Empty';
                }
                if(empty($price)){
                    $formErroe[]='Price  Cant Be Empty';
                }
                if(empty($country)){
                    $formErroe[]='Country Cant Be Empty';
                }
                if($status == 0){
                    $formErroe[]='status Cant Be Empty';
                }
                if($member == 0){
                    $formErroe[]='Member Cant Be Empty =0 ';
                }
                if($category == 0){
                    $formErroe[]='Category Cant Be Empty =0 ';
                }
                foreach($formErroe as $error){
                    echo  '<div class="alert alert-danger">'.$error.'</div>';
                }

    
                if(empty($formErroe)){
                    //Insert Info User database
                    
                        $stmt = $conn->prepare("INSERT INTO
                            items (`Name`,`Description`,`Price`,`Contry_Made`,`Status`,Add_Date,Mamber_ID,Cat_ID)
                            VALUES (?,?,?,?,?,now(),?,?)");
                        $stmt->execute(array($name,$desc,$price,$country,$status,$member,$category));
                        $count=$stmt->rowCount();
                        $theMsg= '<div class="alert alert-success">'.$stmt->rowCount().'Record Inserted'."</div>";
                        
                        Rediract($theMsg,'back',5);
                            
                            }
                            
                            } 
                            else{
                                echo '<div class="container">';
                                    $errorMsg= '<div class="alert alert-danger">sorry You cant Broraser this Page Diractly</div>';
                                Rediract($errorMsg); 
                                echo "</div>";
                                }

            echo "</div>"; 
        

    }elseif($do=='Edit'){
        
        $itemid=isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
                
            $stmt = $conn->prepare("SELECT * FROM items WHERE item_ID=?");
            $stmt->execute(array($itemid));
            $item=$stmt->fetch();
            $count=$stmt->rowCount();
            if($stmt->rowCount()>0){ 
             ?>
    
                <h1 class="text-center" >Edit Items</h1>
                <div class="container text-center">
                    <form class="form-horizontal" action="?do=Update" method="POST">
                        <input type="hidden" name="itemid"  value="<?php echo $item['item_ID'] ?>"/>
                        <!-- Start Name Filed-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-lable">Name</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="name" class="form-control"   required="required" value="<?php echo $item['Name'] ?>" placeholder="Name Of The Item"/>
                            </div>
                        </div>
                        <!-- End Name Filed-->
                        <!-- Start Description Filed-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-lable">Description</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="description" class="form-control" required="required" value="<?php echo $item['Description'] ?>" placeholder="Description Of The Item"/>
                            </div>
                        </div>
                        <!-- End Description Filed-->
                        <!-- Start Price Filed-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-lable">Price</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="price" class="form-control" required="required" value="<?php echo $item['Price'] ?>"  placeholder="Price Of The Item"/>
                            </div>
                        </div>
                        <!-- End Price Filed-->
                        <!-- Start Contry Made Filed-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-lable">Country</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="country" class="form-control"  required="required" value="<?php echo $item['Contry_Made'] ?>" placeholder="Country Of Made The Item"/>
                            </div>
                        </div>
                        <!-- End Contry Made Filed-->
                        <!-- Start Status Filed-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-lable">Status</label>
                            <div class="col-sm-10 col-md-6">
                                <select class="form-control" name="status">
                                
                                    <option value="1" <?php if($item['Status']==1){echo 'selected';} ?>>New</option>
                                    <option value="2" <?php if($item['Status']==2){echo 'selected';} ?>>Like New</option>
                                    <option value="3" <?php if($item['Status']==3){echo 'selected';} ?>>Used</option>
                                    <option value="4" <?php if($item['Status']==4){echo 'selected';} ?>>Very Old</option>
                                </select>
                            </div>
                        </div>
                        <!-- End Status Filed-->
                        <!-- Start Member Filed-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-lable">Member</label>
                            <div class="col-sm-10 col-md-6">
                                <select class="form-control" name="member">
                                    <option value="0">...</option>
                                    <?php 
                                        $stmt=$conn->prepare("SELECT * FROM users");
                                        $stmt->execute();
                                        $users=$stmt->fetchAll();
                                        foreach($users as $user){
                                            echo "<option value='".$user['UserID']."'";
                                            if($item['Mamber_ID']==$user['UserID']){echo 'selected';} 
                                            echo ">".$user['UserName']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- End Status Filed-->
                        <!-- Start Categories Filed-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-lable">Category</label>
                            <div class="col-sm-10 col-md-6">
                                <select class="form-control" name="category">
                                    <option value="0">...</option>
                                    <?php 
                                        $stmt2=$conn->prepare("SELECT * FROM categories");
                                        $stmt2->execute();
                                        $cats=$stmt2->fetchAll();
                                        foreach($cats as $cat){
                                            echo "<option value='".$cat['ID']."'";
                                            if($item['Cat_ID']==$cat['ID']){echo 'selected';} 
                                            echo">".$cat['Name']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- End Status Filed-->
                    
                        <!-- Start Submits Filed-->
                    <div class="form-group form-group-lg">
                        <div class="col-sm-offest-2 col-sm-10">
                            <input type="submit" value="Edit Item" class="btn btn-primary btn-sm" />
                        </div>
                    </div>
                    <!-- End FullName Filed-->
                </form>
                <?php
                $stmt=$conn->prepare("SELECT 
                                comments.*,users.UserName AS Member
                            FROM 
                                comments
                        
                            INNER JOIN
                                users
                            ON
                                users.UserID = comments.user_id
                            where item_id=? ");
                $stmt->execute(array($itemid));
                $rows=$stmt->fetchAll(); 
                if(!empty($rows))  {
            ?>
            

        <h1 class="text-center" >Manege [<?php echo $item['Name'] ?>] Comments</h1>
    
            <div class="table-responsive">
                <table class="main-table text-center table table-bordered">
            <tr>
                <td>Comment</td>
                <td>User Name</td>
                <td>Added Date</td>
                <td>Control</td>
            </tr>
            <?php 
            foreach($rows as $row){
                echo "<tr>";
                    echo "<td>". $row['comment']."</td>";
                    echo "<td>". $row['Member']."</td>";
                    echo "<td>".$row['comment_date'] ."</td>";
                        echo "<td>
                                    <a 
                                        href='comment.php?do=Edit&comid=".$row['c_id']."' 
                                        class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                                    <a 
                                        href='comment.php?do=Delete&comid=".$row['c_id']."' 
                                        class='btn btn-danger confirm'>
                                        <i class='fa fa-close'></i>Delete</a>";
                        if($row['status']==0){
                        echo "<a
                                    href='comment.php?do=Approve&comid=".$row['c_id']."' 
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
        <?php  } ?>
        </div>
        <?php 
            }
            else {
                    echo '<div class="container">';
                    $theMsg= '<div class="alert alert-danger">! Not ID This Is The Form</div>';
                    Rediract($theMsg,4);
                    echo "</div>";
            }

    }elseif($do=='Update'){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                echo "<h1 class='text-center'>Update Items </h1>";
                echo "<div class='container'>";
                $itemid      =$_POST['itemid'];
                $name      =$_POST['name'];
                $desc      =$_POST['description'];
                $price     =$_POST['price'];
                $country   =$_POST['country'];
                $status    =$_POST['status'];
                $member    =$_POST['member'];
                $category  =$_POST['category'];
                
                $formErroe=array();
            
                if(empty($name)){
                    $formErroe[]='Name Cant Be Empty';
                }
                if(empty($desc)){
                    $formErroe[]='description Cant Be Empty';
                }
                if(empty($price)){
                    $formErroe[]='Price  Cant Be Empty';
                }
                if(empty($country)){
                    $formErroe[]='Country Cant Be Empty';
                }
                if($status == 0){
                    $formErroe[]='status Cant Be Empty';
                }
                if($member == 0){
                    $formErroe[]='Member Cant Be Empty =0 ';
                }
                if($category == 0){
                    $formErroe[]='Category Cant Be Empty =0 ';
                }
                foreach($formErroe as $error){
                    echo  '<div class="alert alert-danger">'.$error.'</div>';
                }

    
                if(empty($formErroe)){
                    //Insert Info User database
                    
                        $stmt = $conn->prepare("UPDATE
                                                    items 
                                                set `Name`=?,`Description`=?,`Price`=?,`Contry_Made`=?,`Status`=?,Cat_ID=?,Mamber_ID=? WHERE item_ID=?");
                        $stmt->execute(array($name,$desc,$price,$country,$status,$category,$member,$itemid));
                    
                        $theMsg= '<div class="alert alert-success">'.$stmt->rowCount().'Record Update'."</div>";
                        
                        Rediract($theMsg,'back',5);
                            
                            }  
                            
                            } 
                            else{
                                echo '<div class="container">';
                                    $errorMsg= '<div class="alert alert-danger">sorry You cant Broraser this Page Diractly</div>';
                                Rediract($errorMsg,'back'); 
                                echo "</div>";
                                }

            echo "</div>"; 

    }elseif($do=='Delete'){

        
            echo "<h1 class='text-center'>Delete Items </h1>";
                    echo "<div class='container'>";
                        $itemid=isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
                        
                        //$stmt = $conn->prepare("SELECT * FROM users WHERE UserID=? LIMIT 1");
                      //  $stmt->execute(array($userid));
                        //$count=$stmt->rowCount();
                        $check=checkItem('item_ID','items',$itemid);
                        if($check>0){  
                        
                        $stmt=$conn->prepare("DELETE FROM items WHERE  item_ID=?");
                        $stmt->execute(array($itemid));
                        $thMsg= '<div class="alert alert-success">'.$stmt->rowCount(). 'Items Delete'."</div>";
                        Rediract($thMsg,'back',4);
                        }else{
                            $thMsg= ' !The Id Not Exist';
                             Rediract($thMsg,'back');
                        }
                    echo "</div>";

      
    }elseif($do=='Approve'){
                

                    echo "<h1 class='text-center'>Approve Items </h1>";
                    echo "<div class='container'>";
                        $itemid=isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
                        $check=checkItem('item_ID','items',$itemid);
                        if($check>0){  
                        
                        $stmt=$conn->prepare("UPDATE  items SET Approve=1 WHERE  item_ID=?");
                        $stmt->execute(array($itemid));
                        $thMsg= '<div class="alert alert-success">'.$stmt->rowCount(). 'Approve Record'."</div>";
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