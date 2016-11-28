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

  $query = "SELECT * FROM user WHERE email LIKE '".$_SESSION['email']."'";

  $result = $db->query($query);
  $numresults = $result->num_rows;
  $row = $result->fetch_assoc();

  $fname = $row['Fname'];
  $lname = $row['Lname'];

  $query1 = "SELECT * FROM info";
  $result1 = $db->query($query1);
  $numresult1 = $result->num_rows;
  $row1 = $result1->fetch_assoc();
  $db->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Summary</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/summary.css">
  <script src="vendor/jquery/jquery.min.js"></script>
</head>
<body>
  <?php include 'navbar.php';?>
  <form id="summary-form" method="POST" class="form-horizontal" action="php/confirm_reservation.php">
    <div class="container summary-container">

      <div class="col-md-7" id="screen-details">
        <div class="form-group">
          <h3>P&amp;O Transport Corp.</h3>
          <p><strong>Summary of transaction</strong></p>
        </div>
        <div class="details-container">
          <div class="container-fluid">
            <div class="col-sm-12"><label for="name">Name:&nbsp;</label><?php echo $fname.' '.$lname?></div>
            <input type="hidden" value=<?php echo $fname?> id="fname">
            <input type="hidden" value=<?php echo $lname?> id="lname">
          </div>
          <div class="container-fluid">
            <div class="col-sm-12"><label for="trip-from">From:&nbsp;</label><?php echo $_REQUEST['trip-from']?></div>
            <div class="col-sm-12"><label for="trip-to">Destination:&nbsp;</label><?php echo $_REQUEST['trip-to']?></div>
            <input type="hidden" value="<?php echo $_REQUEST['trip-from']?>" id="trip-from">
            <input type="hidden" value="<?php echo $_REQUEST['trip-to']?>" id="trip-to">
            <input type="hidden" name="route" value="<?php echo $_REQUEST['trip-from']." to ".$_REQUEST['trip-to'];?>" id="route">
          </div>
          <div class="container-fluid">
            <div class="col-sm-12"><label for="departure-date">Date:&nbsp;</label><?php echo $_REQUEST['departure-date']?></div>
            <div class="col-sm-12"><label for="departure-time">Departure time:&nbsp;</label><?php echo $_REQUEST['departure-time']?></div>
            <input type="hidden" name="date" value=<?php echo $_REQUEST['departure-date']?> id="departure-date">
            <input type="hidden" name="time" value=<?php echo $_REQUEST['departure-time']?> id="departure-time">
          </div>
          <div class="container-fluid">
            <div class="col-sm-12"><label for="bus-type">Bus Details:&nbsp;</label>
              <div class="container-fluid">
                <?php echo $_REQUEST['bus-number'].', '.$_REQUEST['bus-type'].', '.$_REQUEST['total-seats'].' seats'?>
                <input type="hidden" name="bus-type" value=<?php echo $_REQUEST['bus-type']?> id="bus-type">
                <input type="hidden" name="bus-number" value=<?php echo $_REQUEST['bus-number']?> id="bus-number">
                <input type="hidden" value=<?php echo $_REQUEST['total-seats']?> id="total-seats">
                <input type="hidden" name="reserved-seats" value=<?php echo $_REQUEST['reserved-seats-after']?> id="reserved-seats">
                <input type="hidden" name="trip-code" value=<?php echo $_REQUEST['trip-code']?> id="trip-code"></input>
              </div>
            </div>
          </div>

          <div class="container-fluid">
            <div class="col-sm-12"><label for="price">Price:</label><?php echo " P".intval($_REQUEST['price-input'])?></div>
            <input type="hidden" name="price" value=<?php echo $_REQUEST['price-input']?> id="price" name="price">
          </div>
        </div>

        <div class="container-fluid form-group">
          <label for="smart">Smart Padala: <?php echo $row1['smart_number'];?></label><br>
          <label for="smart">Send to mobile number: <?php echo $row1['mobile_number'];?></label>
        </div>

        <input type="hidden" value="" id="smart">
        <input type="hidden" value="" id="mobile">
      </div>
      <div class="col-md-5">
        <div class="seatplan-container" id="screen-seatplan">
          <!-- Data needed in reserve.js -->
          <input class="reserved-seats" type="hidden" value=""></input>
          <input class="reserved-seats-after" type="hidden"
                 value="">
          </input>
          <!-- Display "Front" text -->
          <div class="front-rear-info"><p>Front</p></div>
          <!-- Seat plan. Elements controlled by JS -->
          <div class="seatplan"><div class="bus-row"><div class="seat"></div></div></div>
          <!-- Display "Rear" text -->
          <div class="front-rear-info"><p>Rear</p></div>
          <!--button class="btn btn-export">Export</button-->
        </div>
      </div>
      <div class="form-inline btn-container" data-html2canvas-ignore="true">
        <a class="btn btn-default btn-blk" role="button" href="reserve.php">Back</a>
        <button type="submit" class="btn btn-default btn-blk" id="confirm-reservation-btn">Confirm</button>
      </div>

    </div>
  </form>

</body>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/jspdf/jspdf.min.js"></script>
<script src="vendor/jspdf/html2canvas.js"></script>
<script src="js/summary.js"></script>
</html>
