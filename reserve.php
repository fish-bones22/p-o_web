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

  date_default_timezone_set('Asia/Manila');
  $date = date('Y-m-d', time());
  $tomorrow = date("Y-m-d", strtotime("+3 day"));
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reserve</title>

  <!-- Bootstrap Core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Theme CSS -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/reserve.css" rel="stylesheet">
  <script src="vendor/jquery/jquery.min.js"></script>
  <script>
    // Fetch from database and convert to JSON
    // With specific structure.

    var airconObj = {
      Alabang: {
      <?php
        $query = "SELECT * FROM `trip3`
                  INNER JOIN `bus2` ON `trip3`.`Bus_No`=`bus2`.`Bus_No`
                  WHERE `Bus_Type`='Aircon'
                  ORDER BY `Dept_B`;";
        $result = $db->query($query);
        $numresult = $result->num_rows;
        for ($i = 0; $i < $numresult; $i++) {
          $row = $result->fetch_assoc();
          echo "\"".$row['Trip_Code']."\": {";
            echo "depTime: \"".$row['Dept_B']."\",";
            echo "busNo: \"".$row['Bus_No']."\",";
            echo  "totalSeats: \"".$row['Seats']."\"";
          echo "}";
          if ($i != $numresult-1)  echo", ";
        }
       ?>
      },
      Guinayangan: {
      <?php
        $query = "SELECT * FROM `trip3`
                  INNER JOIN `bus2` ON `trip3`.`Bus_No`=`bus2`.`Bus_No`
                  WHERE `Bus_Type`='Aircon'
                  ORDER BY `Dept_A`;";
        $result = $db->query($query);
        $numresult = $result->num_rows;
        for ($i = 0; $i < $numresult; $i++) {
          $row = $result->fetch_assoc();
          echo "\"".$row['Trip_Code']."\": {";
            echo "depTime: \"".$row['Dept_A']."\",";
            echo "busNo: \"".$row['Bus_No']."\",";
            echo  "totalSeats: \"".$row['Seats']."\"";
          echo "}";
          if ($i != $numresult-1)  echo", ";
        }
       ?>
      }
    };
    var ordinaryObj = {
      Alabang: {
      <?php
        $query = "SELECT * FROM `trip3`
                  INNER JOIN `bus2` ON `trip3`.`Bus_No`=`bus2`.`Bus_No`
                  WHERE `Bus_Type`='Ordinary'
                  ORDER BY `Dept_B`;";
        $result = $db->query($query);
        $numresult = $result->num_rows;
        for ($i = 0; $i < $numresult; $i++) {
          $row = $result->fetch_assoc();
          echo "\"".$row['Trip_Code']."\": {";
            echo  "depTime: \"".$row['Dept_B']."\",";
            echo  "busNo: \"".$row['Bus_No']."\",";
            echo  "totalSeats: \"".$row['Seats']."\"";
          echo "}";
          if ($i != $numresult-1)  echo", ";
        }
       ?>
      },
      Guinayangan: {
        <?php
          $query = "SELECT * FROM `trip3`
                    INNER JOIN `bus2` ON `trip3`.`Bus_No`=`bus2`.`Bus_No`
                    WHERE `Bus_Type`='Ordinary'
                    ORDER BY `Dept_A`;";
          $result = $db->query($query);
          $numresult = $result->num_rows;
          for ($i = 0; $i < $numresult; $i++) {
            $row = $result->fetch_assoc();
            echo "\"".$row['Trip_Code']."\": {";
            echo    "depTime: \"".$row['Dept_A']."\",";
            echo    "busNo: \"".$row['Bus_No']."\",";
            echo    "totalSeats: \"".$row['Seats']."\"";
            echo "}";
            if ($i != $numresult-1)  echo", ";
          }
         ?>
      }
    };
    var cubaoCustomSelectObj = {
      <?php
      $query = "SELECT * FROM `trip3`
                INNER JOIN `bus2` ON `trip3`.`Bus_No`=`bus2`.`Bus_No`
                WHERE `check_cubao`='Yes'
                ORDER BY `Dept_A`;";
      $result = $db->query($query);
      $numresult = $result->num_rows;
      for ($i = 0; $i < $numresult; $i++) {
        $row = $result->fetch_assoc();
        echo "\"".$row['Trip_Code']."\": {";
        echo    "depTime: \"".$row['Dept_A']."\",";
        echo    "busNo: \"".$row['Bus_No']."\",";
        echo    "totalSeats: \"".$row['Seats']."\",";
        echo "}";
        if ($i != $numresult-1)  echo", ";
      }
       ?>
    };
    <?php
    $query = "SELECT * FROM prices";
    $result = $db->query($query);
    $numresult = $result->num_rows;
    ?>
    var priceArray = [
      <?php
      for ($i=0; $i < $numresult; $i++) {
        $row = $result->fetch_assoc();
        echo "['".$row['From_G']."','".$row['From_A']."','".$row['O_Price']."','".$row['A_Price']."']";
        if ($i != $numresult-1)  echo", ";
      }
      ?>
    ];
    <?php
      $query = "SELECT * FROM `reserve`
                INNER JOIN `trip3` ON `trip3`.`Trip_Code`=`reserve`.`Trip_Code`
                INNER JOIN `bus2` ON `trip3`.`Bus_No`=`bus2`.`Bus_No`";
      $result = $db->query($query);
      $numresult = $result->num_rows;
    ?>
    var seatPlanArr = [
      <?php
        for ($i=0; $i < $numresult; $i++) {
          $row = $result->fetch_assoc();
          echo "{";
          echo  "busNo: \"".$row['Bus_No']."\",";
          echo  "depTime: \"".$row['DeptTime']."\",";
          echo  "date: \"".$row['rDate']."\",";
          echo  "seatplan: \"".$row['seatplan']."\",";
          echo  "totalSeats: \"".$row['Seats']."\",";
          echo  "tripCode: \"".$row['Trip_Code']."\"";
          echo "}";
          if ($i != $numresult-1)  echo", ";
        }
      ?>
    ];
    var mainObject = {
      Aircon: airconObj,
      Ordinary: ordinaryObj
    };
  </script>
</head>
<body>
  <!-- Navbar -->
  <?php include 'navbar.php' ?>
  <form method="post" action="summary.php" id="reserve-form">
    <div class="container main-reserve-container">
      <?php
      if ($_SESSION['reserve_success'] == 1)
        echo "<div class=\"alert alert-success\">Reservation complete<span class=\"close\" data-dismiss=\"alert\">&times;</span></div>";
      else if ($_SESSION['reserve_success'] == 2)
        echo "<div class=\"alert alert-danger\">Reservation failed, please try again<span class=\"close\" data-dismiss=\"alert\">&times;</span></div>";
      $_SESSION['reserve_success'] = 0;
      ?>
      <!-- Data details -->
      <div class="col-md-7">
        <div class="heading">
          <h1>Reservation</h1>
        </div>
        <div class="details-form-container">
            <!--Bus type radio-->
            <div class="form-group">
              <label class="form-label">Bus type</label>
              <div class="custom-radio bus-type-radio">
                <input type="radio" name="bus-type" value="Aircon" required> Air-conditioned </input>
                <input type="radio" name="bus-type" value="Ordinary" required checked> Ordinary </input>
              </div>
            </div>
            <!--selecting terminal-->
            <div class="form-group">
              <label class="form-label">Trip information</label>
              <div class="container-fluid">
                <div class="col-sm-6">
                  <label class="form-label">From</label>
                  <select id="trip-from-select" class="form-control" name="trip-from">
                    <!-- Town names-->
                    <option value="Alabang">Alabang</option>
                    <option value="Guinayangan">Guinayangan</option>
                  </select>
                </div>
              <!--selecting destination-->
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="form-label">To</label>
                    <select id="trip-to-select" class="form-control" name="trip-to">
                    </select>
                  </div>
                </div>
              </div>

            <!--choose date-->
              <div class="container-fluid">
                <div class="col-sm-6">
                  <label class="form-label">Date</label>
                  <input type="date" class="form-control date-input" min='<?php echo $tomorrow;?>' name="departure-date" value='<?php echo $tomorrow;?>'>
                </div>
              <!--time of departure-->
                <div class="col-sm-6">
                  <label class="form-label">Departure time</label>
                  <select id="departure-time-select" class="form-control" name="departure-time">
                  </select>
                </div>
              </div>
            </div>
            <!--bus no.-->
            <!-- Use PHP to add options base on values above -->
            <div class="form-group">
              <label class="form-label">Available buses</label>
              <select id="bus-select" class="form-control" name="bus-number">

              </select>
            </div>
            <div class="container-fluid hidden" id="price-container">
              <div class="col-sm-12"><label>Price:&nbsp;</label><p class="price-p"></p></div>
              <input type="hidden" name="price-input" id="price-input"></p>
            </div>
        </div>
      </div>

      <div class="col-md-5">
        <div class="form-inline"><p>Select seat/s you prefer:</p></div>
        <div class="alert alert-danger" id="empty-selection-alert" hidden>Please select a seat<span class="close">&times;</span></div>
        <div class="seatplan-container">
          <!-- Data needed in reserve.js -->
          <input class="total-seats" name="total-seats" type="hidden" value=""></input>
          <input class="reserved-seats" type="hidden" value=""></input>
          <input class="reserved-seats-after" name="reserved-seats-after" type="hidden" value=""></input>
          <input class="trip-code" name="trip-code" type="hidden" value=""></input>
          <!-- Display "Front" text -->
          <div class="front-rear-info"><p>Front</p></div>
          <!-- Seat plan. Elements controlled by JS -->
          <div class="seatplan"><div class="bus-row"><div class="seat"></div></div></div>
          <!-- Display "Rear" text -->
          <div class="front-rear-info"><p>Rear</p></div>
          <!-- Display Seat plan informations text -->
          <div class="seat-info container-fluid">
            <div class="free-reserved-container col-sm-6">
              <div class="free-seats-info">Free seats:</div>
              <div class="reserved-seats-info">Reserved seats:</div>
            </div>
            <div class="selected-seats-info col-sm-6">Selected seats:</div>
          </div>
          <!--button class="btn btn-export">Export</button-->
        </div>
        <div id="reset">Reset</div>
      </div>
    </div>
    <div class="map-link">
      <label><a href="#" >Show map</a></label>
    </div>

    <div class="reserve-btn-container hidden">
      <button type="submit" id="reserve-btn" name="reserve-button" class="btn btn-default btn-block btn-lg reserve-btn">Reserve now</button>
    </div>
  </form>
  <div class="gmap-container">
    <div id="map-outside"></div>
    <div id="map"></div>
    <div class="close-button"><span class="glyphicon glyphicon-remove"></span></div>
  </div>

  <!-- Bootstrap Core JavaScript -->
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- MY API key! papalitan pa natin ito -->
  <!-- Google Maps API Key - Use your own API key to enable the map feature. More information on the Google Maps API can be found at https://developers.google.com/maps/ -->
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPPL8NcnlOqGev_9zwxpgDoDBKs_PsfB0&callback=initMap"></script>

  <script src="js/map.js"></script>

  <script src="js/reserve.js"></script>
  <!-- Theme JavaScript -->
  <script src="js/script.js"></script>

</body>
</html>
