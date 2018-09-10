<?php
      session_start();
      $pageTitle = 'Login';

      if(isset($_SESSION['user'])){
    		header("Location: index.php");  // Redirect to home page.
    		exit();
    	}

        include 'init.php';

        // Check if user come from HTTP POST request
      	if ($_SERVER['REQUEST_METHOD'] == 'POST'){

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
      <input type="submit" name="submit" value="Login" class="btn btn-primary btn-block">
    </form>
    <!-- End Login Form -->

    <!-- Start Signup Form -->
    <form class="signup" action="" method="post">
      <div class="input-container">
          <input type="text" name="username" autocomplete="off" class="form-control" placeholder="Username" required>
      </div>
      <div class="input-container">
        <input type="password" name="pwd" autocomplete="new-password" class="form-control" placeholder="Type Password" required>
      </div>
      <div class="input-container">
        <input type="password" name="pwd2" autocomplete="new-password" class="form-control" placeholder="Re-type Password" required>
      </div>
      <div class="input-container">
        <input type="email" name="email" class="form-control" placeholder="Type A valid Email" required>
      </div>
      <input type="submit" name="submit" value="Signup" class="btn btn-success btn-block">
    </form>
    <!-- End Login Form -->
  </div>
</div>
<!-- End Login Form -->

<?php
      include $tpl . 'footer.inc.php';
?>
