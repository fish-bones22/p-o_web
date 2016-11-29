<?php
  include 'php/connect_to_db.php';

  $is_signed_in = 0;

  // Get file name of the page the nav bar is currently on
  // to properly set-up links' names.
  $pagefile = $_SERVER['REQUEST_URI'];
  if (strpos($pagefile, 'index.php')) {
    $link = '';
    $reserve_link = '#reserve';
  } else {
    $link = 'index.php';
    $reserve_link = 'reserve.php';
  }

  if(($_SESSION['uname'] == "") || (!isset($_SESSION['uname'])) ){
    $is_signed_in = 0;
    $hidden1 = 'hidden';
    $hidden2 = '';
    $_SESSION['admin'] = false;
  } else {
    $acc = $_SESSION['uname'];
    $is_signed_in = 1;
    $hidden1 = '';
    $hidden2 = 'hidden';
  }

  if (isset($_SESSION['admin']) == 0) {
    $_SESSION['admin'] = false;
  }
  if ($_SESSION['admin'] == 0) {
    $hide_if_not_admin = 'hidden';
    $hide_if_admin = '';
  } else {
    $hide_if_not_admin = '';
    $hide_if_admin = 'hidden';
  }
?>

<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
      </button>
      <a class="navbar-brand page-scroll" href= <?php echo $link.'#page-top';?>>
        <div class="serif strong p-o">P&amp;O</div>
        <div class="transport">Transport</div>
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
      <ul class="nav navbar-nav">
        <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
        <li class="hidden">
          <a href= <?php echo $link.'#page-top';?>></a>
        </li>
        <li class='<?php echo $hide_if_admin; ?>'>
          <a class='page-scroll' href= <?php echo $reserve_link;?> id="reserve-btn-navbar">Reserve</a>
        </li>
        <li class='<?php echo $hide_if_not_admin; ?>'>
          <a class='page-scroll' href='admin.php'>Admin</a>
        </li>
        <li class='<?php echo $hide_if_admin; ?>'>
          <a class='page-scroll' href= <?php echo $link.'#about';?>>About</a>
        </li>
        <li class='<?php echo $hide_if_admin; ?>'>
          <a class='page-scroll' href= <?php echo $link.'#route';?>>Route</a>
        </li>
        <li class='<?php echo $hide_if_admin; ?>'>
          <a class='page-scroll' href=<?php echo $link.'#contact';?>>Contact</a>
        </li>
        <li class='<?php echo $hidden2; ?>'>
          <a class='login-navbar' href=<?php echo $link.'#';?>>Sign in</a>
        </li>
        <li class='<?php echo $hidden1; ?>'>
          <a class='dropdown-toggle' data-trigger='hover' data-toggle="dropdown" href="#"><?php echo $acc;?>
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="dropdown-header"> </li>
            <li><a href="accountsettings.php">Account settings</a></li>
            <li><a href="php/signout.php">Sign out</a></li>
          </ul>
        </li>
      </ul>
    </div>
    <!-- /.navbar-collapse -->
  </div>
  <!-- /.container -->
</nav>
<script type="text/javascript" src="js/navbar.js"></script>
