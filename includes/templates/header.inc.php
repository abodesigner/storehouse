<!DOCTYPE html>
<html>
	<head>
		<title><?php echo getTitle(); ?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo $css ?>bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $css ?>all.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $css ?>jquery-ui.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $css ?>jquery.selectBoxIt.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $css ?>front.css">

	</head>
	<body>
		<div class="upper-bar">
			<div class="container">
				<?php

					if(isset($_SESSION['user'])){

						echo "Welcome " . $sessionUser . ' ';

						echo "<a href='profile.php'>My Profile</a>";

						echo " - <a href='logout.php'> Logout</a>";

						$userStatus = checkUserStatus($sessionUser);

							if($userStatus == 1){

								// User not activated yet

							}
				} else { ?>
					<a href="login.php">
						<span class="pull-right">login/signup</span>
					</a>
				<?php } ?>


			</div>
		</div>
		<nav class="navbar navbar-inverse">
		  <div class="container">
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="index.php">homepage</a>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="app-nav">
		      <ul class="nav navbar-nav navbar-right">
		        <?php

					$categories = getCats();
					foreach ($categories as $cat) {
						echo "<li>
								<a href='categories.php?pageid=" . $cat['ID'] . "&pagename=" . str_replace(' ','-',$cat['Name']) . "'>"
								. $cat['Name'] .
								"</a>
							  </li>";
					}
				?>
		      </ul>
		    </div>
		  </div>
		</nav>
