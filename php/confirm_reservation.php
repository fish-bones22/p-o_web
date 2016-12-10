<?php
session_start();
if (!isset($_SESSION['uname'])) {
  header("Location: ../index.php");
  exit();
}
if ($_SESSION['uname'] == '') {
  header("Location: ../index.php");
  exit();
}
include 'connect_to_db.php';

$bus_no = $_REQUEST['bus-number'];
$date = $_REQUEST['date'];
$status = 'No';
$cancel = 'No';
$email = $_SESSION['email'];
$dept_time = $_REQUEST['time'];
$seatplan = $_REQUEST['reserved-seats'];
$passenger = $_REQUEST['passenger-types'];
$price = $_REQUEST['price'];
$route = $_REQUEST['route'];
$trip_code = $_REQUEST['trip-code'];
$trans_date = date('Y-m-d', time());
$reservation_num = $_REQUEST['reservation_num'];


$query = "INSERT INTO `reserve` (Bus_No, rDate, status, cancel, email, DeptTime, route, seatplan, passenger, tPrice, Trip_Code, tDate, reservation_num)
          VALUES ('".$bus_no."', '".$date."', '".$status."', '".$cancel."', '".$email."', '".$dept_time."', '".$route."', '".$seatplan."', '".$passenger."', '".$price."', '".$trip_code."', '".$trans_date."', '".$reservation_num."');";

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
header("Location: ../reserve.php");
exit();
 ?>
