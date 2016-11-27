<!DOCTYPE html>
<html>
<head>
 <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
	<title>Forgot password</title>
  <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
  <style>
    .forgot-password-container {
      margin: auto;
      max-width: 400px;
    }
    .input-container {
      max-width: 400px;
      display: block;
    }
  </style>
</head>
<body>
  <div class="forgot-password-container">
    <h3>Please enter the following</h3>
    <div class="container">
      <form method="post" action="php\forgotpasswordverify.php">
        <div class=" container-fluid">
          <div class="input-container form-group">
            <label for="Cemail">Enter your Email:</label>
            <input type="email" id="Cemail" class="form-control" name="Cemail">
          </div>
          <div class="input-container form-group">
            <label for="Cmobile">Enter your Mobile:</label>
            <input type="text" id="Cmobile" class="form-control" name="Cmobile">
          </div>
        </div>
        <div class="form-group">
          <div class="g-recaptcha" data-sitekey="6LffBA0UAAAAAN7_ljZqzwXogdtXx69_zQelfXi8"></div>
        </div>
        <div class="form-group">
          <input type="submit" class="btn btn-default btn-blk" value="submit" name="forgotpassword">
        </div>
      </form>
    </div>
  </div>
</body>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
</html>
