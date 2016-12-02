<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <title>Admin Page</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

  <body>

<?php
  include 'connect_to_db.php';
  $query = "SELECT `password` FROM `user` WHERE `email`='".$_SESSION['email']."';";
  $result = $db->query($query);
  $pw = $result->fetch_assoc();
  var_dump($_REQUEST['pwd-verification-input']);
  var_dump($pw);
  if ($_REQUEST['pwd-verification-input'] == $pw["password"]) {
    $query = "DELETE FROM `reserve` WHERE `Reserve_Code`=".$_REQUEST['reserve_code_to_cancel'].";";
    $result = $db->query($query);
    echo $query;
    $db->close();
    if ($result) {
      echo " succes";
      $_SESSION['booking_cancel_success'] = 1;
    } else {
      echo " failed";
      $_SESSION['booking_cancel_success'] = 2;
    }
    header("Location:../booking-details.php");
    exit();
  } else {
    $error_message = "Wrong password";
    $_SESSION['booking_cancel_success'] = 2;
  }
 ?>
    <div class="alert alert-danger" role="alert"><?php echo $error_message?>
      <a href="../booking-details.php">Go back</a>
    </div>
  </body>
</html>
