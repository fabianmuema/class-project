<?php
header('Content-Type: text/html; charset=utf-8');

session_start();

if (isset($_SESSION['error'])) {
	$error = $_SESSION['error'];
}

include 'includes/db_conf.php';
include 'routeros_api.class.php';

if (isset($_SESSION['username'])) {
	$_SESSION['loggedin'] = true;
	$sql = "UPDATE users SET last_activity = '" . $date . "' WHERE username = '" . $username . "'";
	mysqli_query($conn, $sql);
	header("location: dashboard/");
}

if(isset($_COOKIE['remember_me'])) {
	$cookie = $_COOKIE['remember_me'];
	$sql = "SELECT admin, password, active, username FROM users WHERE cookie = '" . $cookie . "'";
	$result = mysqli_query($conn, $sql);
	$rows = mysqli_num_rows($result);
	if($rows > 0) {
		$user = mysqli_fetch_assoc($result);
		$username = $user['username'];
		$password = $user['password'];
		$active = $user['active'];
		$_SESSION['username'] = $username;
		$_SESSION['loggedin'] = true;
		$_SESSION['admin'] = $user['admin'];
		$sql = "UPDATE users SET last_activity = '" . $date . "' WHERE username = '" . $username . "'";
		mysqli_query($conn, $sql);
		$localip = $_SERVER['REMOTE_ADDR'];
		if ($active == 1) {
			$API = new RouterosAPI();

			if ($API->connect('192.166.29.1', 'admin', '12345678A')) {
				$ARRAY = $API->comm('/ip/hotspot/active/login', array(
					"user" => $username,
					"password" => $password,
					"ip" => $localip
				));
				header("location: dashboard/");
			}
		} else {
			header("location: dashboard/");
		}
	}
}

?>

<!doctype html>
<html lang="en">

<head>
	<title>Dscon | Login</title>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" href="img/logo/favicon.ico" type="image/x-icon">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> <!-- Bootstrap CSS -->
	<link rel="stylesheet" href="bootstrap\css\bootstrap.min.css">
	<link rel="stylesheet" href="css/login.css">
</head>

<body>
	<!--================Login Box Area =================-->
	<section class="login_box_area section_gap">
		<div class="row">

			<div class="login_form_inner">

				<form class="row login_form" action="login.php" method="post" id="loginForm">
					<div class="logo" style="background: url(img/logo/d_logo_white.png); width:100px; height: 50px; background-size: cover; background-position: 50% 50%;">
					</div>
					<div class="text-center mx-auto" style="width: 100%;">
						<?php if (!(empty($error))) {
						?>
							<span class="text-danger"><?php echo $error; ?></span>
						<?php } ?>
					</div>
					<div class="col-md-12 form-group">
						<label for="username" class="font-weight-bold">Username</label>
						<input type="username" class="form-control" id="username" name="username" placeholder="Jane Doe" required>
					</div>
					<div class="col-md-12 form-group">
						<label for="password" class="font-weight-bold">Password</label>

						<div class="input-group mb-3">
							<input type="password" class="form-control" id="password" name="password" placeholder="*******" required>
							<div class="input-group-append">
								<span class="input-group-text" style="background: white;" id="svg" onclick="text()"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
										<path d="M0 0h24v24H0z" fill="none" />
										<path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" /></svg></span>
							</div>
						</div>
					</div>
					<div class="col-md-12 form-group d-flex">
						<input type="checkbox" class="checkmark" name="remember" style="margin-right: 10px;margin-top: -20px;" id="remember" <?php if (isset($_COOKIE["active"])) { ?> checked <?php } ?> /><label style="margin-top: -25px!important;color: lightgrey;font-weight: 500;" for="remember-me">Remember me for 2 weeks</label>

					</div>
					<div class="col-md-12 form-group">
						<button type="submit" value="submit" class="btn btn-outline-secondary mr-4" style="width: 100%;background-image: linear-gradient(to right, #000000, #434343);color: white;">Log In</button> <br>
					</div>
					<div class="col-md-12 form-group text-center">
						<a href="signup.php" class="">Create a Dscon account</a>
					</div>
					<br>
				</form>
			</div>
		</div>
		</div>

	</section>
	<!--================End Login Box Area =================-->

	<script>
		function text() {
			var type = document.getElementById('password').type;
			if (type == "password") {
				document.getElementById('password').type = "text";
				document.getElementById("svg").innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M0 0h24v24H0zm0 0h24v24H0zm0 0h24v24H0zm0 0h24v24H0z" fill="none"/><path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/></svg>';
			} else {
				document.getElementById('password').type = "password";
				document.getElementById("svg").innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>';
			}
		}
	</script>
</body>

</html>