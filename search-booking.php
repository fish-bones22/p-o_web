<?php
  session_start();
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
    <h2>Search results</h2>

    <div class="results-container">
      <form method="post" action="search-booking.php">
        <div class="booking-btn-container container-fluid">
          <div class="col-sm-10">
            <input type="text" name="reserve-code-input" class="form-control" placeholder="Enter 10 digit code">
          </div>
          <div class="col-sm-2">
            <button type="submit" class="btn btn-default btn-blk">Search</button>
          </div>
        </div>
      </form>
      <div class="panel panel-default">
        <div class="panel-heading ">
          <h4><strong>Current Transactions</strong></h4>
        </div>

        <div class="panel-body">
          <table class="table">
            <thead>
              <tr>
                <th>Reservation number</th>
                <th>Reservation date</th>
                <th>Status</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
                $query = "SELECT * FROM `reserve` WHERE `reservation_num`='".$_REQUEST['reserve-code-input']."'";
                $result = $db->query($query);
                $numresults = $result->num_rows;
                $db->close();
                if ($numresults) {
                  for ($i = 0; $i < $numresults; $i++) {
                    $row = $result->fetch_assoc();
                    echo
                    "<tr>
                        <td>".$row['reservation_num']."</td>
                        <td>".$row['rDate']."</td>";
                    if ($row['status'] === "Yes") {
                      echo "<td><div><span class=\"glyphicon glyphicon-ok\"></span>&nbsp;Confirmed</div></td>";
                    } else {
                        if ($row['cancel'] === "Yes") {
                          echo
                          "<td>
                            <div><span class=\"glyphicon glyphicon-remove\"></span>&nbsp;Canceled</div>
                            <div class=\"note\">Failed to pay within 24 hours</div>
                            </td>";
                        } else {
                          echo "<td><div><span class=\"glyphicon glyphicon-clock\"></span>&nbsp;Pending</div></td>";
                        }
                      }
                      echo "</tr>";
                    }
                  } else {
                    echo "<tr><td class=\"note\">No results found</td></tr>";
                  }
               ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- Reserve code modal -->
    <div class="modal fade" id="modal-search" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header" align="center">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4>Enter reservation code to check booking status</h4>
          </div>
          <form id="inputform" action="search-booking.php" method="post">
            <div class="modal-body form-group form-inline" align="center">
              <label>Code: </label>
              <input type="text" name="reserve-code-input" class="form-control" id="modal-search-input">
            </div>
            <div class="modal-footer">
              <button type=submit class="btn btn-default" id="modal-yes-button">Search</button>
              <a class="btn btn-default" id="modal-no-button" data-dismiss="modal" aria-hidden="true" role="button">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>

  </body>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="js/booking.js"></script>
</html>
