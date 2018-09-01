<?php

	$noNavbar = '';
	$pageTitle = 'login';

	session_start();
	if(isset($_SESSION['Username'])){
		header("Location: dashboard.php"); // Redirect to dashboard page.
		exit();
	}

	include 'init.php';



	// Check if user come from HTTP POST request
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){

		$user = $_POST['username'];
		$pwd = $_POST['password'];
		$hashedPwd = sha1($pwd);

		// Check if the User exist in database
		$stmt = $con->prepare("SELECT
									UserID, Username, Password
							   FROM users
							   WHERE Username=?
							   AND Password=?
							   AND GroupID=1"

								);
		$stmt->execute(array($user,$hashedPwd));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();

		if($count > 0){
			//there are data in database
			$_SESSION['Username'] = $user;     //Register Session Name
			$_SESSION['ID'] = $row['UserID'];  //Register Session ID
			header("Location: dashboard.php"); // Redirect to dashboard page.
			exit();
			// print_r($row);
		}
	}
?>

	<form class="login" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
		<h4 class="text-center">Admin Login</h4>
		<input class="form-control" type="text" name="username" placeholder="Username" autocomplete="off">
		<input class="form-control" type="password" name="password" placeholder="Password" autocomplete="off">
		<input class="btn btn-primary btn-block" type="submit" name="submit" value="Login">
	</form>

<?php include $tpl . 'footer.inc.php';?>
