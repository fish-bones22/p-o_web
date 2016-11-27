<?php
  session_start();
  include 'connect_to_db.php';

  $email_new = $_POST['email'];
  $email_old = $_SESSION['email'];
  $password = $_POST['Password'];
  $fname = $_POST['Fname'];
  $lname = $_POST['Lname'];
  $mobile = $_POST['Phone'];
  $address = $_POST['Address'];

  $query = "UPDATE user
            SET Fname='$fname', Lname='$lname', email='$email_new', password='$password', phone='$mobile', Address='$address'
            WHERE email='$email_old'";
  echo $query;
  $result = $db->query($query);
  $db->close();

  if ($result) {
    $_SESSION['email'] = $email_new;
    $_SESSION['update_success'] = 1;
    $_SESSION['uname'] = $fname;
    echo "success";
    header("Location: ../accountsettings.php");
    exit();
  } else {
    $_SESSION['email'] = $email_old;
    $_SESSION['update_success'] = 2;
    echo "failed";
    header("Location: ../accountsettings.php");
    exit();
  }
?>
