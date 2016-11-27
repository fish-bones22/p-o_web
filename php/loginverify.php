<?php
	session_start();
	ob_start();
	include 'connect_to_db.php';

	$email = '';
	$password = '';

	if (isset($_REQUEST["email"]))
    $email=$_REQUEST["email"];
  if (isset($_REQUEST["password"]))
    $password=$_REQUEST["password"];

  $query = "SELECT * FROM user WHERE email LIKE '".$email."' AND password LIKE '".$password."'";

  $result = $db->query($query);
  $numresults = $result->num_rows;
  $row = $result->fetch_assoc();
  $db->close();

  if ($numresults == 1) {
    $_SESSION['uname'] = $row['Fname'];
    $_SESSION['error_signin'] = false;
    $_SESSION['email'] = $email;
    header("Location:../index.php");
    if($row['Admin_Check'] == 'Yes'){
      $_SESSION['admin'] = 1;
      header("Location:../admin.php");
    }
    exit;
  } else {
  	$_SESSION['error_signin'] = true;
    header("Location:../index.php");
  	exit;
  }
 ?>
