<?php 
   
        //Error Reporting
        ini_set('display_errors','On');
        error_reporting(E_ALL);


      include "adimin/conect.php";
        $sessionUser='';
       if(isset($_SESSION['user'])) {
            $sessionUser=$_SESSION['user'];
        }

    //Routes
    $tpl="include/template/";
    $css="layout/css/";
    $js="layout/js/";
    $func="include/functions/";
    $lang ="include/languges/"; 

    
    //include the Importin File
    include $func .'function.php';
    include $lang."english.php";
    include  $tpl.'header.php'; 

