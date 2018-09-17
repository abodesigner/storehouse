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
					if(isset($_SESSION['user'])){ ?>
						<img src="themes/images/user.png" alt="User">
						<div class="btn-group my-info">
							<span class="btn btn-info dropdown-toggle" data-toggle="dropdown">
								<?php echo $sessionUser; ?>
								<span class="caret"></span>
							</span>
							<ul class="dropdown-menu">
								<li><a href="profile.php">My Profile</a></li>
								<li><a href="newItem.php">New Item</a></li>
								<li><a href="profile.php#my-items">My Items</a></li>
								<li><a href="profile.php#my-comments">My Comments</a></li>
								<li><a href="logout.php">Logout</a></li>
							</ul>
						</div>


						<?php

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
								<a href='categories.php?pageid=" . $cat['ID'] . "'>"
								. $cat['Name'] .
								"</a>
							  </li>";
					}
				?>
		      </ul>
		    </div>
		  </div>
		</nav>
