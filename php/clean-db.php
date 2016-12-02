<?php
  if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
  }
  if (!$_SESSION['admin']) {
    header("Location: index.php");
    exit();
  }

  include 'connect_to_db.php';
  date_default_timezone_set('Asia/Manila');
  $date = strtotime(date("Y-m-d", strtotime("-1 day")));
  $date2 = strtotime(date("Y-m-d"));

  $query = "SELECT * FROM `reserve` WHERE `cancel`='No';";
  $result = $db->query($query);
  $numresults = $result->num_rows;

  for ($i = 0; $i < $numresults; $i++) {
    $row = $result->fetch_assoc();
    $timeverifier = strtotime($row['time_verifier']);
    $rDate = strtotime($row['rDate']);
    if (($timeverifier < $date) && ($row['status'] == 'No')) {
      $query2 = "UPDATE `reserve` SET `cancel`='Yes' WHERE `Reserve_Code`='".$row['Reserve_Code']."';";
      $result2 = $db->query($query2);
      if ($result2) echo "success";
      else echo "failed";
    }
    if ($rDate < $date2) {
      $query2 = "DELETE FROM `reserve` WHERE `Reserve_Code`='".$row['Reserve_Code']."';";
      $result2 = $db->query($query2);
      if ($result2) echo "success deleting";
      else echo "failed deleting";
    }
  }
  $db->close();
 ?>
