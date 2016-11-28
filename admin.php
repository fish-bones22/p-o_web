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
        <li><a href="#payment-settings">Payment Details</a></li>
        <li><a href="#transaction-log">Transaction log</a></li>
        <li><a href="#front-page-settings">Front page settings</a></li>
      </ul>
    </nav>

    <div class="col-sm-offset-2">

       <!-- Search bar -->
      <div class="col-md-11">
        <div class="form-inline search-bar">
          <input type="text" name="search" class="form-control">
          <button type="submit" class="btn btn-default btn-sm" name="submit">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </div>
      </div>


      <div id="reservation-list" class="setting-container col-md-11">
        <div class="panel panel-info">
          <div class="panel-heading ">
            <h4><strong>Reservation List</strong></h4>
          </div>
          <div class="panel-body">
              <table class="reservation-table table">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Reservation</th>
                    <th>Date</th>
                    <th>Price</th>
                    <th>Mobile</th>
                    <th>Payment status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // Loop database row for reservation list contents from the database
                  $querydis = "SELECT * FROM `reserve`
                               INNER JOIN `user` ON `reserve`.`email`=`user`.`email`
                               INNER JOIN `trip3` ON `reserve`.`Trip_Code`=`trip3`.`Trip_Code`
                               INNER JOIN `bus2` ON `reserve`.`Bus_No`=`bus2`.`Bus_No`";
                  $resquery = $db->query($querydis);
                  $numsults = $resquery->num_rows;

                  for ($i=0; $i < $numsults; $i++) {

                    $row1 = $resquery->fetch_assoc();
                    echo "<tr class=\"iterable\" id='".$row1['Reserve_Code']."'>
                      <td>
                        <div class=\"name-label form-input\">".$row1['Fname']." ".$row1['Lname']."</div>
                      </td>
                      <td>
                        <div class=\"transaction-number form-input\">".$row1['Reserve_Code']."</div>
                      </td>
                      <td>
                        <div class=\"date-label form-input\">".$row1['rDate']."</div>
                      </td>
                      <td>
                        <div class=\"price-label form-input\">".$row1['tPrice']."</div>
                      </td>
                      <td>
                        <div class=\"mobile-label form-input\">".$row1['phone']."</div>
                      </td>";
                      echo
                      "<input type=\"hidden\" name=\"".$row1['Reserve_Code']."-trip-code\" id=\"".$row1['Reserve_Code']."-trip-code\" value=\"".$row1['Trip_Code']."\">
                       <input type=\"hidden\" name=\"".$row1['Reserve_Code']."-phone\" id=\"".$row1['Reserve_Code']."-phone\" value=\"".$row1['phone']."\">
                       <input type=\"hidden\" name=\"".$row1['Reserve_Code']."-mail\" id=\"".$row1['Reserve_Code']."-email\" value=\"".$row1['email']."\">
                       <input type=\"hidden\" name=\"".$row1['Reserve_Code']."-busno\" id=\"".$row1['Reserve_Code']."-busno\" value=\"".$row1['Bus_No']."\">
                       <input type=\"hidden\" name=\"".$row1['Reserve_Code']."-fname\" id=\"".$row1['Reserve_Code']."-fname\" value=\"".$row1['Fname']."\">
                       <input type=\"hidden\" name=\"".$row1['Reserve_Code']."-lname\" id=\"".$row1['Reserve_Code']."-lname\" value=\"".$row1['Lname']."\">
                       <input type=\"hidden\" name=\"".$row1['Reserve_Code']."-time\" id=\"".$row1['Reserve_Code']."-time\" value=\"".$row1['DeptTime']."\">
                       <input type=\"hidden\" name=\"".$row1['Reserve_Code']."-seat\" id=\"".$row1['Reserve_Code']."-seat\" value=\"".$row1['seatplan']."\">
                       <input type=\"hidden\" name=\"".$row1['Reserve_Code']."-route\" id=\"".$row1['Reserve_Code']."-route\" value=\"".$row1['route']."\">";
                      // Check if payment status is true or false
                    if ($row1['status']=='Yes') {
                      echo
                      "<td>
                        <div class=\"mobile-label form-input\"><span class=\"glyphicon glyphicon-ok\"></span>Paid</div>
                      </td>";
                    } else {
                      echo
                      "<td>
                        <button type=\"button\" class=\"btn btn-blk btn-default confirm-payment-btn\">Confirm</button>
                        <div class=\"pending-label hidden\">Pending</div>
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

              <div class="form-group container-fluid">
                <label>About Us</label>
                <textarea class="form-control front-page-settings-input" rows="8" id="about-input" name="about-input" form="inputform" disabled><?php echo $about;?></textarea>
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
              <button type=button class="btn btn-default" id="modal-yes-button">Confirm</button>
              <a class="btn btn-default" id="modal-no-button" data-dismiss="modal" aria-hidden="true" role="button">No</a>
              <div id="hidden-inputs">
                <input type="hidden" name="reserve-number-length" id="reserve-number-length" value=0>
                <input type="hidden" name="smart-number-input" id="smart-number-input-after" value="<?php echo $smart_number; ?>">
                <input type="hidden" name="mobile-number-input" id="mobile-number-input-after" value="<?php echo $mobile_number; ?>">
                <input type="hidden" name="fb-link-input" id="fb-link-input-after" value="<?php echo $fb_link; ?>">
                <input type="hidden" name="email-input" id="email-input-after" value="<?php echo $email; ?>">
              </div>
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
