<?php
  session_start();
  require_once("../vendor/phpmailer/PHPMailerAutoload.php");
  $reserve_number = array();
  $length = intval($_REQUEST['reserve-number-length']);
  echo $length;
  for ($i=0; $i < $length; $i++) {
    $reserve_number[$i] = $_REQUEST["reserve-number-".$i];
  }
  $smart_number = $_REQUEST['smart-number-input'];
  $mobile_number = $_REQUEST['mobile-number-input'];
  /*$about = $_REQUEST['about-input'];*/
  $fb_link = $_REQUEST['fb-link-input'];
  $email = $_REQUEST['email-input'];

  include 'connect_to_db.php';

  $query = "SELECT password FROM user WHERE email LIKE '".$_SESSION['email']."'";

  $result = $db->query($query);
  $numresults = $result->num_rows;
  $row = $result->fetch_assoc();

  function emailReceipt($res_num, $email_add) {
    copy("../temp/".$res_num.".pdf", "../transaction/receipt/".$res_num.".pdf");

    $email = new PHPMailer();
    $email->From      = "P&O Transport Corporation";
    $email->FromName  = "P&O Web Admin";
    $email->Subject   = "Payment Confirmation";
    $email->body      = "Your payment has been confirmed.\nOfficial receipt is attached in this email.";
    $email->AddAddress= ($email_add);

    $file_to_attach = "../transaction/receipt/";
    $email->AddAttachment($file_to_attach, $res_num.".pdf");
    unlink("../temp/".$res_num.".pdf");
    return $email->Send();
  }
?>

<!DOCTYPE html>
<html>
  <title>Admin Page</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

  <body>
<?php
  $error_cause = "Incorrect Password";
  if ($row['password'] == $_POST['pwd-verification-input']) {
    # Do SQL query HERE eto ay tinanggal muna About='$about',
    $updatequery = "UPDATE info SET  smart_number='$smart_number', mobile_number='$mobile_number', fb_link='$fb_link', email='".$email."' where id='1'";
    $updateresult1 = $db->query($updatequery);
    $updateresult2 = 1;
    $updateresult3 = 1;
    # Reservation list confirmed
    $res_len = intval($_REQUEST['reserve-number-length']);
    if ($res_len > 0) {
      for ($i = 0; $i < $res_len; $i++) {
        // Set status to paid
        $updatequery = "UPDATE `reserve` SET `status`='Yes' WHERE `Reserve_Code`=".$_REQUEST['reserve-number-'.$i].";";
        $updateresult2 = $db->query($updatequery);
        // Get info from reserve table and copy to transaction table
        $updatequery = "INSERT INTO `transaction` (`Bus_No`, `email`,`rdate`, tPrice, `Reserve_Code`, `tdate`)
                        SELECT `Bus_No`, `email`,`rDate`, tPrice, `Reserve_Code`, `tDate` FROM `reserve`
                        WHERE `Reserve_Code`='".$_REQUEST['reserve-number-'.$i]."';";
        $updateresult3 = $db->query($updatequery);
        $getemailquery = "SELECT `email` FROM `reserve` WHERE `Reserve_Code`=".$_REQUEST['reserve-number-'.$i].";";
        $result = $db->query($getemailquery);
        $numresults = $result->num_rows;
        $row = $result->fetch_assoc();
        echo $_REQUEST['reserve-number-'.$i];
        emailReceipt($_REQUEST['reserve-number-'.$i], $row["email"]);
      }
    }
    # Bus driver and conductor update
    for ($i=0; $i < intval($_REQUEST['trip-input-length']); $i++) {
      $bus_code = $_REQUEST["bus-code-after-".$i];
      $bus_driver = $_REQUEST['driver-input-after-'.$i];
      $bus_conductor = $_REQUEST['conductor-input-after-'.$i];
      $updatequerybusdc = "UPDATE `bus2` SET `Bus_Driver`='$bus_driver', `Bus_Conductor`='$bus_conductor' WHERE `Bus_Code`=".$bus_code."";
      $resultquery = $db->query($updatequerybusdc);
    }

    $db->close();
    # Then go back
    if ($updateresult1 && $updateresult2 && $updateresult3) {
      $_SESSION['admin_edit_success'] = 1;
      header("Location: ../admin.php");
      exit();
    } else {
      $error_cause = "Backend problem";
    }
  } else {
    $_SESSION['admin_edit_success'] = 2; #
  }
?>
    <div class="alert alert-danger" role="alert"><?php echo $error_cause?> ".
      <a href="../admin.php">Go back</a>
    </div>
  </body>
</html>
