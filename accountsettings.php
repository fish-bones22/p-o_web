  <?php
    session_start();
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
    $db->close();

    $email = $_SESSION['email'];
    $password = $row['password'];
    $fname = $row['Fname'];
    $lname = $row['Lname'];
    $mobile = $row['phone'];
    $address = $row['Address'];

    if (!isset($_SESSION['update_success'])) {
      $_SESSION['update_success'] = 0;
    }


  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <title>Account</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrapValidator.min.css">
    <link rel="stylesheet" href="css/accountsettings.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrapValidator.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  </head>

  <body>
    <?php include 'navbar.php'; ?>
    <div class="panel account-settings-container">
      <div class="panel-heading"><h2>Account Settings</h2></div>
      <div class="panel-body">
        <form action="php/accountsettingsverify.php" method="POST" id="accountsettings" class="account-settings-form">
          <?php
          if ($_SESSION['update_success'])
            echo
              "<div class=\"alert alert-success\">Update successful<button class=\"close\" data-dismiss=\"alert\">&times;</button></div>";
          else if ($_SESSION['update_success'] == 2)
            echo
              "<div class=\"alert alert-failed\">Update failed<button class=\"close\" data-dismiss=\"alert\">&times;</button></div>";
          # Reset update_success
          $_SESSION['update_success'] = 0;
          ?>
          <div class="form-group">
            <label for="email">Email Address:</label>
            <input type="email" class="form-control" id="email" name="email" autocomplete='off' placeholder="Enter Email" value=<?php echo $email;?> required disabled>
          </div>
          <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" name="Password" id="pwd" name='pass' placeholder="Enter Password" value=<?php echo $password;?> autocomplete required disabled>
          </div>
          <div class="form-group">
            <label for="pwd">Retype Password:</label>
            <input type="password" class="form-control" name="RePassword" id="repwd" name='repass' placeholder="Re-enter Password" value=<?php echo $password;?> autocomplete required disabled>
          </div>
          <div class="form-group">
            <label for="fname" class="control-label">First Name:</label>
            <input type="text" class="form-control" name="Fname" id="fname" autocomplete='off' value=<?php echo $fname;?> required disabled>
          </div>
          <div class="form-group">
            <label for="lname">Last Name:</label>
            <input type="text" class="lastname-form form-control" name="Lname" id="lname" autocomplete='off' value=<?php echo $lname;?> required disabled>
          </div>
          <div class="form-group">
            <label for="phone">Mobile number:</label>
            <input type="text" id="phone" name="Phone" placeholder="09XX XXX XXXX" class="form-control bfh-phone" value=<?php echo $mobile;?> disabled>
          </div>
          <div class="form-group">
            <label for="phone">Address:</label>
            <input type="text" id="address" name="Address" class="form-control bfh-phone" value=<?php echo $address;?> disabled>
          </div>
            <!--buttons edit and save-->
            <button type="button" class="btn btn-default btn-sm edit-btn">
              <span class="glyphicon glyphicon-edit"></span> Edit
            </button>
            <button type="submit" class="btn btn-default btn-sm hidden save-btn ">
              <span class="glyphicon glyphicon-ok"></span> Save
            </button>
        </form>
      </div>
    </div>
    <script src="js/accountsettings.js"></script>
  </body>
  </html>
