<?php

include_once('../includes/login_status.php');

include_once('../includes/db_conf.php');

$sql = "SELECT * FROM users where username='" . $username . "'";
$results = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($results);
$phone = $user['phone'];
$apartment = $user['apartment'];
$_SESSION['apartment'] = $apartment;

if ($_SERVER['HTTP_REFERER'] != '') {
	$back = $_SERVER['HTTP_REFERER'];
} else {
	$back = '../index.php';
}


$_SESSION["back"] = $back;

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<!-- bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- css -->
	<link rel="stylesheet" href="css/upload.css">

	<link rel="shortcut icon" href="img/logo/favicon.ico" type="image/x-icon">

	<title>Dscon | Report an Issue / Bug</title>
</head>

<body>

	<!-- MultiStep Form -->
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<form id="msform" method="POST" action="success.php">
				<div>
					<!-- progressbar -->
					<ul id="progressbar">
						<li class="active" class="ml-4 pl-4">Issue / Bug Details</li>
						<li>Type of Issue</li>
						<li>Describe Issue</li>
					</ul>
				</div>

				<!-- fieldsets -->
				<fieldset>
					<h2 class="fs-title">Personal Details</h2>
					<h3 class="fs-subtitle">Your details.</h3>
					<input type="text" name="username" value="<?php echo $username; ?>" readonly />
					<input type="text" name="phone" value="<?php echo $phone; ?>" readonly />
					<input type="button" name="next" class="next action-button" value="Next" />
					<br>
					or
					<h3 class="fs-subtitle">Go <a href="<?php echo $back; ?>">back</a></h3>
				</fieldset>
				<fieldset>
					<h2 class="fs-title">Type of Issue</h2>
					<h3 class="fs-subtitle">What type of issue are you reporting?</h3>
					<select name="issue_type" id="issue-type" required>
						<option value="Entertainment">Entertainment</option>
						<option value="Internet Related Issue">Internet Related Issue</option>
						<option value="Complaint">Complaint</option>
					</select>
					<input type="button" name="previous" class="previous action-button-previous" value="Previous" />
					<input type="button" name="next" class="next action-button" value="Next" />
				</fieldset>
				<fieldset>
					<h2 class="fs-title">Describe the Issue</h2>
					<h3 class="fs-subtitle">Describe the issue as best as you can.</h3>
					<textarea name="issue_description" id="issue_description" cols="30" rows="10"></textarea>
					<input type="button" name="previous" class="previous action-button-previous" value="Previous" />
					<input type="submit" name="submit" class="submit action-button" value="Submit" />
					<br>


				</fieldset>
			</form>

		</div>
	</div>
	<!-- /.MultiStep Form -->



	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

	<script src="js/upload.js"></script>

</body>

</html>
