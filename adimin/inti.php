<?php 
   

   include "conect.php";


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
 
 //include  $tpl.'navBar.php';
 // include  NavBar on all page Expect the Open 
 if(!isset($noNavbar)){ include  $tpl.'navBar.php'; }
 