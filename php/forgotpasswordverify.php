<?php
  require_once("../vendor/phpmailer/class.phpmailer.php");
  $email;
  $comment;
  $captcha;
  if(isset($_REQUEST['Cemail'])) {
    $Cemail=$_REQUEST['Cemail'];
  }
  if(isset($_REQUEST['Cmobile'])) {
    $Cmobile=$_REQUEST['Cmobile'];
  }
  if(isset($_REQUEST['g-recaptcha-response'])) {
    $captcha=$_REQUEST['g-recaptcha-response'];
  }
  if(!$captcha){
    echo  "<p>Complete the captcha.<a href=\"../index.php\">Home</a></p>";
    exit;
  }
  include 'connect_to_db.php';
  $queryverify = "SELECT * FROM user WHERE email='$Cemail'AND phone='$Cmobile'";
  $queryrest = $db->query($queryverify);
  $numresult = $queryrest->num_rows;

  $secretKey = "6LffBA0UAAAAABox9kWAF28j1FiQz_F0p-BrMvFk";
  $ip = $_SERVER['REMOTE_ADDR'];
  $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
  $responseKeys = json_decode($response, true);
  if(intval($responseKeys["success"]) !== 1) {
    echo  "<p>Cannot validate your request.<a href=\"../index.php\">Home</a></p>";
  } else {
    if ($numresult==1) {
      $row = $queryrest->fetch_assoc();
      if ($row['email'] == $Cemail && $Cmobile == $row['phone']) {
        $email = new PHPMailer();
        $email->From      = "bot@potransportcorp.com";
        $email->FromName  = "P&O Web Admin";
        $email->Subject   = "Information Retrieval";
        $email->Body      = "Your requested information:\n".$row['password'];
        $email->AddAddress($row['email']);
        $email->Send();
        echo  "<p>Information has been sent to your email.<a href=\"../index.php\">Home</a></p>";
      }
    }
  }
?>
