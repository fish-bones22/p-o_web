<?php
session_start();
include 'php/init_sessions.php';
include 'php/connect_to_db.php';

$query = "SELECT * FROM info";
$result = $db->query($query);
$numsult = $result->num_rows;
  if ($numsult == 1) {
    $row = $result->fetch_assoc();
  }
  $is_signed_in = false;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>P&amp;O Transportation Corporation</title>

  <!-- Bootstrap Core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Theme CSS -->
  <link href="css/style.css" rel="stylesheet">

  <!--bootstrapvalidator-->
  <link rel="stylesheet" href="vendor/bootstrap/css/bootstrapValidator.min.css">

  <!-- jQuery -->
  <script src="vendor/jquery/jquery.min.js"></script>


</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

  <!-- include navigation bar -->
  <?php include 'navbar.php'; ?>
  <!-- include login-signup popup -->
  <?php include 'login-signup.php'; ?>

  <?php
    if($is_signed_in)
      $reserve_btn_link = 'reserve.php';
    else
      $reserve_btn_link = '#';

    if(!isset($_SESSION['error_signin']))
      $_SESSION['error_signin'] = false;
    if(!isset($_SESSION['error_signup']))
      $_SESSION['error_signup'] = false;
  ?>
  <!-- Intro Header -->
  <header class="intro" id="reserve">
    <div class="intro-body">
      <div class="container">
        <div class="row intro-row">
          <div class="col-md-8 col-md-offset-2">
            <noscript><div class="alert alert-danger">Please enable JavaScript</div></noscript>
            <div class="serif brand-heading">P&amp;O</div>
            <div class="intro-text">TRANSPORT CORPORATION</div>
            <div class="reserve-btn-container" >
              <a type="button" id="reserve-btn-home" class="btn btn-default btn-lg" href=<?php echo $reserve_btn_link; ?>>Reserve now</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- About Section -->
  <section id="about" class="container content-section text-center about-container">
    <div class="row">
      <div class="col-lg-8 col-lg-offset-2">
        <h2>About P&amp;O</h2>
        <p>
        <?php echo
        "P&amp;O Transport Corporation is devoted in giving our passengers a safe and happy trip. Our business is divided into two entity; first, P&amp;O Transportation which is a sole propiertorship named to Edwin D. Chito and another is P&amp;O Transport Corp. which is registered as a Corporation. We are previously known as Barney Auto Lines founded by Mr. Guillermo Chito and now devided and managed by his children which is now known as BALGCO (managed by Mr. Barney Chito, eldest son), P&amp;O Transport System(managed by Mr. Edwin D. Chito, 3rd son) and BAL Company(managed by the whole family)";?>
        </p>
      </div>
    </div>
  </section>

  <!-- hidden inputs -->
  <input type="hidden" id="error-signin-input" value='<?php echo $_SESSION['error_signin']; ?>'></input>
  <input type="hidden" id="error-signup-input" value='<?php echo $_SESSION['error_signup']; ?>'></input>
  <input type="hidden" id="is-signedin-input" value='<?php echo $is_signed_in; ?>'></input>
  <?php
    $_SESSION['error_signin'] = 0;
    $_SESSION['error_signup'] = 0;
   ?>
  <section id="gallery-carousel" class="content-section text-center">
    <div class="container">
      <div class="col-lg-8 col-lg-offset-2">
        <h2>Gallery</h2>
      </div>
      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
          <li data-target="#myCarousel" data-slide-to="3"></li>
          <li data-target="#myCarousel" data-slide-to="4"></li>
          <li data-target="#myCarousel" data-slide-to="5"></li>
          <li data-target="#myCarousel" data-slide-to="6"></li>
          <li data-target="#myCarousel" data-slide-to="7"></li>
          <li data-target="#myCarousel" data-slide-to="8"></li>
          <li data-target="#myCarousel" data-slide-to="9"></li>
          <li data-target="#myCarousel" data-slide-to="10"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
          <div class="item active">
            <img class="fillwidth " src="img/carousel/carousel (1).jpg" alt="P&amp;O">
          </div>

          <div class="item">
            <img  class="fillwidth " src="img/carousel/carousel (2).jpg" alt="P&amp;O">
          </div>

          <div class="item">
            <img class="fillwidth " src="img/carousel/carousel (3).jpg" alt="P&amp;O">
          </div>

          <div class="item">
            <img  class="fillwidth " src="img/carousel/carousel (4).jpg" alt="P&amp;O">
          </div>

          <div class="item">
            <img  class="fillwidth " src="img/carousel/carousel (5).jpg" alt="P&amp;O">
          </div>

          <div class="item">
            <img  class="fillwidth " src="img/carousel/carousel (6).jpg" alt="P&amp;O">
          </div>

          <div class="item">
            <img  class="fillwidth " src="img/carousel/carousel (7).jpg" alt="P&amp;O">
          </div>

          <div class="item">
            <img  class="fillwidth " src="img/carousel/carousel (8).jpg" alt="P&amp;O">
          </div>

          <div class="item">
            <img  class="fillwidth " src="img/carousel/carousel (9).jpg" alt="P&amp;O">
          </div>

          <div class="item">
            <img  class="fillwidth " src="img/carousel/carousel (10).jpg" alt="P&amp;O">
          </div>
        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
  </section>

  <!-- Map section -->
  <section id="route" class="content-section text-center">
    <div class="container">
      <h2>Route</h2>
      <p>Route taken from Guinayangan terminal to Alabang terminal</p>
      <div id="map"></div>
    </div>
  </section>


    <!-- Contact Section -->
    <section id="contact" class="container content-section text-center">
      <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
          <h2>Contact us</h2>
          <p>
            Feel free to email us for more inquiries,
            or to provide some feedback and suggestions,
            or to just say hello!
          </p>
          <ul class="list-inline banner-social-buttons">
            <li>
              <a href="mailto:<?php echo $row['email'];?>" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-envelope"></span> <span class="network-name">eMail</span></a>
            </li>
            <li>
              <a href="https://<?php echo $row['fb_link'];?>" class="btn btn-default btn-lg"><i class="fa fa-facebook fa-fw"></i> <span class="network-name">Facebook</span></a>
            </li>
          </ul>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer>
      <div class="container text-center">
        <p>Copyright &copy; P&amp;O Transport Corporation 2016</p>
      </div>
    </footer>


    <!--bootstrapValidator-->
    <script src="vendor/bootstrap/js/bootstrapValidator.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <!--script src="vendor/jquery-easing/jquery.easing.min.js"></script-->
    <script src="js/navbar.js"></script>
    <script src="js/script.js"></script>
    <script src="js/index.js"></script>
    <!-- Google Maps API Key - Use your own API key to enable the map feature. More information on the Google Maps API can be found at https://developers.google.com/maps/ -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPPL8NcnlOqGev_9zwxpgDoDBKs_PsfB0&callback=initMap"></script>


  </body>

  </html>
