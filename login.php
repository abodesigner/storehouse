  <?php
      ob_start();

      session_start();

      $pageTitle = 'Login';

      if(isset($_SESSION['user'])){
    		header("Location: index.php");  // Redirect to home page.
    		exit();
    	}
        include 'init.php';
        // Check if user come from HTTP POST request
      	if ($_SERVER['REQUEST_METHOD'] == 'POST'){

          //Check if user click on login Button
          if (isset($_POST['login'])) {
            $username = $_POST['username'];
            $password = $_POST['pwd'];
            $hashedPwd = sha1($password);

            // Check if the User exist in database
            $stmt = $con->prepare("SELECT
                                       Username, Password
                                   FROM
                                       users
                                   WHERE
                                        Username=?
                                   AND
                                        Password=?");
            $stmt->execute(array($username, $hashedPwd));
            $count = $stmt->rowCount();

            if($count > 0){
              //there are data in database
              $_SESSION['user'] = $username;     //Register Session Name

              //print_r($_SESSION);
              header("Location: index.php"); // Redirect to dashboard page.
              exit();
            }
          } else {

            // User click on signup Button
            // Vaidate form field
            $formErrors = array();

            $username  = $_POST['username'];
            $password  = $_POST['pwd'];
            $password2 = $_POST['pwd2'];
            $email     = $_POST['email'];


            // Check Username Length
            if(isset($_POST['username'])){
              $filtered_user = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
              if(strlen($filtered_user) < 4){
                  $formErrors[] = "Error .. Username Must be Larger Than <strong>4</strong> Charaters";
              }
            }

            // Check Password Matches
            if(isset($_POST['pwd']) && isset($_POST['pwd2'])){

              // Check password if Empty
              if(empty($_POST['pwd'])){
                    $formErrors[] = "Error .. Password can not be empty";
              }

              // Hash the passwords
              $pass1 = sha1($_POST['pwd']);
              $pass2 = sha1($_POST['pwd2']);

              // Check password matches
              if($pass1 !== $pass2){
                  $formErrors[] = "Error .. Passwords are not matches";
              }
            }

            // Check Email
            if(isset($_POST['email'])){

              $filtered_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

              if (filter_var($filtered_email, FILTER_VALIDATE_EMAIL) != true) {

                  $formErrors[] = "Error .. Email is not validate";
              }
            }

            // Check if there is no errors ... proceed the user to database
            if(empty($FormErrors)){

                // Check if Username exist in database
                $check = checkItem("Username", "users", $_POST['username']);

                    if($check === 1 ){

                    $formErrors[] = "Error .. Username is already exist";

                } else {

                   //Insert New User data into the database
                    $stmt = $con->prepare("INSERT INTO users(Username, Password, Email, RegStatus, Date)
                                           VALUES(:zuser, :zpass, :zmail, 0, now())");
                            $stmt->execute(array(
                                'zuser' => $username,
                                'zpass' => sha1($password),
                                'zmail' => $email
                            ));

                    $successMsg = "Congratulation , You are now registerd";

                }
            }

          }
      	}
  ?>

  <!-- Start Login Form -->
  <div class="login-page">
    <div class="container">
      <h1 class="text-center">
        <span class="active" data-class="login">Login</span> | <span data-class="signup">Signup</span>
      </h1>
      <!-- Start Login Form -->
      <form class="login" action="<?php $_SERVER['PHP_SELF']?>" method="post">
        <input type="text" name="username" autocomplete="off" class="form-control" placeholder="Username">
        <input type="password" name="pwd" autocomplete="new-password" class="form-control" placeholder="Password">
        <input type="submit" name="login" value="Login" class="btn btn-primary btn-block">
      </form>
      <!-- End Login Form -->

      <!-- Start Signup Form -->
      <form class="signup" action="<?php $_SERVER['PHP_SELF']?>" method="post">
        <div class="input-container">
            <input title="Username chars should be 4 or more" type="text" name="username" autocomplete="off" class="form-control" placeholder="Username" required>
        </div>
        <div class="input-container">
          <input minlength="4" type="password" name="pwd" autocomplete="new-password" class="form-control" placeholder="Type Password" required>
        </div>
        <div class="input-container">
          <input minlength="4" type="password" name="pwd2" autocomplete="new-password" class="form-control" placeholder="Re-type Password" required>
        </div>
        <div class="input-container">
          <input type="text" name="email" class="form-control" placeholder="Type A valid Email">
        </div>
        <input type="submit" name="signup" value="Signup" class="btn btn-success btn-block">
      </form>
      <!-- End Login Form -->

      <div class="the-errors text-center">
          <?php
            if(!empty($formErrors)){
              foreach ($formErrors as $err) {
                echo $err . '<br>';
              }
            }

            if(isset($successMsg)){
              echo "<div class='msg success'>Your registeration done successfully</div>";
            }
        ?>
      </div>
    </div>
  </div>
  <!-- End Login Form -->



  <?php
        include $tpl . 'footer.inc.php';

        ob_end_flush();


  ?>
