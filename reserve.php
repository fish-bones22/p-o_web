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

  function militaryToStandardClock($milTime) {

  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Reserve</title>

  <!-- Bootstrap Core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Theme CSS -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/reserve.css" rel="stylesheet">
  <script src="vendor/jquery/jquery.min.js"></script>
  <script>
    // Instead na PHP array ay JS array
    var busArray = [
      <?php
        $querydata = "SELECT * FROM `trip3` INNER JOIN `bus2` ON `trip3`.`Bus_No`=`bus2`.`Bus_No`";
        $rest = $db->query($querydata);
        $numresult1 = $rest->num_rows;

        for ($i=0; $i < $numresult1; $i++) {
          $row1 = $rest->fetch_assoc();
          echo "['".$row1['Bus_No']."','".$row1['Bus_Type']."','".$row1['Seats']."','".$row1['Dept_A']."','".$row1['Dept_B']."','".$row1['Trip_Code']."'],";
        }
       ?>
    ];
    var priceArray = [
      <?php
        $query = "SELECT * FROM prices";
        $result = $db->query($query);
        $numresult = $result->num_rows;

        for ($i=0; $i < $numresult; $i++) {
          $row = $result->fetch_assoc();
          echo "['".$row['From_G']."','".$row['From_A']."','".$row['O_Price']."','".$row['A_Price']."'],";
        }
       ?>
    ];
    var seatPlanArray = [
      <?php
        $query = "SELECT * FROM reserve";
        $result = $db->query($query);
        $numresult = $result->num_rows;

        for ($i=0; $i < $numresult; $i++) {
          $row = $result->fetch_assoc();
          echo "['".$row['Bus_No']."','".$row['rDate']."','".$row['DeptTime']."','".$row['status']."','".$row['seatplan']."'],";
        }
      ?>
    ];

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
                    <?php
                      $querygtrip = "SELECT * FROM `prices`";
                      $result = $db->query($querygtrip);
                      $numresults = $result->num_rows;
                      for ($i=0; $i < $numresults; $i++) {
                        $row = $result->fetch_assoc();
                          if ($row != "") {
                            // ETO KAPAG GALING ALABANG
                            // Sam: Pinagsama ko ng select tapos yung
                            // option nalang ang mahihide depende sa nakaselect sa taas
                            echo "<option class=\"trip-to-option-guinayangan\" value=\"".$row['From_G']."\">".$row['From_G']."</option>";
                            //DITO NAMAN KAPAG GALING ALABANG
                            //MAY BLANKONG ISA DITO KASI MAY KALINYA PANG NULL YUNG SA CUBAO
                            echo "<option class=\"trip-to-option-alabang\" value=\"".$row['From_A']."\">".$row['From_A']."</option>";
                          }
                      }
                    ?>
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
                  <?php
                    $querydepta = "SELECT * FROM `trip3` INNER JOIN `bus2` ON `trip3`.`Bus_No`=`bus2`.`Bus_No` ORDER BY `Dept_A`";
                    $result = $db->query($querydepta);
                    $numresults = $result->num_rows;
                    $cubao = "";
                    for ($i=0; $i < $numresults; $i++) {
                      $row = $result->fetch_assoc();
                      if ($row['check_cubao'] === 'Yes')
                        $cubao = "cubao";
                      if ($row != "") {
                        // Aircon
                        if ($row['Bus_Type'] == 'Aircon') {
                          // Kung galing Guinayangan
                          echo "<option class=\"departure-time-option-guinayangan-a ".$cubao."\" value=\"".$row['Dept_A']."\">".date("g:i a", strtotime($row['Dept_A']))."</option>";
                          // Kung galing Alabang
                          echo "<option class=\"departure-time-option-alabang-a\" value=\"".$row['Dept_B']."\">".date("g:i a", strtotime($row['Dept_B']))."</option>";
                        // Ordinary
                        } else {
                          // Kung galing Guinayangan
                          echo "<option class=\"departure-time-option-guinayangan-b\" value=\"".$row['Dept_A']."\">".date("g:i a", strtotime($row['Dept_A']))."</option>";
                          // Kung galing Alabang
                          echo "<option class=\"departure-time-option-alabang-b\" value=\"".$row['Dept_B']."\">".date("g:i a", strtotime($row['Dept_B']))."</option>";
                        }
                      }
                      $previousValA = $row['Dept_A'];
                      $previousValB = $row['Dept_B'];
                    }
                    $db->close();
                    ?>
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
            <div class="container-fluid">
              <div class="col-sm-12"><label>Price:&nbsp;</label><p class="price-p"></p></div>
              <input type="hidden" name="price-input" id="price-input"></p>
            </div>
        </div>
      </div>

      <div class="col-md-5">
        <div><p>Select seat/s you prefer:</p></div>
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
      </div>
    </div>
    <div class="map-link">
      <label><a href="#" >Show map</a></label>
    </div>

    <div class="reserve-btn-container">
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
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyARW569S54S9o-8ueRlzJ5rRrg0gE26sWY&callback=initMap"></script>

  <script src="js/map.js"></script>

  <script src="js/reserve.js"></script>
  <!-- Theme JavaScript -->
  <script src="js/script.js"></script>

</body>
</html>
