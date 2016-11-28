<?php
$fn = $_REQUEST['Fname'];
$ln = $_REQUEST['Lname'];
$pw = $_REQUEST['Password1'];
$email = $_REQUEST['email'];
$phone = $_REQUEST['Phone'];
$admin = "No";
$address = $_REQUEST['address'];

if (!get_magic_quotes_gpc()) {
  $fn = addslashes($fn);
  $ln = addslashes($ln);
  $pw = addslashes($pw);
  $email = addslashes($email);
  $phone = addslashes($phone);
}

include 'connect_to_db.php';

$reg = "INSERT INTO `user` values ('".$fn."', '".$ln."', '".$email."', '".$pw."', '".$phone."', '".$admin."', '".$address."');";

$reg_result = $db->query($reg);
$db->close();

if ($reg_result) {
  echo 'success';
  $_SESSION['error_signup'] = false;
  header("Location:../registration-success.php");
  exit;
} else {
  echo $reg;
  echo 'failed';
  $_SESSION['error_signup'] = true;
  header("Location:../index.php");
  exit;
}

?>
