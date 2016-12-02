<?php
session_start();
include 'connect_to_db.php';

$bus_no = $_REQUEST['bus-number'];
$date = $_REQUEST['date'];
$status = 'No';
$email = $_SESSION['email'];
$dept_time = $_REQUEST['time'];
$seatplan = $_REQUEST['reserved-seats'];
$price = $_REQUEST['price'];
$route = $_REQUEST['route'];
$trip_code = $_REQUEST['trip-code'];
$trans_date = date('Y-m-d', time());


$query = "INSERT INTO `reserve` (Bus_No, rDate, status, email, DeptTime, route, seatplan, tPrice, Trip_Code, tDate)
          VALUES ('"."$bus_no"."', '"."$date"."', '"."$status"."', '"."$email"."', '"."$dept_time"."', '"."$route"."', '"."$seatplan"."', '"."$price"."', '"."$trip_code"."', '"."$trans_date"."');";

echo $query;
$result = $db->query($query);
$db->close();

if ($result) {
  $_SESSION['reserve_success'] = 1;
  echo "success";
} else {
  $_SESSION['reserve_success'] = 2;
  echo "failed";
}
//header("Location: ../reserve.php");
//exit();
 ?>
