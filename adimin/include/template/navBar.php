<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav"  aria-expanded="false">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="dashboard.php"><?php echo lang('HOME_ADMIN')?></a>
    </div>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav">
          <li> <a href="categories.php"><?php echo lang('CATEGORIES')?></a></li>
          <li> <a href="member.php"><?php echo lang('MENUBAR')?></a></li>
          <li> <a href="items.php"><?php echo lang('ITEMS')?></a></li>
          <li> <a href="comment.php"><?php echo lang('COMMENTS')?></a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Naji <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="../index.php">Visit Shop </a></li>
            <li><a href="member.php?do=manege&userid=<?php echo $_SESSION['ID']?>">Edit Profile</a></li>
            <li><a href="#">Settings </a></li>
            <li><a href="logout.php">Logout </a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>