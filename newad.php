<?php 
    ob_start();
     session_start();
     $pageTitle='Create New Item';
     include "inti.php";
    if(isset($_SESSION['user'])){
       
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $formErrors=array();

            $name     =filter_var($_POST['name'],FILTER_SANITIZE_STRING);
            $desc     =filter_var($_POST['description'],FILTER_SANITIZE_STRING);
            $price    =filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
            $country  =filter_var($_POST['country'],FILTER_SANITIZE_STRING);
            $status   =filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
            $category =filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);
            
        
            if(strlen($name)< 4){ 
                    $formErrors[]='name Must Be Larger Then 4 Charcters';
                }
            if(strlen($desc)< 10){ 
                $formErrors[]='description Must Be Larger Then 10 Charcters';
            }
            if(strlen($country)< 2){ 
                $formErrors[]='country Must Be Larger Then 2 Charcters';
            }
            if(empty($price)){ 
                    $formErrors[]='Item price Must Be Empty Charcters';
                }
            if(empty($status)){ 
                    $formErrors[]='Item status Must Be Empty Charcters';
                }
            if(empty($category)){ 
                    $formErrors[]='Item category Must Be Empty Charcters';
                }

                if(empty($formErrors)){
                    //Insert Info User database
                    
                        $stmt = $conn->prepare("INSERT INTO
                            items (`Name`,`Description`,`Price`,`Contry_Made`,`Status`,Add_Date,Mamber_ID,Cat_ID)
                            VALUES (?,?,?,?,?,now(),?,?)");
                        $stmt->execute(array($name,$desc,$price,$country,$status,$_SESSION['uid'],$category));
                        
                        if($stmt){
                            $successMsg= 'Congrats Tou Are Now Registard User ';
                          
                        }
                    }
        }
        ?>
        <h1 class="text-center"><?php echo $pageTitle ?></h1>
        <div class="create-ad block">
            <div class="container">
                <div class="panel panel-primary">
                    <div class="panel-heading">My New Ad</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <form class="form-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <!-- Start Name Filed-->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-3 control-lable">Name</label>
                                        <div class="col-sm-10 col-md-9">
                                            <input type="text"
                                                    pattern=".{4,}"
                                                    title="This Is Filed is Leats 4 Charactrers"
                                                    name="name" 
                                                    class="form-control live" 
                                                    data-class=".live-title" 
                                                    placeholder="Name Of The Item" required/>
                                        </div>
                                    </div>
                                    <!-- End Name Filed-->
                                    <!-- Start Description Filed-->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-3 control-lable">Description</label>
                                        <div class="col-sm-10 col-md-9">
                                            <input type="text" 
                                                    name="description" 
                                                    pattern=".{4,}"
                                                    title="This Is Filed is Leats 4 Charactrers"
                                                    class="form-control live" 
                                                    data-class=".live-desc"
                                                     placeholder="Description Of The Item" required/>
                                        </div>
                                    </div>
                                    <!-- End Description Filed-->
                                    <!-- Start Price Filed-->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-3 control-lable">Price</label>
                                        <div class="col-sm-10 col-md-9">
                                            <input type="text" name="price" class="form-control live"  data-class=".live-price" placeholder="Price Of The Item" required/>
                                        </div>
                                    </div>
                                    <!-- End Price Filed-->
                                    <!-- Start Contry Made Filed-->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-3 control-lable">Country</label>
                                        <div class="col-sm-10 col-md-9">
                                            <input type="text" name="country" class="form-control"  placeholder="Country Of Made The Item"/>
                                        </div>
                                    </div>
                                    <!-- End Contry Made Filed-->
                                    <!-- Start Status Filed-->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-3 control-lable">Status</label>
                                        <div class="col-sm-10 col-md-9">
                                            <select class="form-control" name="status">
                                                <option value="">...</option>
                                                <option value="1">New</option>
                                                <option value="2">Like New</option>
                                                <option value="3">Used</option>
                                                <option value="4">Very Old</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- End Status Filed-->
                                
                                    <!-- Start Categories Filed-->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-3 control-lable">Category</label>
                                        <div class="col-sm-10 col-md-9">
                                            <select class="form-control" name="category">
                                                <option value="">...</option>
                                                <?php 
                                                    $cats=getAllFrom('categories','ID');
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
                                    <div class="col-sm-offest-3 col-sm-9">
                                        <input type="submit" value="Add Item" class="btn btn-primary btn-sm" />
                                    </div>
                                </div>
                                <!-- End Submits Filed-->
                            </form>
                                </div>
                                <div class="col-md-4">
                                    <div class="thumbnail item-box live-preview">
                                    <span class="price-tag">
                                        $<span class="live-price">0</span>
                                    </span>
                                    <img class="img-responsive" src="img2.jpg" alt=""/>
                                    <div class="caption">
                                    <h3 class="live-title">Title</h3>
                                    <p class="live-desc">Description </p>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <!-- Start Looping Through Errors -->
                                <?php 
                                if(! empty($formErrors)){
                                    foreach($formErrors as $error){
                                        echo '<div class="alert alert-danger">' .$error. '</div>';
                                    }
                                }
                                if(isset($successMsg)){
                                        echo '<div class="alert alert-success">'.$successMsg.'</div>';
                                    }
                                ?>

                                <!-- End Looping Through Errors -->
                            </div>
                    </div>
                </div>
            </div>
        </div>
    <?php 
    }else {
        header('Location: login.php');
    exit(); 
    }
    include $tpl."footer.php";

    ob_end_flush();