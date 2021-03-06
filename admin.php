<?php
  session_start();
  if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
  }
  if (!$_SESSION['admin']) {
    header("Location: index.php");
    exit();
  }

  include 'php/clean-db.php';
  include 'php/connect_to_db.php';
  $querydisp = "SELECT * FROM info";
  $result = $db->query($querydisp);
  $numresults = $result->num_rows;
  $row = $result->fetch_assoc();

  $reserve_number = array('R162511AB', 'R162711AB');
  $client_name = array('EJ Mindanao', 'JD Reyes');
  $date = array('2016/11/25', '2016/11/27');
  $price = array('250', '300');
  $client_mobile = array('09183289654', '09456323439');
  $payment_status = array(false, false);

  $smart_number = $row['smart_number'];
  $mobile_number = $row['mobile_number'];

  $transaction_number = array('TR161811AB', 'TR161211AB');
  $trans_date = array('2016/11/18', '2016/11/12');
  $trans_client_name = array('EJ Mindanao', 'Sam Quinto');
  $trans_price = array('25', '30');

  $about = $row['About'];
  $fb_link = $row['fb_link'];
  $email = $row['email'];

  # Kung galing sa save-admin-settings.php, at successful ang pag eedit ,
  # magiging 1 ang value nito. Kapag hindi successful, 3.
  # Kung sa ibang page galing, 0;
  $edit_success = $_SESSION['admin_edit_success'];

  $date_today = date('Y-m-d');
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin Page</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/adminpage.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="vendor/jquery/jquery.min.js"></script>
</head>

<body data-spy="scroll" data-target="#myScrollspy" data-offset="20">

  <?php include 'navbar.php'; ?>

  <div class="admin-page-container">

    <!-- Alert -->
    <div class="col-sm-offset-2">
      <?php
      if ($_SESSION['admin_edit_success'] == 1) {
        echo
        "<div class=\"alert alert-success\" role=\"alert\">Edit successful
          <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
        </div>";
      } elseif ($_SESSION['admin_edit_success'] == 2) {
        echo "<div class=\"alert alert-danger\" role=\"alert\">Edit failed
          <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
        </div>";
      }
      $_SESSION['admin_edit_success'] = 0;
      ?>
    </div>
    <nav class="col-sm-3" id="myScrollspy">
      <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="#reservation-list">Reservation list</a></li>
        <li><a href="#trip-settings">Trip Settings</a></li>
        <li><a href="#payment-settings">Payment Details</a></li>
        <li><a href="#transaction-log">Transaction log</a></li>
        <li><a href="#front-page-settings">Front page settings</a></li>
      </ul>
    </nav>

    <div class="col-sm-offset-2">
      <div id="reservation-list" class="setting-container col-md-11">
        <div class="panel panel-info">
          <div class="panel-heading ">
            <h4><strong>Reservation List</strong></h4>
            <div id="filter-container" class="container-fluid">
              <div class="row">
                <label>Filter by:</label>
              </div>
              <?php
              $querydis = "SELECT * FROM `reserve`
                           INNER JOIN `user` ON `reserve`.`email`=`user`.`email`
                           INNER JOIN `trip3` ON `reserve`.`Trip_Code`=`trip3`.`Trip_Code`
                           INNER JOIN `bus2` ON `reserve`.`Bus_No`=`bus2`.`Bus_No`";
              ?>
              <div class="row">
                <div class="col-lg-3">
                  <input type="checkbox" class="cb-filter" id="cb_payment_status" value="" >
                  <label class="form-label">Payment status</label>
                  <select class="form-control filter-select" id="select_filter_payment" disabled>
                    <option value="Yes">Paid</option>
                    <option value="No">Pending confirmation</option>
                    <option value="Unsettled">Unsettled</option>
                  </select>
                </div>
                <div class="col-lg-2">
                  <input type="checkbox" class="cb-filter" id="cb_terminal" value="" >
                  <label class="form-label">Terminal</label>
                  <select class="form-control filter-select" id="select_filter_terminal" disabled>
                    <option value="Guinayangan">Guinayangan</option>
                    <option value="Alabang">Alabang</option>
                  </select>
                </div>
                <div class="col-lg-2">
                  <input type="checkbox" class="cb-filter" id="cb_bus_number" value="" >
                  <label class="form-label">Bus number</label>
                  <select class="form-control filter-select" id="select_filter_bus_number" disabled>
                    <?php
                      $resquery = $db->query($querydis);
                      $numsults = $resquery->num_rows;
                      $tempArr = array();
                      for ($i = 0; $i < $numsults; $i++) {
                        $row = $resquery->fetch_assoc();
                        if (!(in_array($row['Bus_No'], $tempArr))) {
                          echo
                          "<option value=\"".$row['Bus_No']."\">".$row['Bus_No']."</option>";
                          array_push($tempArr, $row['Bus_No']);
                        }
                      }
                     ?>
                  </select>
                </div>
                <div class="col-lg-2">
                  <input type="checkbox" class="cb-filter" id="cb-date" value="" >
                  <label class="form-label">Date</label>
                  <input type="date" class="form-control filter-select" id="select_filter_date" value="<?php echo $date_today?>" disabled>
                </div>
                <div class="col-lg-2">
                  <input type="checkbox" class="cb-filter" id="cb_time" value="" >
                  <label class="form-label">Time</label>
                  <select class="form-control filter-select" id="select_filter_time" disabled>
                    <?php
                      $resquery = $db->query($querydis);
                      $numsults = $resquery->num_rows;
                      $tempArr = array();
                      for ($i = 0; $i < $numsults; $i++) {
                        $row = $resquery->fetch_assoc();
                        if (!(in_array($row['DeptTime'], $tempArr))) {
                          echo
                          "<option value=\"".strtotime($row['DeptTime'])."\">".$row['DeptTime']."</option>";
                          array_push($tempArr, $row['DeptTime']);
                        }
                      }
                     ?>
                  </select>
                </div>
                <div class="col-lg-1">
                  <button class="close reset-btn">&times;</button>
                </div>
              </div>
            </div>
          </div>
          <div class="panel-body">
              <table class="reservation-table table" id="list-export">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Res #</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Route</th>
                    <th>Seats</th>
                    <th>Price</th>
                    <th>Mobile</th>
                    <th>Payment status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // Loop database row for reservation list contents from the database
                  $resquery = $db->query($querydis);
                  $numsults = $resquery->num_rows;
                  for ($i=0; $i < $numsults; $i++) {
                    $row1 = $resquery->fetch_assoc();
                    $status = "";
                    if ($row1['cancel'] == "Yes") $status = "Unsettled";
                    else if ($row1['status'] == "Yes") $status = "Yes";
                    else if ($row1['status'] == "No") $status = "No";
                    $terminal = explode(" ", $row1['route'])[0];
                    echo "<tr class=\"iterable tr-reserve ".$status." ".$row1['Bus_No']." ".$terminal." ".$row1['rDate']." ".strtotime($row1['DeptTime'])."\" id='".$row1['Reserve_Code']."'>
                      <td>
                        <div class=\"name-label form-input\" >".$row1['Fname']." ".$row1['Lname']."</div>
                      </td>
                      <td>
                        <div class=\"transaction-number form-input\">".$row1['reservation_num']."</div>
                      </td>
                      <td>
                        <div class=\"date-label form-input\">".$row1['rDate']."</div>
                      </td>
                      <td>
                        <div class=\"date-label form-input\">".$row1['DeptTime']."</div>
                      </td>
                      <td>
                        <div class=\"date-label form-input\">".$row1['route']."</div>
                      </td>
                      <td>
                        <div class=\"date-label form-input\">".$row1['seatplan']."</div>
                      </td>
                      <td>
                        <div class=\"price-label form-input\">".$row1['tPrice']."</div>
                      </td>
                      <td>
                        <div class=\"mobile-label form-input\">".$row1['phone']."</div>
                      </td>";
                      echo
                      "<input type=\"hidden\" class=\"name\" value=\"".$row1['Fname']." ".$row1['Lname']."\">
                       <input type=\"hidden\" class=\"date\" value=\"".$row1['rDate']."\">
                       <input type=\"hidden\" class=\"price\" id=\"".$row1['Reserve_Code']."-price\" value=\"".$row1['tPrice']."\">
                       <input type=\"hidden\" class=\"\" name=\"".$row1['Reserve_Code']."-trip-code\" id=\"".$row1['Reserve_Code']."-trip-code\" value=\"".$row1['Trip_Code']."\">
                       <input type=\"hidden\" class=\"phone\" name=\"".$row1['Reserve_Code']."-phone\" id=\"".$row1['Reserve_Code']."-phone\" value=\"".$row1['phone']."\">
                       <input type=\"hidden\" class=\"email\" name=\"".$row1['Reserve_Code']."-mail\" id=\"".$row1['Reserve_Code']."-email\" value=\"".$row1['email']."\">
                       <input type=\"hidden\" class=\"busno\" name=\"".$row1['Reserve_Code']."-busno\" id=\"".$row1['Reserve_Code']."-busno\" value=\"".$row1['Bus_No']."\">
                       <input type=\"hidden\" name=\"".$row1['Reserve_Code']."-fname\" id=\"".$row1['Reserve_Code']."-fname\" value=\"".$row1['Fname']."\">
                       <input type=\"hidden\" name=\"".$row1['Reserve_Code']."-lname\" id=\"".$row1['Reserve_Code']."-lname\" value=\"".$row1['Lname']."\">
                       <input type=\"hidden\" class=\"resnum\" name=\"".$row1['Reserve_Code']."-resnum\" id=\"".$row1['Reserve_Code']."-resnum\" value=\"".$row1['reservation_num']."\">
                       <input type=\"hidden\" class=\"time\" name=\"".$row1['Reserve_Code']."-time\" id=\"".$row1['Reserve_Code']."-time\" value=\"".$row1['DeptTime']."\">
                       <input type=\"hidden\" class=\"seat\" name=\"".$row1['Reserve_Code']."-seat\" id=\"".$row1['Reserve_Code']."-seat\" value=\"".$row1['seatplan']."\">
                       <input type=\"hidden\" class=\"passenger\" name=\"".$row1['Reserve_Code']."-passenger\" id=\"".$row1['Reserve_Code']."-passenger\" value=\"".$row1['passenger']."\">
                       <input type=\"hidden\" class=\"route\" name=\"".$row1['Reserve_Code']."-route\" id=\"".$row1['Reserve_Code']."-route\" value=\"".$row1['route']."\">
                       <input type=\"hidden\" class=\"status\" name=\"".$row1['Reserve_Code']."-status\" id=\"".$row1['Reserve_Code']."-status\" value=\"".$row1['status']."\">
                       <input type=\"hidden\" class=\"driver\" name=\"".$row1['Reserve_Code']."-driver\" id=\"".$row1['Reserve_Code']."-driver\" value=\"".$row1['Bus_Driver']."\">
                       <input type=\"hidden\" class=\"conductor\" name=\"".$row1['Reserve_Code']."-conductor\" id=\"".$row1['Reserve_Code']."-conductor\" value=\"".$row1['Bus_Conductor']."\">";
                      // Check if payment status is true or false
                    if ($row1['status']=='Yes') {
                        echo
                        "<td>
                          <div class=\"mobile-label form-input\"><span class=\"glyphicon glyphicon-ok\"></span>&nbsp;Paid</div>
                        </td>";

                    } else {
                      if ($row1['cancel']=='No')
                        echo
                        "<td>
                          <button type=\"button\" class=\"btn btn-blk btn-default confirm-payment-btn\">Confirm</button>
                          <div class=\"pending-label hidden\">Pending</div>
                        </td>";
                      else
                      echo
                        "<td>
                          <div class=\"mobile-label form-input\"><span class=\"glyphicon glyphicon-remove\"></span>&nbsp;Not settled</div>
                        </td>";
                    }
                    echo
                    "</tr>";
                  }

                  ?>
                </tbody>
              </table>
              <button type="button"
                      class="btn btn-default btn-sm save-btn"
                      data-toggle="modal"
                      data-target="#modal-confirm">
                <span class="glyphicon glyphicon-ok"></span>Save
              </button>
              <button type="button" class="btn btn-default btn-sm" id="reserve-cancel-btn">
                <span class="glyphicon glyphicon-remove"></span>Cancel
              </button>
              <button type="button" class="btn btn-default btn-sm" id="export-btn">
                <span class="glyphicon glyphicon-edit"></span>Export to PDF
              </button>
          </div>
        </div>
      </div>

      <div id="trip-settings" class="setting-container col-md-11">
        <div class="panel panel-info">
          <div class="panel-heading"><h4><strong>Trip settings</strong></h4></div>
          <div class="panel-body">
            <?php
              $selectbusquery = "SELECT * FROM bus2;";
              $resquery = $db->query($selectbusquery);
              $numresult = $resquery->num_rows;
              $trip_input_length = $numresult;
              if (!$resquery) echo "<div class=\"alert alert-danger\">Failed to fetch database</div>";
              for($i = 0; $i < $numresult; $i++) {
                $row = $resquery->fetch_assoc();
                echo
                "<div class=\"form-label\">Bus Number ".$row['Bus_No']."</div>
                <div class=\"container-fluid form-group\">
                  <input type=\"hidden\" id=\"bus-code-input-".$i."\" value=\"".$row['Bus_Code']."\" >
                  <div class=\"col-sm-6 form-btn2\">
                    <label>Driver:</label>
                    <input type=\"text\" id=\"driver-input-".$i."\" class=\"form-control trip-settings-input\" value=\"".$row['Bus_Driver']."\" disabled>
                  </div>
                  <div class=\"col-sm-6 form-btn2\">
                    <label>Conductor:</label>
                    <input type=\"text\" id=\"conductor-input-".$i."\" class=\"form-control trip-settings-input\" value=\"".$row['Bus_Conductor']."\"  disabled>
                  </div>
                </div><br>";
              }
            ?>
            <button type="button" class="btn btn-default btn-sm" id="edit-trip-settings-btn">
              <span class="glyphicon glyphicon-edit"></span>Edit
            </button>
            <button type="button"
                    class="btn btn-default btn-sm hidden" id="save-trip-settings-btn"
                    data-toggle="modal"
                    data-target="#modal-confirm">
              <span class="glyphicon glyphicon-ok"></span>Save
            </button>
          </div>
        </div>
      </div>

      <div id="payment-settings" class="setting-container col-md-11">
        <div class="panel panel-info">
          <div class="panel-heading"><h4><strong>Payment settings</strong></h4></div>
          <div class="panel-body">
              <div class="container-fluid form-group">
                <div class="col-sm-6 form-btn2">
                  <label>Smart number :</label>
                  <input type="text" id="smart-number-input" class="form-control payment-settings-input" value=<?php echo $smart_number; ?> disabled>
                </div>
                <div class="col-sm-6 form-btn2">
                  <label>Mobile number :</label>
                  <input type="text" id="mobile-number-input" class="form-control payment-settings-input" value=<?php echo $mobile_number; ?> disabled>
                </div>
              </div>
            <button type="button" class="btn btn-default btn-sm" id="edit-payment-settings-btn">
              <span class="glyphicon glyphicon-edit"></span>Edit
            </button>
            <button type="button"
                    class="btn btn-default btn-sm hidden" id="save-payment-settings-btn"
                    data-toggle="modal"
                    data-target="#modal-confirm">
              <span class="glyphicon glyphicon-ok"></span>Save
            </button>
          </div>
        </div>
      </div>

      <div id="transaction-log" class="setting-container col-md-11">
        <div class="panel panel-info">
          <div class="panel-heading ">
            <h4><strong>Transaction log</strong></h4>
          </div>
          <div class="panel-body">

              <table class="transaction-table table">
                <thead>
                  <tr>
                    <th>Transaction</th>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Price</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // loop for transaction database
                  $querytd = "SELECT * FROM `transaction` INNER JOIN `user` ON `transaction`.`email`=`user`.`email`";
                  $restd = $db->query($querytd);
                  $numsult = $restd->num_rows;
                  $db->close();
                  for ($i=0; $i < $numsult; $i++) {
                    $row2 = $restd->fetch_assoc();
                    echo
                    "<tr class=\"iterable\">
                      <td>
                        <div class=\"form-group transaction-label form-input\">".$row2['Transaction_Code']."</div>
                      </td>
                      <td>
                        <div class=\"form-group date-label form-input\">".$row2['tdate']."</div>
                      </td>
                      <td>
                        <div class=\"form-group name form-input\">".$row2['Fname']." ".$row2['Lname']."</div>
                      </td>
                      <td>
                        <div class=\"form-group price form-input\">".$row2['tPrice']."</div>
                      </td>
                    </tr>";
                  }
                  ?>
                </tbody>
              </table>

          </div>
        </div>
      </div>

      <div id="front-page-settings" class="setting-container col-md-11">
        <div class="panel panel-info">
          <div class="panel-heading"><h4><strong>Front page settings</strong></h4></div>
          <div class="panel-body">

              <!--<div class="form-group container-fluid">
                <label>About Us</label>
                <textarea class="form-control front-page-settings-input" rows="8" id="about-input" name="about-input" disabled><?php/* echo $about;*/?></textarea>-->
                <div class="col-sm-6">
                  <label>Facebook:</label>
                  <input type="text" id="fb-link-input" name="fbook" class="form-control front-page-settings-input" value=<?php echo $fb_link;?> disabled>
                </div>
                <div class="col-sm-6">
                  <label>Email:</label>
                  <input type="text" id="email-input" name="email" class="form-control front-page-settings-input" value=<?php echo $email;?> disabled>
                </div>
              </div>

            <button type="button" class="btn btn-default btn-sm about-btn" id="edit-about-btn">
              <span class="glyphicon glyphicon-edit"></span>Edit
            </button>
            <button type="button"
                    class="btn btn-default btn-sm hidden"
                    id="save-about-btn"
                    data-toggle="modal" data-target="#modal-confirm">
              <span class="glyphicon glyphicon-ok"></span>Save
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
    <div class="modal fade" id="modal-confirm" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header" align="center">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4>Please input your password here</h4>
          </div>
          <form id="inputform" action="php/save-admin-settings.php" method="post">
            <div class="modal-body form-group form-inline" align="center">
              <label for="pwd">Password: </label>
              <input type="password" name="pwd-verification-input" class="form-control" id="modal-password-input">
            </div>
            <div class="modal-footer">
              <!--will receive a confirmation and the user will recieve a pdf to their email-->
              <div id="hidden-inputs">
                <input type="hidden" name="reserve-number-length" id="reserve-number-length" value=0>
                <input type="hidden" name="smart-number-input" id="smart-number-input-after" value="<?php echo $smart_number; ?>">
                <input type="hidden" name="mobile-number-input" id="mobile-number-input-after" value="<?php echo $mobile_number; ?>">
                <input type="hidden" name="fb-link-input" id="fb-link-input-after" value="<?php echo $fb_link; ?>">
                <input type="hidden" name="email-input" id="email-input-after" value="<?php echo $email; ?>">
                <input type="hidden" name="trip-input-length" id="trip-input-length" value="<?php echo $trip_input_length; ?>" >
              </div>
              <button type=button class="btn btn-default" id="modal-yes-button">Confirm</button>
              <a class="btn btn-default" id="modal-no-button" data-dismiss="modal" aria-hidden="true" role="button">No</a>
            </div>
          </form>
        </div>
      </div>
    </div>
</body>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="js/admin.js"></script>
  <script src="vendor/jspdf/jspdf.min.js"></script>
</html>
