<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php getTitle()?></title>
    <link rel="stylesheet" href="<?php echo $css?>bootstrap.min.css"/>
    <link rel="stylesheet" href="<?php echo $css?>font-awesome.min.css"/>
    <link rel="stylesheet" href="<?php echo $css?>front.css"/>
</head>
<body>
  
  <div class="upper-bar my-info">
    <div class="container">
     <?php if(isset($_SESSION['user'])){ ?>

      <div class="btn-group">
        <img src="img2.png" class="img-thumbnail img-responsive" alt=""/>
        <ul class="nav navbar-nav">
        <li class="dropdown">
        <a href="#" class="btn dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
                <?php echo $sessionUser ?> <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li><a href="profile.php">My Profile </a></li>
            <li><a href="newad.php"> New Item</a></li>
            <li><a href="profile.php#my-ads"> My Item</a></li>
            <li><a href="logout.php">Logout </a></li>
        </ul>
    </li>
</ul>
     </div>
      <?php

      }else{

    
      ?>
      <a href="login.php">
        <span class="pull-right">Login/Signup</span>
      </a>
      <?php }?>
    </div>
  </div>
  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav"  aria-expanded="false">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Homepage</a>
    </div>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav" role="menu">
      <?php
      foreach (getCats() as $cat){
          echo'<li><a href="categore.php?pageid='.$cat['ID'].'">'
          . $cat['Name'].'
          </a>
          </li>';
        } 
      ?>
      </ul>
      
    </div>
  </div>
</nav>