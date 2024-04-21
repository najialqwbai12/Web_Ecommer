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
       echo 'Welcom Yoe are :';

    }elseif($do=='Add'){  ?>
    
      < Welcom To Add Page

  <?php
    }elseif($do=='Insert'){

    }elseif($do=='Edit'){

    }elseif($do=='Update'){

    }elseif($do=='Delete'){

      
    }

      include $tpl.'footer.php';

}else{
    header('Location: index.php');
    exit();
}

ob_end_flush();

?>