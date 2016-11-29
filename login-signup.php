  <link rel="stylesheet" href="css/login-signup.css">
  <!-- Login / Sign up Form -->
  <div class="logform-container">
    <div class="logform-outside"></div>
    <div class="logform span6 offset3">
      <!-- Close button -->
      <a class="close-pop glyphicon glyphicon-remove"></a>
      <!-- Tabs: Login | Sign Up -->
      <ul class="tab-group">
      <li class="tab active"><a href="#login">Log In</a></li>
        <li class="tab"><a href="#signup">Sign Up</a></li>
      </ul>
      <div class="tab-content">
        <!-- Sign in tab -->
        <?php
        if ($_SESSION['error_signin'] == 1) {
          echo "<div class=\"alert alert-danger\">Login failed<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>";
        }
        ?>
        <div id="login">
          <h2>Log in</h2>
          <form action="php/loginverify.php" method="post" id="login-form">
            <div class="field-wrap form-group">
              <label class="loglabel" for="email">Email Address</label>
              <input type="email" id="email" name="email" placeholder="Enter email" class="form-control">
            </div>
            <div class="field-wrap form-group">
              <label class="loglabel" for="password">Password</label>
              <input type="password" id= "password" name="password" class="form-control">
            </div>
            <p class="forgot_pw_link"><a href="forgotpassword.php">Forgot Password?</a></p>
            <button class="btn btn-default btn-block" type="submit" id="login-btn">Log in</button>
          </form>
        </div>

        <div id="signup">
        <!-- Sign up tab -->
          <?php
          if ($_SESSION['error_signup'] == 1) {
            echo "<div class=\"alert alert-danger\">Registration failed<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>";
          }
          ?>
          <h2>Sign up</h2>
          <form action="php/regverify.php" method="post" id="signupval">
            <div class="top-row">
              <div class="field-wrap form-group">
                <label class="loglabel" for="fname">Firstname</label>
                <input type="text" id="fname" name="Fname" class="form-control">
              </div>
              <div class="field-wrap form-group">
                <label class="loglabel" for="lname">Lastname</label>
                <input type="text" id="lname" name="Lname" class="form-control">
              </div>
            </div>
            <div class="field-wrap form-group">
              <label class="loglabel" for="email">Email Address</label>
              <input type="email" id="email" placeholder="Enter you email" name="email" class="form-control">
            </div>
            <div class="field-wrap form-group">
              <label class="loglabel" for="password">Password</label>
              <input type="password" id = "password" name="Password1" class="form-control">
            </div>
            <div class="field-wrap form-group">
              <label class="loglabel" for="cpassword">Confirm Password</label>
              <input type="password" id = "cpassword" name="Confirm" class="form-control">
            </div>
            <div class="field-wrap form-group">
              <label class="loglabel" for="mobile">Mobile no.</label>
              <input type="text" id = "mobile" name="Phone" class="form-control" placeholder="09XX XXX XXXX" maxlength="11">
            </div>
            <div class="field-wrap form-group">
              <label class="loglabel" for="address">Address</label>
              <input type="text" id = "address" name="address" class="form-control">
            </div>
            <button class="btn btn-default btn-block" type="submit">Register</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="js/login-signup.js"></script>
