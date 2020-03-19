<?php

include_once('../includes/login_status.php');

include_once('../includes/db_conf.php');

$admin = $_SESSION['admin'];
$sql = "SELECT * FROM users WHERE username='" . $username . "'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
$balance = $user['balance'];
$plan = $user['plan'];

if ($plan == 1) {
	$color = "green";
} elseif ($plan == 2) {
	$color = "blue";
} elseif ($plan == 3) {
	$color = "purple";
} else {
	$color = "red";
}

?>

<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<link rel="shortcut icon" href="img/logo/favicon.ico" type="image/x-icon">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Dscon | Client List</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta name="viewport" content="width=device-width" />

	<!-- Bootstrap core CSS     -->
	<link href="css/bootstrap.min.css" rel="stylesheet" />

	<link rel="stylesheet" href="../css/main.css">


	<!--  Material Dashboard CSS    -->
	<link href="css/material-dashboard.css" rel="stylesheet" />

	<!--  CSS for Demo Purpose, don't include it in your project     -->
	<link href="css/demo.css" rel="stylesheet" />

	<link rel="stylesheet" href="css/icon.css">
	<!--     Fonts and icons     -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet" />
	<link href="http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons" rel="stylesheet" type="text/css" />

</head>

<body>
	<header>
		<style>
			.topnav {
				overflow: hidden;
				background-color: #333;
			}

			.topnav a {
				float: left;
				display: block;
				color: #f2f2f2;
				text-align: right;
				padding: 20px 7px;
				text-decoration: none;
				font-size: 17px;
				transition: 0.5s all;
			}

			.topnav a:hover {
				background-color: #ddd;
				color: black;
			}

			.topnav a.active {
				background-color: #4CAF50;
				color: white;
			}

			.topnav .icon {
				display: none;
			}

			@media screen and (max-width: 600px) {
				.topnav a:not(:first-child) {
					display: none;
				}

				.topnav a.icon {
					float: right;
					display: block;
				}

			}

			@media screen and (max-width: 600px) {
				.topnav.responsive {
					position: relative;
				}

				.topnav.responsive .icon {
					margin-top: 0;
					position: absolute;
					right: 0;
					top: 0;
				}

				.topnav.responsive a {
					float: none;
					display: block;
					text-align: left;
				}

				.notifications {
					display: none !important;
				}
			}
		</style>

		<div class="topnav" id="myTopnav">
			<a href="#home" class="navbar-brand mr-auto" style="margin-left: -10px!important; margin-top: 1px!important; margin-right: 30%!important"></a>
			<?php if ($admin == false) { ?>
				<a class="nav-link" href="../dashboard/">Profile</a>
				<a href="../internet/" class="nav-link">Combined Packages</a>
				<a href="../internet/single.php" class="nav-link">Single Packages</a>

			<?php } else {
			?>
				<a class="nav-link" href="../dashboard/">Dashboard</a></li>
			<?php } ?>

			<!-- <a href="../internet/packages.php" class="nav-link py-0" style="color: #f8f9fa!important;">Movie Packages</a> -->
			<a href="../movie/" class="nav-link">Entertainment</a>
			<?php if ($admin == true) {
			?>
				<a class="nav-link py-0 text-light" href="sms.php" style="color: #f8f9fa!important;">Sms</a>

				<a class="nav-link py-0 text-light" href="active.php" style="color: #f8f9fa!important;">Active</a>
				<a class="nav-link py-0 text-light" href="allclients.php" style="color: #f8f9fa!important;">Clients</a>
				<a class="nav-link py-0 text-light" href="profiles.php" style="color: #f8f9fa!important;">Profiles</a>
				<a class="nav-link py-0 text-light" href="payments.php" style="color: #f8f9fa!important;">Payments</a>
				<a class="nav-link py-0 text-light" href="mine.php" style="color: #f8f9fa!important;">Fabian's</a>
				<a class="nav-link py-0 text-light" href="issues.php" style="color: #f8f9fa!important;">Issues</a>
			<?php } ?>
			<?php if ($admin == true or $username == 'fraizer') {
			?>
				<a class="nav-link text-light" href="fraizer.php" style="color: #f8f9fa!important;">Fraizer's</a>

			<?php
			}
			?>
			<?php if ($admin == false) { ?>
				<a class="nav-link" href="../dashboard/report_issue.php">Report Issue</a>
				<a href="../dashboard/notifications.php" class="notifications">
					notifications
					<?php
					$sql = "SELECT * FROM notifications WHERE username='" . $username . "'";
					$results = mysqli_query($conn, $sql);
					$count = mysqli_num_rows($results);
					?>
					<span class="notification" style="background: red; border-radius: 50%; padding: 5px;"><?php echo $count; ?></span>
				</a>
			<?php } ?>
			<a href="../dashboard/logout.php">Logout</a>

			<a href="javascript:void(0);" class="icon" onclick="myFunction()">
				<i class="fa fa-bars"><svg fill="white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
						<path d="M0 0h24v24H0z" fill="none" />
						<path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z" /></svg></i>
			</a>
		</div>

		<script>
			function myFunction() {
				var x = document.getElementById("myTopnav");
				if (x.className === "topnav") {
					x.className += " responsive";
				} else {
					x.className = "topnav";
				}
			}
		</script>
	</header>

	<div class="main-panel" style="padding-top: 0;">
		<div class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header" data-background-color="<?php echo $color; ?>">
								<h4 class="title">User Profiles</h4>
							</div>
							<div class="card-content table-responsive">
								<table class="table table-hover">
									<thead>
										<th>Id</th>
										<th>Name</th>
										<th>Address pool</th>
										<th>Shared Users</th>
										<th>Rate Limit</th>
										<th>Queue Type</th>
									</thead>
									<tbody id="txtHint">

										<script>
											function clients() {
												var xmlhttp = new XMLHttpRequest();
												xmlhttp.onreadystatechange = function() {
													if (this.readyState == 4 && this.status == 200) {
														document.getElementById("txtHint").innerHTML = this.responseText;
													}
												};
												xmlhttp.open("GET", "user-profiles.php", true);
												xmlhttp.send();

											}
											setInterval(clients, 1000);
										</script>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

</body>

<!--   Core JS Files   -->
<script src="js/jquery-3.1.0.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

<script src="js/material.min.js" type="text/javascript"></script>

<!--  Charts Plugin -->
<script src="js/chartist.min.js"></script>

<!--  Notifications Plugin    -->
<script src="js/bootstrap-notify.js"></script>

<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

<!-- Material Dashboard javascript methods -->
<script src="js/material-dashboard.js"></script>

<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="js/demo.js"></script>

</html>
