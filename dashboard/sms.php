<?php

ini_set('display_errors', 1);

require "../includes/login_status.php";

$admin = $_SESSION['admin'];


if (!($admin == true)) {
	header("location: ../");
}

include '../includes/db_conf.php';


if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$message = $_POST['message'];
	$user = $_POST['user'];

	include '../routeros_api.class.php';

	$API = new RouterosAPI();

	if ($user == 'all') {
		$sql = "SELECT * FROM users";
		$result = mysqli_query($conn, $sql);
		while ($user = mysqli_fetch_assoc($result)) {
			$API->connect('192.166.29.1', 'admin', '12345678A');
			$phone = 0 . $user['phone'];
			$ARRAY = $API->comm("/tool/sms/send", array(
				"port" => "usb1",
				"channel" => 2,
				'phone-number' => $phone,
				'message' => $message
			));
			$API->disconnect();
		}
	} else {
		$sql = "SELECT phone FROM users WHERE username = '" . $user . "'";
		$result = mysqli_query($conn, $sql);
		$user = mysqli_fetch_assoc($result);
		$API->connect('192.166.29.1', 'admin', '12345678A');
		$phone = 0 . $user['phone'];
		$ARRAY = $API->comm("/tool/sms/send", array(
			"port" => "usb1",
			"channel" => 2,
			'phone-number' => $phone,
			'message' => $message
		));
		$API->disconnect();
	}
}

$sql = "SELECT * FROM users WHERE username='" . $username . "'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
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

	<title>Dscon | Send sms</title>

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
	<style>
		label {
			font-weight: 700;
			color: black;
		}

		.textarea {
			width: 50rem;
			height: 100px;
			border: solid 1px lightgray !important;
			background: white;
		}

		.btn {
			background: white !important;
			width: 20rem;
			border: solid 1px lightgray !important;

		}

		.btn:hover {
			color: black !important;
		}

		.col-md-12 {
			margin: auto;
		}
	</style>

	<div class="main-panel" style="padding-top: 0;">
		<div class="content">
			<div class="container-fluid">
				<div class="row justify-content-center">
					<div class="col-md-12 justify-content-center">
						<form method="POST" action="">
							Send to: <select name="user" id="user">
								<option value="all">All</option>
								<?php
								$sql = "SELECT * FROM users ORDER BY username ASC";
								$result = mysqli_query($conn, $sql);
								while ($user = mysqli_fetch_assoc($result)) {

								?>
									<option value="<?php echo $user['username']; ?>"><?php echo $user['username']; ?></option>

								<?php } ?>
							</select>
							<label for="message">Message:</label>
							<input name="message" type="text" class="textarea">
							<input type="submit" value="send" class="btn btn-outline-success">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>

<!--   Core JS Files   -->
<script defer src="js/jquery-3.1.0.min.js" type="text/javascript"></script>
<script defer src="js/bootstrap.min.js" type="text/javascript"></script>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

<script defer src="js/material.min.js" type="text/javascript"></script>

<!--  Charts Plugin -->
<script defer src="js/chartist.min.js"></script>

<!--  Notifications Plugin    -->
<script defer src="js/bootstrap-notify.js"></script>

<!--  Google Maps Plugin    -->
<script defer type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

<!-- Material Dashboard javascript methods -->
<script defer src="js/material-dashboard.js"></script>

<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script defer src="js/demo.js"></script>

</html>
