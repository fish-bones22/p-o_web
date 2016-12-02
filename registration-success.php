<?php
  session_start();
  if (!isset($_SESSION['uname'])) {
    header("Location: index.php");
    exit();
  }
  if ($_SESSION['uname'] == '') {
    header("Location: index.php");
    exit();
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Registration success</title>

  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <link href="css/registration-success.css" rel="stylesheet">
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  </style>
</head>
<body>
<?php include 'navbar.php'; ?>
  <div class="container success-text">
    <div class="jumbotron" align="center">
      <h2 class="reg-success"><span class="glyphicon glyphicon-ok"> Registration<br>Successful</h2>
      <p class="details">Your account has been successfully registered</p>
      <a href="index.php">Back to home</a>
    </div>
  </div>
</body>
</html>
