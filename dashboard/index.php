<?php
include_once('../includes/login_status.php');

include_once('../includes/db_conf.php');

$marketer = 0;

if (isset($_SESSION['marketer'])) {
	$marketer = $_SESSION['marketer'];
}
if ($marketer == 1) {
	header('location: marketer.php');
}

$admin = $_SESSION['admin'];

// get user details from database
$username  = $_SESSION['username'];

$sql = "SELECT * FROM issues";
$resultz = mysqli_query($conn, $sql);
$issuecount = mysqli_num_rows($resultz);

$sql = "SELECT * FROM issues WHERE solved=1";
$unsolved = mysqli_query($conn, $sql);
$solvedcount = mysqli_num_rows($unsolved);

$sql = "SELECT * FROM issues WHERE solved=0";
$solved = mysqli_query($conn, $sql);
$unsolvedcount = mysqli_num_rows($solved);

$sql = "SELECT * FROM users WHERE username='" . $username . "'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
$balance = $user['balance'];
$plan = $user['plan'];
$phone = $user['phone'];

$phone = 0 . $phone;

$sql = "SELECT * FROM subscriptions WHERE username='" . $username . "'";
$result = mysqli_query($conn, $sql);

$server = "server";
$dbuser = "username";
$dbpass = "paswword";
$db = "";

$con = mysqli_connect($server, $dbuser, $dbpass, $db);
if (!$con) {
	header("location: ../nonet.php");
}

$sql = "SELECT * FROM users WHERE phone = '" . $phone . "'";
$balance_result = mysqli_query($con, $sql);
$balance_array = mysqli_fetch_array($balance_result);
$balance = $balance_array['balance'];

if ($plan == 1) {
	$color = "green";
} elseif ($plan == 2) {
	$color = "blue";
} elseif ($plan == 3) {
	$color = "purple";
} elseif ($plan == 5) {
	$color = "gold";
} else {
	$color = "red";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<link rel="shortcut icon" href="img/logo/favicon.ico" type="image/x-icon">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Dscon | <?php if ($admin == true) {
						echo 'Dashboard';
					} else {
						echo 'Profile';
					} ?></title>

	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
	<meta name="viewport" content="width=device-width" />

	<!-- Bootstrap core CSS     -->
	<link href="css/bootstrap.min.css" rel="stylesheet" />

	<!--  DSCON CSS    -->
	<link rel="stylesheet" href="../css/main.css">

	<link href="css/material-dashboard.css" rel="stylesheet" />

	<!--  CSS for Demo Purpose, don't include it in your project     -->
	<link href="css/demo.css" rel="stylesheet" />

	<script defer src="js/jquery-3.1.0.min.js" type="text/javascript"></script>

	<link rel="shortcut icon" href="..\images\logo\favicon.ico" type="image/x-icon">

	<style>
		.halloween-animation {
			position: relative;
			display: inline-block;
		}

		.halloween-animation::before,
		.halloween-animation::after {
			display: block;
			content: '';
			height: 20px;
			width: 15px;
			position: absolute;
			opacity: 0;
			transition: all 250ms ease-in-out;
		}

		.halloween-animation::before,
		.halloween-animation::after {
			opacity: 1;
		}

		.halloween-animation::before {
			/* to avoid transition jank in chrome make sure transitions don't include transform */
			height: 46px;
			width: 34px;
			right: -40px;
			animation: float-right 3s ease-in-out infinite;
		}

		.halloween-animation::after {
			height: 40px;
			width: 30px;
			top: -45px;
			transform: rotate(-10deg);
			animation: float-top 3s ease-in-out infinite;
		}

		@keyframes float-right {
			50% {
				transform: rotate(10deg) translate(0, -15px);
			}
		}

		@keyframes float-top {
			50% {
				transform: rotate(-5deg) translate(0, 10px);
			}
		}

		/* right ghost */
		.halloween-animation::before {
			right: 0;
			bottom: 0;
			background: url('data:image/svg+xml;charset=UTF8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="1742 35 735 948"><g fill="none" fill-rule="evenodd"><path fill="%23FFF" d="M2052.05 39.98c-10.07 1.2-19.85 3.97-29.69 6.34-8.44 2.19 74.98 3.97 66.82 7.11-36.96 12.18-71.94 30.4-103.05 53.79-73.46 54.63-124.66 137.83-141.31 227.77-6.86 40.15-11.48 80.86-10.36 121.65 1.75 75.91 19.77 151.74 54.62 219.34 2.41 4.14 4.02 8.64 6.06 12.95 15.09 23.61 25.44 50.32 29.74 78.03 8.73 53.72-9.2658 137.92-42.5558 180.89-3.84.98 3.3258 5.89 8.8058 6.74 29.87 10.22 166.94 7.5247 182.46 6.4647 15.75-1.22 91.55-17.2447 143.58-47.9047 12.63-7.95 25.52-15.58 37.37-24.67 8.19-6.1 16.34-12.25 24.44-18.47 27.26-22.61 52.84-47.41 75.04-75.06 51.81-63.17 88.5-138.48 107.44-217.89 13.79-56.78 18.28-115.76 13.79-174-.93-10.76-1.81-21.54-3.66-32.19-5.15-58.56-24.42-115.84-55.83-165.55-3.8-6.46-7.84-12.79-12.45-18.71-11.71-15.17-24.11-29.79-37.17-43.8-9.39-10.34-20.38-19.01-31.03-27.99-17.42-14.01-36.2-26.3-55.8-37.04-12.08-6.32-24.56-11.88-37.2-17.01-37.91-15.46-78.64-23.7-119.51-25.26-23.59-.72-47.27.48-70.55 4.47z"/><path fill="%23000" d="M2122.6 35.51c-23.59-.72-47.27.48-70.55 4.47-10.07 1.2-19.85 3.97-29.69 6.34-8.44 2.19-17.02 3.97-25.18 7.11-36.96 12.18-71.94 30.4-103.05 53.79-73.46 54.63-124.66 137.83-141.31 227.77-6.86 40.15-11.48 80.86-10.36 121.65 1.75 75.91 19.77 151.74 54.62 219.34 2.41 4.14 4.02 8.64 6.06 12.95 15.09 23.61 25.44 50.32 29.74 78.03 8.73 53.72-6.08 110.61-39.37 153.58-3.84.98-7.85 2.21-10.48 5.4-5.71 6.02-5.12 16.53 1.19 21.91 4.37 3.35 9.43 5.89 14.91 6.74 29.87 10.22 60.52 18.68 91.92 22.5 21.02 2.68 42.16 4.06 63.29 5.41 15.57.76 31.1-.77 46.62-1.83 15.75-1.22 31.49-2.8 47.13-5.06 59.62-10.02 117.05-31.8 169.08-62.46 12.63-7.95 25.52-15.58 37.37-24.67 8.19-6.1 16.34-12.25 24.44-18.47 27.26-22.61 52.84-47.41 75.04-75.06 51.81-63.17 88.5-138.48 107.44-217.89 13.79-56.78 18.28-115.76 13.79-174-.93-10.76-1.81-21.54-3.66-32.19-5.15-58.56-24.42-115.84-55.83-165.55-3.8-6.46-7.84-12.79-12.45-18.71-11.71-15.17-24.11-29.79-37.17-43.8-9.39-10.34-20.38-19.01-31.03-27.99-17.42-14.01-36.2-26.3-55.8-37.04-12.08-6.32-24.56-11.88-37.2-17.01-37.91-15.46-78.64-23.7-119.51-25.26zm47.26 36.34c30.07 5.19 58.97 15.75 86.4 28.96 25.87 12.83 49.95 29.26 71.58 48.38 12.73 10.28 23.2 22.95 33.91 35.22 9.87 11.9 20.08 23.68 27.71 37.19 31.1 49.1 49.13 106.28 52.23 164.29 2.09 7.55 2.33 15.41 2.95 23.18 6.95 96.22-13.01 194.32-57.67 279.88-35.16 67.75-85.82 127.61-147.75 172.36-11.54 9.06-24.13 16.64-36.54 24.43-30.33 17.98-62.52 32.9-96.13 43.63-28.71 9.54-58.46 16.06-88.61 18.74-14.96 1.5-29.96 2.55-44.97 3.44-12.98.78-25.94-.57-38.89-1.41-15.38-1.08-30.75-2.52-46.02-4.66-21.47-3.12-42.54-8.53-63.23-14.97 2.18-3.97 4.96-7.57 7.21-11.5 25.37-41.28 37.39-90.63 33.51-138.95-2.69-35.42-13.82-70.12-31.96-100.64-9.32-18.3-19.02-36.52-26.4-55.74-30.14-75.35-40.04-158.4-30.34-238.87.89-5.32 2.11-10.58 2.44-15.98 8.24-86.15 51.41-168.28 117.44-224.17 35.14-29.89 76.62-52.26 120.88-65.24 13.1-3.12 26.05-7.11 39.42-8.91 37.3-6.18 75.69-5.71 112.83 1.34z"/><path fill="%23000" d="M2338.46 350.832c-2.78-.8997-5.63-1.1284-8.48-1.1437-44 .0305-88.01 0-132.02.0305-7.34.0458-15.19 3.0342-20.44 11.2827-3.05 4.6198-4.48 11.923-2.78 18.1438 4.48 14.7742 16.58 18.4792 26.27 17.8388 42.01-.03 84.02-.015 126.03 0 7.98.473 16.63-1.128 22.97-9.178 3.87-4.65 6.29-12.944 4.26-20.217-2.63-9.666-9.44-14.683-15.81-16.756zm-320.51-1.1437c-43.98.0305-87.96 0-131.94.0305-6.72.0153-13.74 2.5158-19.02 9.1482-2.95 3.7202-5.22 9.3005-4.96 15.323.22 6.5562 3.21 12.0603 6.66 15.567 5.06 5.123 11.22 7.1814 17.23 7.2118h133.1c7.36-.061 15.24-3.0646 20.5-11.3436 3.21-4.9095 4.58-12.8074 2.44-19.15-2.89-8.95-9.33-13.6155-15.45-15.628-2.81-.915-5.69-1.159-8.56-1.159zM2148.57 851.7c-5.45-1.58-10.8.89-15.48 3.48-26.61 13.48-54.56 24.28-83.26 32.38-4.55 1.19-8.51 4.49-10.36 8.84-2.33 5.16-1.44 11.57 2.17 15.94 3.7 4.65 10.23 6.81 15.97 5.19 30.78-8.66 60.76-20.22 89.29-34.67 4.77-2.16 9.97-4.71 12-9.91 4.02-8.33-1.31-19.27-10.33-21.25zm-144 47.96c-3.75-1.53-7.85-.83-11.74-.33-6.54.9-13.12 1.46-19.69 2.16-4.64.53-8.97 3.29-11.37 7.31-3.14 5.04-2.96 11.95.45 16.82 3 4.42 8.42 7.13 13.77 6.65 8.54-.8 17.08-1.67 25.57-2.88 7.02-.98 12.78-7.34 13-14.43.47-6.57-3.81-13.07-9.99-15.3z"/></g><path fill-rule="evenodd" d="M2026.0306 548.049c21.0553.0065 44.4487.0087 68.12.0082.0106 8.537.023 14.5265.023 14.5265s-1.3466 14.3133 3.461 19.7992c5.7354 7.55 18.363 7.47 24.0185-.13 4.708-5.476 3.362-19.67 3.362-19.67s.009-6 .016-14.529c26.468-.003 52.154-.009 74.12-.015.011 8.545.023 14.543.023 14.543s-1.346 14.313 3.461 19.799c5.736 7.55 18.363 7.4702 24.019-.13 4.708-5.476 3.362-19.6698 3.362-19.6698s.009-6.0108.016-14.552c21.228-.007 34.553-.0125 34.553-.0125s14.314 1.3465 19.799-3.461c7.551-5.7354 7.471-18.363-.129-24.0185-5.476-4.708-19.6693-3.361-19.6693-3.361s-13.325-.004-34.545-.0085c-.007-11.844-.0295-22.1892-.0844-25.3335-.03-7.9396-7.1816-14.9117-15.1012-14.822-7.83-.359-15.161 6.224-15.59 14.064-.0812 3.276-.1146 13.9493-.1243 26.0854-21.968-.004-47.648-.008-74.1-.01-.007-11.8376-.03-22.1745-.085-25.317-.03-7.94-7.1816-14.912-15.101-14.822-7.83-.359-15.161 6.224-15.59 14.064-.0814 3.275-.1147 13.942-.1245 26.0733-23.683-.0006-47.074.001-68.1.0053-.007-11.839-.03-22.178-.0847-25.321-.03-7.9398-7.1815-14.912-15.101-14.822-7.83-.359-15.161 6.224-15.59 14.064-.081 3.276-.1143 13.951-.124 26.0885-29.1593.013-49.216.035-51.303.0713-7.9396.03-14.9117 7.1816-14.822 15.1013-.359 7.83 6.224 15.161 14.064 15.59 2.1634.0537 22.536.0865 52.0725.1054.011 8.5487.023 14.549.023 14.549s-1.346 14.313 3.4616 19.799c5.7353 7.5506 18.363 7.471 24.0184-.1297 4.708-5.476 3.3617-19.6694 3.3617-19.6694s.0088-6.0028.016-14.535z"/></svg>') no-repeat;
		}

		/* left ghost */
		.halloween-animation::after {
			top: 0;
			left: 50%;
			background: url('data:image/svg+xml;charset=UTF8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="12 15 713 940"><path fill="%23FFF" fill-rule="evenodd" d="M512.55 45.45c14.42 6.64 28.84 13.35 42.37 21.69 17.15 10 32.91 22.12 48.31 34.61 27.61 23.92 51.72 51.98 70.75 83.19 19.39 31.72 33.49 66.66 41.57 102.95 5.04 22.35 7.3 45.24 8.15 68.1-.06 151.66-.01 303.32-.02 454.98.1 5.63-.24 11.27.17 16.9 1.29 8.02-.66 16.07-2.1 23.93-8.22 38.75-34.91 73.24-70.8 90.14-22.36 11.06-48.14 15.17-72.84 11.85-25.79-2.59-50.28-14.23-69.78-31.12-12.09-9.98-21.62-22.77-29.05-36.51-19.52 36.18-57.22 62.02-98.14 66.54-6.69 1.07-13.47.44-20.2 1.02-22.82-.88-45.64-7.33-64.87-19.84-18.49-11.41-34.1-27.58-44.57-46.64-23.14 36.72-65.92 60.8-109.52 59.61-21.45.77 47.22-5.13 28.34-15.07-27.88-15.08-50.21-40.37-60.96-70.26-2.19-7.44-5.05-14.75-6.32-22.41-.1-108.03-.01-216.07-.04-324.1-.08-53.67.17-107.35-.17-161.02.45-20.26 2.6-40.49 6.65-60.35 3.26-16.5 8.28-32.61 13.69-48.51 21.75-59.51 60.55-112.51 110.27-151.73 52.51-41.63 89.586-40.54 156.146-47.95 62.86-7.24 64.874-25.06 122.964 0z"/><path fill-rule="evenodd" d="M326.92 18.1c62.86-7.24 127.54 2.29 185.63 27.35 14.42 6.64 28.84 13.35 42.37 21.69 17.15 10 32.91 22.12 48.31 34.61 27.61 23.92 51.72 51.98 70.75 83.19 19.39 31.72 33.49 66.66 41.57 102.95 5.04 22.35 7.3 45.24 8.15 68.1-.06 151.66-.01 303.32-.02 454.98.1 5.63-.24 11.27.17 16.9 1.29 8.02-.66 16.07-2.1 23.93-8.22 38.75-34.91 73.24-70.8 90.14-22.36 11.06-48.14 15.17-72.84 11.85-25.79-2.59-50.28-14.23-69.78-31.12-12.09-9.98-21.62-22.77-29.05-36.51-19.52 36.18-57.22 62.02-98.14 66.54-6.69 1.07-13.47.44-20.2 1.02-22.82-.88-45.64-7.33-64.87-19.84-18.49-11.41-34.1-27.58-44.57-46.64-23.14 36.72-65.92 60.8-109.52 59.61-21.45.77-42.78-5.13-61.66-15.07-27.88-15.08-50.21-40.37-60.96-70.26-2.19-7.44-5.05-14.75-6.32-22.41-.1-108.03-.01-216.07-.04-324.1-.08-53.67.17-107.35-.17-161.02.45-20.26 2.6-40.49 6.65-60.35 3.26-16.5 8.28-32.61 13.69-48.51C54.92 185.62 93.72 132.62 143.44 93.4c52.51-41.63 116.92-67.89 183.48-75.3zm-151.74 90.18c-53.05 37.67-94.21 92.08-115.14 153.77-2.31 7.61-4.66 15.22-6.84 22.87-5.79 22.59-8.87 45.85-9.44 69.16.25 6.99.26 13.97.16 20.96.01 152.66-.04 305.31.02 457.97 2.26 15.3 8.48 30.04 17.66 42.51 10.36 13.03 23 24.8 38.52 31.33 12.1 5.73 25.36 9.29 38.82 9.05 21.04 1.14 42.29-5.39 59.51-17.43 16.71-11.14 29.16-27.97 36.47-46.56 1.64-5.37 4.27-10.66 8.51-14.44 5.93-5 15.57-4.4 20.84 1.31 3.36 3.25 4.09 8.02 5.32 12.32 1.5 5.52 3.96 10.7 6.18 15.96 9.14 19.11 24.86 34.75 43.62 44.48 12.05 6.85 25.81 10.07 39.57 10.87 17.26 1.13 34.96-2.11 50.41-9.98 24.54-12.13 43.5-34.8 51.15-61.07 1.76-5.09 1.69-11.08 5.63-15.17 5.24-6.11 15.36-6.9 21.39-1.53 3.64 3.76 8.56 6.89 9.67 12.39 3.53 13.05 8.75 25.86 17.09 36.62 5.42 6.51 10.8 13.21 17.6 18.35 14.83 11.93 33.14 19.9 52.2 21.3 29.52 3.58 60.35-7.65 80.89-29.12 15.17-15 24.9-35.28 27.8-56.36-.06-158.6-.02-317.2-.02-475.8-.41-24.82-2.86-49.72-8.97-73.82-16.92-70.17-59.71-133.55-117.74-176.32-13.56-10.49-28.32-19.33-43.41-27.43-11.19-5.23-22.14-11.05-33.78-15.24-43.97-17.11-91.64-24.65-138.75-22.04-62.51 3.28-124.09 24.51-174.94 61.09z"/><path fill-rule="evenodd" d="M285.0306 563.049c21.0553.0065 44.4487.0087 68.12.0082.0106 8.537.023 14.5265.023 14.5265s-1.3466 14.3133 3.461 19.7992c5.7354 7.55 18.363 7.47 24.0185-.13 4.708-5.476 3.362-19.67 3.362-19.67s.009-6 .016-14.529c26.468-.003 52.154-.0088 74.12-.0146.011 8.5456.023 14.543.023 14.543s-1.346 14.3133 3.461 19.7992c5.736 7.5504 18.363 7.4706 24.019-.13 4.708-5.476 3.3617-19.6694 3.3617-19.6694s.0087-6.0108.016-14.552c21.2274-.007 34.553-.0125 34.553-.0125s14.3134 1.3465 19.799-3.461c7.5508-5.7354 7.471-18.363-.1295-24.0185-5.476-4.708-19.6695-3.361-19.6695-3.361s-13.325-.004-34.545-.0087c-.0068-11.8443-.0295-22.1894-.0844-25.3337-.03-7.9396-7.1815-14.9117-15.1012-14.822-7.83-.359-15.161 6.224-15.59 14.064-.0813 3.276-.1147 13.9493-.1244 26.0854-21.968-.004-47.648-.008-74.1-.01-.007-11.8374-.03-22.1743-.085-25.3172-.03-7.9396-7.1813-14.9117-15.101-14.822-7.83-.359-15.161 6.224-15.59 14.064-.0812 3.275-.1145 13.9424-.1243 26.0737-23.6828-.0005-47.074.001-68.1.0054-.007-11.839-.0298-22.178-.0847-25.321-.03-7.9397-7.1815-14.912-15.1012-14.822-7.83-.359-15.161 6.224-15.59 14.064-.081 3.276-.1142 13.951-.124 26.0886-29.159.013-49.2157.035-51.3027.0714-7.9398.03-14.912 7.1816-14.822 15.1013-.359 7.83 6.224 15.161 14.064 15.59 2.1632.0538 22.536.0866 52.0723.1055.0107 8.5488.023 14.549.023 14.549s-1.3465 14.3132 3.4612 19.799c5.7353 7.5507 18.363 7.471 24.0184-.1296 4.708-5.476 3.361-19.6695 3.361-19.6695s.0088-6.0025.016-14.5347z"/><path fill-rule="evenodd" d="M285.0306 563.049c21.0553.0065 44.4487.0087 68.12.0082.0106 8.537.023 14.5265.023 14.5265s-1.3466 14.3133 3.461 19.7992c5.7354 7.55 18.363 7.47 24.0185-.13 4.708-5.476 3.362-19.67 3.362-19.67s.009-6 .016-14.529c26.468-.003 52.154-.0088 74.12-.0146.011 8.5456.023 14.543.023 14.543s-1.346 14.3133 3.461 19.7992c5.736 7.5504 18.363 7.4706 24.019-.13 4.708-5.476 3.3617-19.6694 3.3617-19.6694s.0087-6.0108.016-14.552c21.2274-.007 34.553-.0125 34.553-.0125s14.3134 1.3465 19.799-3.461c7.5508-5.7354 7.471-18.363-.1295-24.0185-5.476-4.708-19.6695-3.361-19.6695-3.361s-13.325-.004-34.545-.0087c-.0068-11.8443-.0295-22.1894-.0844-25.3337-.03-7.9396-7.1815-14.9117-15.1012-14.822-7.83-.359-15.161 6.224-15.59 14.064-.0813 3.276-.1147 13.9493-.1244 26.0854-21.968-.004-47.648-.008-74.1-.01-.007-11.8374-.03-22.1743-.085-25.3172-.03-7.9396-7.1813-14.9117-15.101-14.822-7.83-.359-15.161 6.224-15.59 14.064-.0812 3.275-.1145 13.9424-.1243 26.0737-23.6828-.0005-47.074.001-68.1.0054-.007-11.839-.0298-22.178-.0847-25.321-.03-7.9397-7.1815-14.912-15.1012-14.822-7.83-.359-15.161 6.224-15.59 14.064-.081 3.276-.1142 13.951-.124 26.0886-29.159.013-49.2157.035-51.3027.0714-7.9398.03-14.912 7.1816-14.822 15.1013-.359 7.83 6.224 15.161 14.064 15.59 2.1632.0538 22.536.0866 52.0723.1055.0107 8.5488.023 14.549.023 14.549s-1.3465 14.3132 3.4612 19.799c5.7353 7.5507 18.363 7.471 24.0184-.1296 4.708-5.476 3.361-19.6695 3.361-19.6695s.0088-6.0025.016-14.5347zm313.5798-364.1015c7.406-5.3816 18.7875-2.2932 22.6707 5.9335 3.5 7.1947 9.626 14.871 6.989 23.3234-2.412 8.8785-13.573 13.681-21.681 9.3225-7.101-3.32-8.503-11.741-12.457-17.754-4.353-6.724-2.204-16.479 4.479-20.826zm-87.74-57.851c-4.3575-6.6798-2.4644-16.4218 4.165-20.8898 5.0258-3.7692 11.8582-3.3845 17.327-.864 15.6263 5.1925 30.027 14.2334 41.0928 26.4766 4.2127 3.706 6.76 8.7692 10.351 13.0144 2.7693 4.8485 6.4694 9.8098 6.139 15.6856-.2232 6.7787-5.4238 12.9862-12.0866 14.316-6.5563 1.6118-13.8753-1.7484-16.9455-7.7585-6.053-10.729-14.479-20.3458-25.289-26.4562-5.05-3.202-10.737-5.105-16.348-7.0385-3.4432-1.106-6.473-3.41-8.405-6.485zM254 401c33.137 0 60-26.863 60-60s-26.863-60-60-60-60 26.863-60 60 26.863 60 60 60zm220 0c33.137 0 60-26.863 60-60s-26.863-60-60-60-60 26.863-60 60 26.863 60 60 60z"/></svg>') no-repeat;
		}
	</style>

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

	<div class="main-panel" data-color="<?php echo $color; ?>" style="overflow: hidden;z-index:0">
		<div class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-3 col-md-6 col-sm-6">
						<div class="card card-stats">
							<div class="card-header" data-background-color="<?php echo $color; ?>">
								<i class="material-icons"><svg fill="white" xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24">
										<path fill="none" d="M0 0h24v24H0z" />
										<path d="M1 9l2 2c4.97-4.97 13.03-4.97 18 0l2-2C16.93 2.93 7.08 2.93 1 9zm8 8l3 3 3-3c-1.65-1.66-4.34-1.66-6 0zm-4-4l2 2c2.76-2.76 7.24-2.76 10 0l2-2C15.14 9.14 8.87 9.14 5 13z" /></svg></i>
							</div>

							<div class="card-content">
								<p class="category">Internet Usage</p>

								<h3 class="title"><?php
													require 'stats.php';
													echo $totalusage; ?><?php echo $size; ?></h3>
							</div>
							<div class="card-footer">
								<div class="stats">
									<i class="material-icons"><svg fill="#DCDCDC" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24">
											<path fill="none" d="M0 0h24v24H0z" />
											<path d="M1 9l2 2c4.97-4.97 13.03-4.97 18 0l2-2C16.93 2.93 7.08 2.93 1 9zm8 8l3 3 3-3c-1.65-1.66-4.34-1.66-6 0zm-4-4l2 2c2.76-2.76 7.24-2.76 10 0l2-2C15.14 9.14 8.87 9.14 5 13z" /></svg></i> Today's internet usage
								</div>
							</div>
						</div>
					</div>
					<?php if ($admin == true) { ?>
						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="card card-stats">
								<div class="card-header" data-background-color="<?php echo $color; ?>">
									<i class="material-icons"><svg fill="white" xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24">
											<path d="M0 0h24v24H0z" fill="none" />
											<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z" /></svg></i>
								</div>
								<div class="card-content">
									<p class="category">Active Clients</p>

									<h3 class="title"><?php
														echo $i; ?></h3>
								</div>
								<div class="card-footer">
									<div class="stats">
										<i class="material-icons"><svg fill="#DCDCDC" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24">
												<path d="M0 0h24v24H0z" fill="none" />
												<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z" /></svg></i> Real time active clients
									</div>
								</div>
							</div>`
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="card card-stats">
								<div class="card-header" data-background-color="<?php echo $color; ?>">
									<i class="material-icons"><svg fill="white" xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24">
											<path d="M18.6 6.62c-1.44 0-2.8.56-3.77 1.53L12 10.66 10.48 12h.01L7.8 14.39c-.64.64-1.49.99-2.4.99-1.87 0-3.39-1.51-3.39-3.38S3.53 8.62 5.4 8.62c.91 0 1.76.35 2.44 1.03l1.13 1 1.51-1.34L9.22 8.2C8.2 7.18 6.84 6.62 5.4 6.62 2.42 6.62 0 9.04 0 12s2.42 5.38 5.4 5.38c1.44 0 2.8-.56 3.77-1.53l2.83-2.5.01.01L13.52 12h-.01l2.69-2.39c.64-.64 1.49-.99 2.4-.99 1.87 0 3.39 1.51 3.39 3.38s-1.52 3.38-3.39 3.38c-.9 0-1.76-.35-2.44-1.03l-1.14-1.01-1.51 1.34 1.27 1.12c1.02 1.01 2.37 1.57 3.82 1.57 2.98 0 5.4-2.41 5.4-5.38s-2.42-5.37-5.4-5.37z" />
											<path fill="none" d="M0 0h24v24H0V0z" /></svg></i>
								</div>
								<div class="card-content">
									<p class="category">All Clients</p>

									<h3 class="title"><?php
														echo $x; ?></h3>
								</div>
								<div class="card-footer">
									<div class="stats">
										<i class="material-icons"><svg fill="#DCDCDC" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24">
												<path d="M18.6 6.62c-1.44 0-2.8.56-3.77 1.53L12 10.66 10.48 12h.01L7.8 14.39c-.64.64-1.49.99-2.4.99-1.87 0-3.39-1.51-3.39-3.38S3.53 8.62 5.4 8.62c.91 0 1.76.35 2.44 1.03l1.13 1 1.51-1.34L9.22 8.2C8.2 7.18 6.84 6.62 5.4 6.62 2.42 6.62 0 9.04 0 12s2.42 5.38 5.4 5.38c1.44 0 2.8-.56 3.77-1.53l2.83-2.5.01.01L13.52 12h-.01l2.69-2.39c.64-.64 1.49-.99 2.4-.99 1.87 0 3.39 1.51 3.39 3.38s-1.52 3.38-3.39 3.38c-.9 0-1.76-.35-2.44-1.03l-1.14-1.01-1.51 1.34 1.27 1.12c1.02 1.01 2.37 1.57 3.82 1.57 2.98 0 5.4-2.41 5.4-5.38s-2.42-5.37-5.4-5.37z" />
												<path fill="none" d="M0 0h24v24H0V0z" /></svg></i> All clients
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="card card-stats">
								<div class="card-header" data-background-color="<?php echo $color; ?>">
									<i class="material-icons"><svg fill="white" xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24">
											<path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
											<path d="M0 0h24v24H0z" fill="none" /></svg></i>
								</div>
								<div class="card-content">
									<p class="category">Mpesa Balance</p>
									<?php
									$sql = "SELECT orgaccountbalance FROM xialosu ORDER BY id DESC LIMIT 1";
									$result = mysqli_query($con, $sql);
									$revenue = mysqli_fetch_assoc($result);

									?>
									<h3 class="title">Kshs <?php echo number_format($revenue['orgaccountbalance']); ?></h3>
								</div>
								<div class="card-footer">
									<div class="stats">
										<i class="material-icons"><svg fill="#DCDCDC" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24">
												<path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
												<path d="M0 0h24v24H0z" fill="none" /></svg></i> Mpesa Account Balance
									</div>
								</div>
							</div>
						</div>
					<?php } ?>

					<?php if ($admin == false) { ?>

						<?php if ((isset($uptimelimit))) {
						?>
							<div class="col-lg-3 col-md-6 col-sm-6">
								<div class="card card-stats">
									<div class="card-header" data-background-color="<?php echo $color; ?>">
										<i class="material-icons"><svg fill="white" xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24">
												<path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z" />
												<path d="M0 0h24v24H0z" fill="none" />
												<path d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z" /></svg></i>
									</div>
									<div class="card-content">
										<p class="category">Time Left</p>
										<h3 class="title"><?php echo $uptimelimit; ?></h3>
									</div>
									<div class="card-footer">
										<div class="stats">
											<i class="material-icons"><svg fill="#DCDCDC" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24">
													<path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z" />
													<path d="M0 0h24v24H0z" fill="none" />
													<path d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z" /></svg></i> 1 Month Subscription
										</div>
									</div>
								</div>
							</div>
						<?php }
						?>
						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="card card-stats">
								<div class="card-header" data-background-color="<?php echo $color; ?>">
									<i class="material-icons">
										<svg fill="white" xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24">
											<path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
											<path d="M0 0h24v24H0z" fill="none" /></svg>
									</i>
								</div>
								<div class="card-content">
									<p class="category">Balance</p>
									<h3 class="title">Kshs <?php echo number_format($balance); ?></h3>
								</div>
								<?php if ($balance < 50) {
								?>
									<div class="card-footer">
										<div class="stats">
											<i class="material-icons"><svg fill="#DCDCDC" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24">
													<path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
													<path d="M0 0h24v24H0z" fill="none" /></svg></i>Top up to enjoy our subscriptions.
										</div>
									</div>
								<?php
								} else {
								?>
									<div class="card-footer">
										<div class="stats">
											<i class="material-icons"><svg fill="#DCDCDC" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24">
													<path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
													<path d="M0 0h24v24H0z" fill="none" /></svg></i>You can enjoy our subscriptions!
										</div>
									</div>
								<?php
								}
								?>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="card card-stats">
								<div class="card-header" data-background-color="<?php echo $color; ?>">
									<i class="material-icons"><svg fill="white" xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24">
											<path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z" />
											<path d="M0 0h24v24H0z" fill="none" />
											<path d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z" /></svg></i>
								</div>
								<div class="card-content">
									<p class="category">Up time</p>
									<h3 class="title"><?php echo $uptime; ?></h3>
								</div>
								<div class="card-footer">
									<div class="stats">
										<i class="material-icons"><svg fill="#DCDCDC" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24">
												<path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z" />
												<path d="M0 0h24v24H0z" fill="none" />
												<path d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z" /></svg></i>Time since subscription.
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="card card-stats">
								<div class="card-header" data-background-color="<?php echo $color; ?>">
									<i class="material-icons"><svg fill="white" xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24">
											<path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
											<path d="M0 0h24v24H0z" fill="none" /></svg></i>
								</div>
								<div class="card-content" style="padding-bottom: 5px;">
									<br>
									<span>Paybill : <span style="font-weight: 700; font-size: 1em">196969</span> </span>
									<span>Acccount no. <span style="font-weight: 700; font-size: 1em"> <?php echo "0" . $user['phone']; ?></span></span>
								</div>
								<div class="card-footer">
									<div class="stats">
										<i class="material-icons"><svg fill="#DCDCDC" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24">
												<path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
												<path d="M0 0h24v24H0z" fill="none" /></svg></i>Top up option
									</div>
								</div>
							</div>
						</div>
					<?php } ?>

				</div>
			</div>
			<div class="row">
				<?php if ($admin == false) { ?>
					<div class="col-md-3">
						<div class="card">
							<div class="card-header bg-light" data-background-color="<?php echo $color; ?>">
								<h5 class=" text-light" style="color: white;">Subscribed Services</h5>
							</div>
							<div class=" card-content">
								<ol>
									<?php
									$count = mysqli_num_rows($result);
									if ($count > 0) {
										while ($subscr = mysqli_fetch_array($result)) {
									?>
											<li><?php echo $subscr['subscription']; ?></li>
										<?php
										}
									} else {
										?>
										<span> You are currently not subscribed to any services.
										<?php
									}
										?>
								</ol>
							</div>
							<div class="card-footer">
								<div class="stats">
									<i class="material-icons"><svg fill="#DCDCDC" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24">
											<path fill="none" d="M0 0h24v24H0z" />
											<circle cx="6.18" cy="17.82" r="2.18" />
											<path d="M4 4.44v2.83c7.03 0 12.73 5.7 12.73 12.73h2.83c0-8.59-6.97-15.56-15.56-15.56zm0 5.66v2.83c3.9 0 7.07 3.17 7.07 7.07h2.83c0-5.47-4.43-9.9-9.9-9.9z" /></svg></i> Your subscriptions
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card">
							<div class="card-header card-chart" data-background-color="<?php echo $color; ?>">
								<?php
								$sql = "SELECT * FROM movies ORDER BY RAND() DESC LIMIT 1";
								$res = mysqli_query($conn, $sql);
								$movie = mysqli_fetch_assoc($res);
								?>
								<a title="click to play" style="height: 300px;" href="http://dsconlimited.net/movie/player.php?movie=<?php echo $movie['name']; ?>"><img style="height: 200px!important" class="lazy" data-src="http://dsconlimited.net/dsconlimitedmovies/<?php echo $movie['cover']; ?>"></a>
							</div>
							<div class="card-content">
								<h6 class="title">Recommended Movie</h6>
								<p class="category">
									<?php echo $movie['name']; ?>
								</p>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card">
							<div class="card-header card-chart" data-background-color="<?php echo $color; ?>">
								<?php
								$sql = "SELECT * FROM series ORDER BY RAND() DESC LIMIT 1";
								$res = mysqli_query($conn, $sql);
								$movie = mysqli_fetch_assoc($res);
								?>
								<a title="click to play" style="height: 300px;" href="http://dsconlimited.net/movie/series.php?tv-show=<?php echo $movie['seriesname']; ?>"><img class="lazy" style="height: 200px!important" data-src="http://dsconlimited.net/dsconlimitedseries/<?php echo $movie['seriesname'] . "/" . $movie['poster']; ?>"></a>
							</div>
							<div class="card-content">
								<h6 class="title">Recommended Tv Show</h6>
								<p class="category">
									<?php echo $movie['seriesname']; ?>
								</p>
							</div>

						</div>
					</div>

				<?php } ?>
			</div>
		</div>
		<?php if ($admin == true) { ?>
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-3 col-md-6 col-sm-6 according-gender" style="margin-top: -85px;">
						<div class="card card-stats">
							<?php $sql = "SELECT COUNT(*) as total FROM users WHERE gender = 'Female'";
							$result = mysqli_query($conn, $sql);
							$female = mysqli_fetch_assoc($result);
							$femaleno = $female['total'];

							$sql = "SELECT COUNT(*) as total FROM users WHERE gender = 'Male'";
							$result = mysqli_query($conn, $sql);
							$male = mysqli_fetch_assoc($result);
							$maleno = $male['total']; ?>

							<canvas id="doughnut-chart" width="400" height="400"></canvas>
							<link rel="stylesheet" href="css/chartjs.min.css">
							<script src="js/chartjs.min.js" charset="utf-8"></script>

							<script>
								new Chart(document.getElementById("doughnut-chart"), {
									type: 'doughnut',
									data: {
										labels: ["Male", "Female"],
										datasets: [{
											label: "Population (millions)",
											backgroundColor: ["#3e95cd", "#c45850"],
											data: [<?php echo $maleno; ?>, <?php echo $femaleno; ?>]
										}]
									},
									options: {
										title: {
											display: true,
											text: 'Subscribers according to gender.'
										}
									}
								});
							</script>
						</div>
					</div>
				<?php } ?>
				<?php if ($admin == true) { ?>
					<div class="col-lg-3 col-md-6 col-sm-6 according-house" style="margin-top: -85px;">
						<div class="card card-stats">

							<?php $sql = "SELECT COUNT(*) as total FROM users WHERE apartment like '%plaza%'";
							$result = mysqli_query($conn, $sql);
							$plaza = mysqli_fetch_assoc($result);
							$plazano = $plaza['total'];

							$sql = "SELECT COUNT(*) as total FROM users WHERE apartment like '%baraka%'";
							$result = mysqli_query($conn, $sql);
							$baraka = mysqli_fetch_assoc($result);
							$barakano = $baraka['total'];

							$sql = "SELECT COUNT(*) as total FROM users WHERE apartment like '%victon%'";
							$result = mysqli_query($conn, $sql);
							$victon = mysqli_fetch_assoc($result);
							$victonno = $victon['total'];

							$sql = "SELECT COUNT(*) as total FROM users WHERE apartment like '%varsity%'";
							$result = mysqli_query($conn, $sql);
							$varsity = mysqli_fetch_assoc($result);
							$varsityno = $varsity['total'];

							$sql = "SELECT COUNT(*) as total FROM users WHERE apartment like '%ibis%'";
							$result = mysqli_query($conn, $sql);
							$ibis = mysqli_fetch_assoc($result);
							$ibisno = $ibis['total'];

							$sql = "SELECT COUNT(*) as total FROM users WHERE apartment like '%phemsi%'";
							$result = mysqli_query($conn, $sql);
							$phemsi = mysqli_fetch_assoc($result);
							$phemsino = $phemsi['total'];

							$sql = "SELECT COUNT(*) as total FROM users WHERE apartment like '%joymwa%'";
							$result = mysqli_query($conn, $sql);
							$joymwa = mysqli_fetch_assoc($result);
							$joymwano = $joymwa['total'];
							?>
							<canvas id="bar-chart" width="400" height="400"></canvas>
							<script>
								// Bar chart
								new Chart(document.getElementById("bar-chart"), {
									type: 'bar',
									data: {
										labels: ["Varsity", "CK Plaza", "Joymwa", "Victon", "Phemsi", "Ibis", "Baraka"],
										datasets: [{
											label: "Population",
											backgroundColor: ["#3e95cd", "#8e5ea2", "green", "#3cba9f", "#e8c3b9", "#c45850", "#8e5ea2"],
											data: [<?php echo $varsityno; ?>, <?php echo $plazano; ?>, <?php echo $joymwano; ?>, <?php echo $victonno; ?>, <?php echo $phemsino; ?>, <?php echo $ibisno; ?>, <?php echo $barakano; ?>]
										}]
									},
									options: {
										legend: {
											display: false
										},
										title: {
											display: true,
											text: 'Subscribers grouped by House'
										}
									}
								});
							</script>
						</div>
					</div>
				<?php } ?>

				<?php if ($admin == true) { ?>
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-3 col-md-6 col-sm-6 issues" style="margin-top: -75px;">
								<div class="card card-stats">
									<div class="card-header" data-background-color="<?php echo $color; ?>">
										<i class="material-icons"><svg fill="white" xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24">
												<path d="M0 0h24v24H0z" fill="none" />
												<path d="M20 8h-2.81c-.45-.78-1.07-1.45-1.82-1.96L17 4.41 15.59 3l-2.17 2.17C12.96 5.06 12.49 5 12 5c-.49 0-.96.06-1.41.17L8.41 3 7 4.41l1.62 1.63C7.88 6.55 7.26 7.22 6.81 8H4v2h2.09c-.05.33-.09.66-.09 1v1H4v2h2v1c0 .34.04.67.09 1H4v2h2.81c1.04 1.79 2.97 3 5.19 3s4.15-1.21 5.19-3H20v-2h-2.09c.05-.33.09-.66.09-1v-1h2v-2h-2v-1c0-.34-.04-.67-.09-1H20V8zm-6 8h-4v-2h4v2zm0-4h-4v-2h4v2z" /></svg></i>
									</div>
									<div class="card-content">
										<p class="category">Issues</p>

										<h3 class="title"><?php

															echo $issuecount; ?></h3>
									</div>
									<div class="card-footer">
										<div class="stats">
											<i class="material-icons"><svg fill="#DCDCDC" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24">
													<path d="M0 0h24v24H0z" fill="none" />
													<path d="M20 8h-2.81c-.45-.78-1.07-1.45-1.82-1.96L17 4.41 15.59 3l-2.17 2.17C12.96 5.06 12.49 5 12 5c-.49 0-.96.06-1.41.17L8.41 3 7 4.41l1.62 1.63C7.88 6.55 7.26 7.22 6.81 8H4v2h2.09c-.05.33-.09.66-.09 1v1H4v2h2v1c0 .34.04.67.09 1H4v2h2.81c1.04 1.79 2.97 3 5.19 3s4.15-1.21 5.19-3H20v-2h-2.09c.05-.33.09-.66.09-1v-1h2v-2h-2v-1c0-.34-.04-.67-.09-1H20V8zm-6 8h-4v-2h4v2zm0-4h-4v-2h4v2z" /></svg></i> Total Issues
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
						<?php if ($admin == true) { ?>
							<div class="col-lg-3 col-md-6 col-sm-6 issues" style="margin-top: -75px;">
								<div class="card card-stats">
									<div class="card-header" data-background-color="<?php echo $color; ?>">
										<i class="material-icons"><svg fill="white" xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24">
												<path clip-rule="evenodd" fill="none" d="M0 0h24v24H0z" />
												<path d="M22.7 19l-9.1-9.1c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3L9 6 6 9 1.6 4.7C.4 7.1.9 10.1 2.9 12.1c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.5-.4.5-1.1.1-1.4z" /></svg></i>
									</div>
									<div class="card-content">
										<p class="category">Unsolved Issues</p>
										<h3 class="title"><?php echo $unsolvedcount; ?></h3>
									</div>
									<div class="card-footer">
										<div class="stats">
											<i class="material-icons"><svg fill="#DCDCDC" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24">
													<path d="M0 0h24v24H0z" fill="none" />
													<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z" /></svg></i> Unsolved Issues
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-6 col-sm-6 issues" style="margin-top: -35px;">
								<div class="card card-stats">
									<div class="card-header" data-background-color="<?php echo $color; ?>">
										<i class="material-icons"><svg fill="white" xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24">
												<path d="M0 0h24v24H0z" fill="none" />
												<path d="M18 7l-1.41-1.41-6.34 6.34 1.41 1.41L18 7zm4.24-1.41L11.66 16.17 7.48 12l-1.41 1.41L11.66 19l12-12-1.42-1.41zM.41 13.41L6 19l1.41-1.41L1.83 12 .41 13.41z" /></svg></i>
									</div>
									<div class="card-content">
										<p class="category">Solved Issues</p>
										<h3 class="title"><?php
															echo $solvedcount; ?></h3>
									</div>
									<div class="card-footer">
										<div class="stats">
											<i class="material-icons"><svg fill="#DCDCDC" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24">
													<path d="M18.6 6.62c-1.44 0-2.8.56-3.77 1.53L12 10.66 10.48 12h.01L7.8 14.39c-.64.64-1.49.99-2.4.99-1.87 0-3.39-1.51-3.39-3.38S3.53 8.62 5.4 8.62c.91 0 1.76.35 2.44 1.03l1.13 1 1.51-1.34L9.22 8.2C8.2 7.18 6.84 6.62 5.4 6.62 2.42 6.62 0 9.04 0 12s2.42 5.38 5.4 5.38c1.44 0 2.8-.56 3.77-1.53l2.83-2.5.01.01L13.52 12h-.01l2.69-2.39c.64-.64 1.49-.99 2.4-.99 1.87 0 3.39 1.51 3.39 3.38s-1.52 3.38-3.39 3.38c-.9 0-1.76-.35-2.44-1.03l-1.14-1.01-1.51 1.34 1.27 1.12c1.02 1.01 2.37 1.57 3.82 1.57 2.98 0 5.4-2.41 5.4-5.38s-2.42-5.37-5.4-5.37z" />
													<path fill="none" d="M0 0h24v24H0V0z" /></svg></i> Solved Issues
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-6 col-sm-6 issues" style="margin-top: -35px;">
								<div class="card card-stats">
									<div class="card-header" data-background-color="<?php echo $color; ?>">
										<i class="material-icons"><svg fill="white" xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24">
												<path d="M0 0h24v24H0z" fill="none" />
												<path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z" /></svg></i>
									</div>
									<div class="card-content">
										<?php
										$sql = "SELECT * FROM users WHERE DATE(last_activity) = CURDATE()";
										$result = mysqli_query($conn, $sql);
										$number = mysqli_num_rows($result);

										?>
										<p class="category">Total active users today</p>
										<h3 class="title"><?php echo $number; ?></h3>
									</div>
									<div class="card-footer">
										<div class="stats">
											<i class="material-icons"><svg fill="#DCDCDC" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24">
													<path d="M0 0h24v24H0z" fill="none" />
													<path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z" /></svg></i>Active users today
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<div class="container-fluid">
				<div class="row">
					<?php if ($admin == true) { ?>
						<div class="col-lg-6 col-md-6 col-sm-6 payments-house" style="margin-top: -100px;">
							<div class="card card-stats">
								<?php
								$sql = "SELECT * FROM no_payments_house WHERE DATE(date) = CURDATE() ORDER BY date DESC LIMIT 6";
								$result = mysqli_query($conn, $sql);
								while ($payments = mysqli_fetch_assoc($result)) {
									$house = $payments['house'];
									if ($house == 'CK Plaza') {
										$plaza = $payments['payments'];
									} elseif ($house == 'Varsity') {
										$varsity = $payments['payments'];
									} elseif ($house == 'Ibis') {
										$ibis = $payments['payments'];
									} elseif ($house == 'Phemsi') {
										$phemsi = $payments['payments'];
									} elseif ($house == 'Victon') {
										$victon = $payments['payments'];
									} elseif ($house == 'Joymwa') {
										$joymwa = $payments['payments'];
									}
								}

								?>
								<canvas id="pie-chart" width="800" height="450"></canvas>
								<script type="text/javascript">
									new Chart(document.getElementById("pie-chart"), {
										type: 'doughnut',
										data: {
											labels: ["Varsity", "CK Plaza", "Joymwa", "Victon", "Phemsi", "Ibis"],
											datasets: [{
												label: "Population (millions)",
												backgroundColor: ["#3e95cd", "#8e5ea2", "green", "#3cba9f", "#e8c3b9", "#c45850"],
												data: [<?php echo $varsity; ?>, <?php echo $plaza; ?>, <?php echo $joymwa; ?>, <?php echo $victon; ?>, <?php echo $phemsi; ?>, <?php echo $ibis; ?>]
											}]
										},
										options: {
											title: {
												display: true,
												text: 'Payments per House (today)'
											}
										}
									});
								</script>

							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 trend-users" style="margin-top: -45px">
							<div class="card card-stats">
								<?php
								$dbname = "stats";

								$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
								$conn->set_charset('utf8');
								if (!$conn) {
									die('Connection refused');
								}

								$totalusers = array();
								$totaldays = array();
								$sql = "SELECT date, number, day(date) as Day FROM daily_total_active_users WHERE DATE(date) >= CURDATE() - INTERVAL 6 DAY";
								$result = mysqli_query($conn, $sql);
								while ($users = mysqli_fetch_assoc($result)) {
									$day = $users['Day'];
									$number = $users['number'];
									array_push($totalusers, $number);
									array_push($totaldays, $day);
								}
								$js_array = json_encode($totaldays);
								$totalusers = json_encode($totalusers);
								?>

								<canvas id="line-chart" width="800" height="450"></canvas>

								<script>
									new Chart(document.getElementById("line-chart"), {
										type: 'line',
										data: {
											labels: <?php echo $js_array; ?>,
											datasets: [{
												data: <?php echo $totalusers; ?>,
												label: "Users",
												borderColor: "blue",
												fill: false
											}]
										},
										options: {
											title: {
												display: true,
												text: 'Trend of Active Users(Weekly)'
											}
										}
									});
								</script>
							</div>
						</div>
					<?php } ?>
				</div>

			</div>
			<?php if ($admin == true) { ?>
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-3 col-md-6 col-sm-6 monthly-income" style="margin-top: -95px;">
							<div class="card card-stats">
								<div class="card-header" data-background-color="<?php echo $color; ?>">
									<i class="material-icons"><svg fill="white" xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24">
											<path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
											<path d="M0 0h24v24H0z" fill="none" /></svg></i>
								</div>
								<div class="card-content">
									<p class="category">Monthly Income (<?php echo date('M'); ?>)</p>

									<h3 class="title"><?php
														$sql = "SELECT SUM(amount) AS total FROM xialosu WHERE MONTH(TransTime) = MONTH(CURRENT_DATE())
															AND YEAR(TransTime) = YEAR(CURRENT_DATE())";
														$result = mysqli_query($con, $sql);
														$money = mysqli_fetch_assoc($result);
														$sum = $money['total'];
														echo "kshs " . number_format($sum); ?>
									</h3>
								</div>
								<div class="card-footer">
									<div class="stats">
										<i class="material-icons"><svg fill="#DCDCDC" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24">
												<path d="M0 0h24v24H0z" fill="none" />
												<path d="M20 8h-2.81c-.45-.78-1.07-1.45-1.82-1.96L17 4.41 15.59 3l-2.17 2.17C12.96 5.06 12.49 5 12 5c-.49 0-.96.06-1.41.17L8.41 3 7 4.41l1.62 1.63C7.88 6.55 7.26 7.22 6.81 8H4v2h2.09c-.05.33-.09.66-.09 1v1H4v2h2v1c0 .34.04.67.09 1H4v2h2.81c1.04 1.79 2.97 3 5.19 3s4.15-1.21 5.19-3H20v-2h-2.09c.05-.33.09-.66.09-1v-1h2v-2h-2v-1c0-.34-.04-.67-.09-1H20V8zm-6 8h-4v-2h4v2zm0-4h-4v-2h4v2z" /></svg></i> Total Issues
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
					<?php if ($admin == true) { ?>
						<div class="col-lg-3 col-md-6 col-sm-6 yearly-income" style="margin-top: -95px;">
							<div class="card card-stats">
								<div class="card-header" data-background-color="<?php echo $color; ?>">
									<i class="material-icons"><svg fill="white" xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24">
											<path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
											<path d="M0 0h24v24H0z" fill="none" /></svg></i>
								</div>
								<div class="card-content">
									<p class="category">Yearly Income (<?php echo date('Y'); ?>)</p>
									<h3 class="title"><?php $sql = "SELECT SUM(amount) AS total FROM xialosu WHERE YEAR(TransTime) = YEAR(CURRENT_DATE())";
														$result = mysqli_query($con, $sql);
														$money = mysqli_fetch_assoc($result);
														$sum = $money['total'];
														echo "kshs " . number_format($sum); ?></h3>
								</div>
								<div class="card-footer">
									<div class="stats">
										<i class="material-icons"><svg fill="#DCDCDC" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24">
												<path d="M0 0h24v24H0z" fill="none" />
												<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z" /></svg></i> Unsolved Issues
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 monthly-income-trend" style="margin-top: -45px">
							<div class="card card-stats">
								<?php
								include '../includes/stats_db.php';

								// declare arrays
								$amountarray = $montharray = array();

								$sql = "SELECT MONTH(date) AS Month, amount FROM monthly_income WHERE YEAR(date) = YEAR(CURDATE())";
								$result = mysqli_query($conn, $sql);
								while ($monthly = mysqli_fetch_assoc($result)) {
									$month = $monthly['Month'];
									$amount = $monthly['amount'];

									$dateObj = DateTime::createFromFormat('!m', $month);
									$monthName = $dateObj->format('F');
									$monthName = substr($monthName, 0, 3);

									array_push($amountarray, $amount);
									array_push($montharray, $monthName);
								}

								$amountarray = json_encode($amountarray);
								$montharray = json_encode($montharray);

								?>

								<canvas id="monthly" width="800" height="450"></canvas>

								<script>
									// Bar chart
									new Chart(document.getElementById("monthly"), {
										type: 'bar',
										data: {
											labels: <?php echo $montharray; ?>,
											datasets: [{
												label: "Money",
												backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"],
												data: <?php echo $amountarray; ?>
											}]
										},
										options: {
											legend: {
												display: false
											},
											title: {
												display: true,
												text: 'Monthly Income Trend (<?php echo date('Y'); ?>)'
											}
										}
									});
								</script>
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 yearly-income-trend" style="margin-top: -23%">
							<div class="card card-stats">
								<?php
								// declare arrays
								$amountarray = $yeararray = array();

								$sql = "SELECT YEAR(date) AS Year, amount FROM yearly_income";
								$result = mysqli_query($conn, $sql);
								while ($yearly = mysqli_fetch_assoc($result)) {
									$year = $yearly['Year'];
									$amount = $yearly['amount'];

									array_push($amountarray, $amount);
									array_push($yeararray, $year);
								}

								$amountarray = json_encode($amountarray);
								$yeararray = json_encode($yeararray);

								?>

								<canvas id="yearly" width="800" height="450"></canvas>

								<script>
									// Bar chart
									new Chart(document.getElementById("yearly"), {
										type: 'bar',
										data: {
											labels: <?php echo $yeararray; ?>,
											datasets: [{
												label: "Money",
												backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"],
												data: <?php echo $amountarray; ?>
											}]
										},
										options: {
											legend: {
												display: false
											},
											title: {
												display: true,
												text: 'Yearly Income Trend'
											}
										}
									});
								</script>
							</div>
						</div>
					<?php } ?>
					</div>
				</div>
	</div>
	</div>
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>

	<script src="js/bootstrap-notify.js" charset="utf-8"></script>

	<?php
	if ($admin != 1) {
		$sql = "SELECT id FROM notifications WHERE username = '" . $username . "'";
		$result = mysqli_query($conn, $sql);
		$count = mysqli_num_rows($result);
		if ($count != 0) { ?>
			<script type="text/javascript">
				$.notify("<strong>You have new notifications!</strong>", {
					animate: {
						enter: 'animated fadeInRight',
						exit: 'animated fadeOutRight'
					},
					placement: {
						from: "bottom",
						align: "right"
					},
					type: "warning"
				});
			</script>
	<?php
		}
	}
	?>

	<script>
		/* lazyload.js (c) Lorenzo Giuliani
		 * MIT License (http://www.opensource.org/licenses/mit-license.html)
		 *
		 * expects a list of:
		 * `<img src="blank.gif" data-src="my_image.png" width="600" height="400" class="lazy">`
		 */

		! function(window) {
			var $q = function(q, res) {
					if (document.querySelectorAll) {
						res = document.querySelectorAll(q);
					} else {
						var d = document,
							a = d.styleSheets[0] || d.createStyleSheet();
						a.addRule(q, 'f:b');
						for (var l = d.all, b = 0, c = [], f = l.length; b < f; b++)
							l[b].currentStyle.f && c.push(l[b]);

						a.removeRule(0);
						res = c;
					}
					return res;
				},
				addEventListener = function(evt, fn) {
					window.addEventListener ?
						this.addEventListener(evt, fn, false) :
						(window.attachEvent) ?
						this.attachEvent('on' + evt, fn) :
						this['on' + evt] = fn;
				},
				_has = function(obj, key) {
					return Object.prototype.hasOwnProperty.call(obj, key);
				};

			function loadImage(el, fn) {
				var img = new Image(),
					src = el.getAttribute('data-src');
				img.onload = function() {
					if (!!el.parent)
						el.parent.replaceChild(img, el)
					else
						el.src = src;

					fn ? fn() : null;
				}
				img.src = src;
			}

			function elementInViewport(el) {
				var rect = el.getBoundingClientRect()

				return (
					rect.top >= 0 &&
					rect.left >= 0 &&
					rect.top <= (window.innerHeight || document.documentElement.clientHeight)
				)
			}

			var images = new Array(),
				query = $q('img.lazy'),
				processScroll = function() {
					for (var i = 0; i < images.length; i++) {
						if (elementInViewport(images[i])) {
							loadImage(images[i], function() {
								images.splice(i, i);
							});
						}
					};
				};
			// Array.prototype.slice.call is not callable under our lovely IE8
			for (var i = 0; i < query.length; i++) {
				images.push(query[i]);
			};

			processScroll();
			addEventListener('scroll', processScroll);

		}(this);
	</script>


	<script src="js/javascript.modal.js"></script>

	<!-- jQuery Modal -->
	<script src="js/jquery.modal.min.js"></script>
	<link rel="stylesheet" href="css/jquery.modal.min.css" />

	<!-- modal to get user information -->
	<?php
	include '../includes/db_conf.php';
	$sql = "SELECT * FROM users WHERE username = '" . $username . "'";
	$result = mysqli_query($conn, $sql);
	$user = mysqli_fetch_assoc($result);
	$firstname = $user['firstname'];
	if (empty($firstname)) {
	?>
		<!-- Normal link -->
		<form class="form" id="details-modal" action="details.php" method="post">
			<h4>To continue using our services please enter the following details.</h4>
			<div class="form-group">
				<label for="firstname" style="color:black">First Name</label>
				<input type="text" style="color: black;" class="form-control" id="firstname" name="firstname" required>
			</div>
			<div class="form-group">
				<label for="secondname" style="color:black">Second Name</label>
				<input type="text" style="color: black;" class="form-control" id="secondname" name="secondname" required>
			</div>
			<div class="form-group">
				<label for="apartment" style="color:black">House Name</label>
				<input type="text" style="color: black;" class="form-control" placeholder="Eg. Executive" id="apartment" name="apartment" required>
			</div>
			<div class="form-group form-check">
				<label for="gender" style="color:black">Gender</label>
				<select class="form-control" name="gender" required>
					<option value="Male">Male</option>
					<option value="Female">Female</option>
				</select>
			</div>
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>

		<script>
			$('#details-modal').modal({
				escapeClose: false,
				clickClose: false,
				showClose: false
			});
		</script>
	<?php } ?>
</body>

</html>