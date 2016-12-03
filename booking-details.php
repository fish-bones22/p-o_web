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

  include 'php/connect_to_db.php';
  $fname = '';
  $lname = '';

  if (isset($_REQUEST["fname"]))
    $fname=$_REQUEST["fname"];
  if (isset($_REQUEST["lname"]))
    $lname=$_REQUEST["fname"];

  $query = "SELECT * FROM `user` WHERE `email` LIKE '".$_SESSION['email']."';";

  $result = $db->query($query);
  $numresults = $result->num_rows;
  $row = $result->fetch_assoc();

  $email = $_SESSION['email'];
  $password = $row['password'];
  $fname = $row['Fname'];
  $lname = $row['Lname'];
  $mobile = $row['phone'];
  $address = $row['Address'];
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Booking details</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/booking.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="vendor/jquery/jquery.min.js"></script>
</head>

<body data-spy="scroll" data-target="#myScrollspy" data-offset="20">
  <?php include 'navbar.php'; ?>
  <div class="booking-details-container">
    <h2>Booking details</h2>
    <!-- Alert message -->
    <?php
    if ($_SESSION['booking_cancel_success'] == 1) {
      echo
      "<div class=\"alert alert-success\" role=\"alert\">Reservation canceled
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
      </div>";
    } else if ($_SESSION['booking_cancel_success'] == 2) {
      echo "<div class=\"alert alert-danger\" role=\"alert\">Failed cancelation
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
      </div>";
    }
    $_SESSION['booking_cancel_success'] = 0;
    ?>

    <div class="current-transactions-container">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <h4><strong>Current Transactions</strong></h4>
        </div>
        <div class="panel-body">
          <table class="table">
            <thead>
              <tr>
                <th>Reservation Number</th>
                <th>Date</th>
                <th>Price</th>
                <th>Reserved seat/s</th>
                <th>Route</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
                $query = "SELECT * FROM `reserve` WHERE `email`='".$_SESSION['email']."'
                          AND `cancel`='No';";
                $result = $db->query($query);
                $numresults = $result->num_rows;
                for ($i = 0; $i < $numresults; $i++) {
                  $row = $result->fetch_assoc();
                  $sp = '';
                  if (strlen($row['seatplan']) > 18)
                    $sp = substr($row['seatplan'], 0, 10)."...";
                  else $sp = $row['seatplan'];
                  echo
                  "<tr id='".$row['Reserve_Code']."'>
                      <td>".$row['reservation_num']."</td>
                      <td>".$row['rDate']."</td>
                      <td>".$row['tPrice']."</td>
                      <td>
                        <div data-toggle=\"popover\" placement=\"top\" data-content=\"".$row['seatplan']."\">".$sp."</div>
                      </td>
                      <td>".$row['route']."</td>";
                  if ($row['status'] === "Yes") {
                    echo "<td><div><span class=\"glyphicon glyphicon-ok\"></span>&nbsp;Paid</div></td>";
                  } else {
                    echo
                    "<td>
                      Pending<br><button type=\"button\" class=\"btn btn-blk btn-default cancel-transaction-btn\" data-toggle=\"modal\" data-target=\"#modal-confirm\">Cancel</button>
                    </td>";
                  }
                  echo "</tr>";
                }
               ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="transactions-history-container">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <h4><strong>Record of transactions</strong></h4>
        </div>
        <div class="panel-body">
          <table class="table">
            <thead>
              <tr>
                <th>Transaction Number</th>
                <th>Reservation number</th>
                <th>Date</th>
                <th>Price</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $query = "SELECT * FROM `transaction` WHERE `email` LIKE '".$_SESSION['email']."';";
                $result = $db->query($query);
                $numresults = $result->num_rows;
                for ($i = 0; $i < $numresults; $i++) {
                  $row = $result->fetch_assoc();
                  echo
                  "<tr>
                    <td>".$row['Transaction_Code']."</td>
                    <td>".$row['reservation_num']."</td>
                    <td>".$row['rdate']."</td>
                    <td>".$row['tPrice']."</td>
                  </tr>";
                }
                $db->close();
               ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Password verification modal -->
  <div class="modal fade" id="modal-confirm" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" align="center">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4>Please enter password</h4>
        </div>
        <form id="inputform" action="php/cancel-booking.php" method="post">
          <div class="modal-body form-group form-inline" align="center">
            <label for="pwd">Password: </label>
            <input type="password" name="pwd-verification-input" class="form-control" id="modal-password-input">
            <input type="hidden" name="reserve_code_to_cancel" id="reserve_code_to_cancel">
          </div>
          <div class="modal-footer">
            <button type=submit class="btn btn-default" id="modal-yes-button">Confirm</button>
            <a class="btn btn-default" id="modal-no-button" data-dismiss="modal" aria-hidden="true" role="button">No</a>
          </div>
        </form>
      </div>
    </div>
  </div>

</body>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="js/booking.js"></script>
</html>
