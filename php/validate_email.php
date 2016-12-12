<?php
  $isValid = false;
  $email = trim($_POST['email']);

  include 'connect_to_db.php';
  $query = "SELECT * FROM `user` WHERE `email`='".$email."';";
  $result = $db->query($query);
  $num = $result->num_rows;
  $db->close();

  if ($num == 0)
    $isValid = true;
  
  echo json_encode(array(
    'valid' => $isValid
  ));
?>