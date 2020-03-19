<?php

require '../includes/login_status.php';

if ($_SERVER['REQUEST_METHOD'] == "GET") {
	$moviename = $_GET["movie"];
	if ($moviename == "Fast") {
		$moviename = "Fast & Furious Presents: Hobbs & Shaw";
	}

	include_once '../includes/db_conf.php';

	include 'check_payment.php';

	$moviename = mysqli_real_escape_string($conn, $moviename);

	$sql = "INSERT INTO watchedmovies (username, movie) VALUES ('$username', '$moviename')";
	mysqli_query($conn, $sql);

	$sql = "SELECT * FROM movies WHERE name='" . $moviename . "'";
	$result = mysqli_query($conn, $sql);
	$movies = mysqli_fetch_assoc($result);
	$moviename = $movies["name"];
	$link = $movies["link"];
	$year = $movies["year"];
	$info = pathinfo($link);

	if ($info['extension'] == 'm3u8') {
?>
		<script>
			window.location.replace("http://dsconlimited.net/movie/streamm.php?movie=<?php echo $moviename; ?>&link=<?php echo $link; ?>")
		</script>
<?php
	}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Dscon | <?php echo $moviename; ?> (<?php echo $year; ?>)</title>

	<link rel="shortcut icon" href="images/logo/favicon.ico" type="image/x-icon">

	<!-- CSS files -->
	<link rel="stylesheet" href="css/plugins.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/player.css">
	<link rel="stylesheet" href="css/plyr.css">

</head>

<body>

	<!-- BEGIN | Header -->
	<header class="ht-header full-width-hd">
		<div class="row">
			<nav id="mainNav" class="navbar navbar-default navbar-custom">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header logo">
					<div class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<div id="nav-icon1">
							<span></span>
							<span></span>
							<span></span>
						</div>
					</div>
					<a href="../movie/"><img class="logo" src="images/logo/d_logo-transparent-black.png" alt="Dscon Logo" width="40" height="40"></a>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse flex-parent" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav flex-child-menu menu-left">
						<li class="hidden">
							<a href=""></a>
						</li>
						<li class="dropdown first">
							<a class="btn btn-default lv1" href="../movie/">
								Home
							</a>
						</li>
						<li class="dropdown first">
							<a class="btn btn-default dropdown-toggle lv1" data-toggle="dropdown" data-hover="dropdown">
								Movies<i class="fa fa-angle-down" aria-hidden="true"></i>
							</a>
							<ul class="dropdown-menu level1">
								<!-- <li class="dropdown">
									<a href="#">about us <i class="fa fa-caret-right" aria-hidden="true"></i></a>
									<ul class="dropdown-menu level2">
										<li><a href="aboutv1.html">About Us 01</a></li>
										<li><a href="aboutv2.html">About Us 02</a></li>
									</ul>
								</li> -->
								<li><a href="moviegrid.php">All</a></li>
								<?php
								$sql = "SELECT DISTINCT genre FROM moviegenres";
								$result = mysqli_query($conn, $sql);
								while ($genres = mysqli_fetch_assoc($result)) {
								?>
									<li><a href="genre.php?genre=<?php echo $genres['genre']; ?>"><?php echo $genres['genre']; ?></a></li>
								<?php } ?>

							</ul>
						</li>
						<li class="dropdown first">
							<a class="btn btn-default dropdown-toggle lv1" data-toggle="dropdown" data-hover="dropdown">
								Tv Shows<i class="fa fa-angle-down" aria-hidden="true"></i>
							</a>
							<ul class="dropdown-menu level1">
								<li><a href="seriesgrid.php">All</a></li>
								<?php
								$sql = "SELECT DISTINCT genre FROM seriesgenres ORDER BY genre ASC";
								$result = mysqli_query($conn, $sql);
								while ($genres = mysqli_fetch_assoc($result)) {
								?>
									<li>
										<a href="genres.php?genre=<?php echo $genres['genre']; ?>"><?php echo $genres['genre']; ?></a>
									</li>
								<?php } ?>
							</ul>
						</li>
						<!--						<li class="dropdown first">-->
						<!--							<a class="btn btn-default dropdown-toggle lv1" href="#">-->
						<!--								Music-->
						<!--							</a>-->
						<!--						</li>-->
					</ul>
					<ul class="nav navbar-nav flex-child-menu menu-right">
						<!--						<li class="dropdown first">-->
						<!--							<a class="btn btn-default dropdown-toggle lv1" data-toggle="dropdown" data-hover="dropdown">-->
						<!--								Favourites <i class="fa fa-angle-down" aria-hidden="true"></i>-->
						<!--							</a>-->
						<!--							<ul class="dropdown-menu level1">-->
						<!--								<li><a href="userfavoritegrid.html">Movies</a></li>-->
						<!--								<li><a href="userfavoritegrid.html">Tv Shows</a></li>-->
						<!--<!--								<li><a href="userfavoritegrid.html">Music</a></li>-->-->
						<!---->
						<!--							</ul>-->
						<!--						</li>-->
						<li class=""><a href="request.php">Request</a></li>
						<li class="btn"><a href="../dashboard/">Profile</a></li>
					</ul>
				</div>
				<!-- /.navbar-collapse -->
			</nav>
			<!-- search form -->
			<!-- <div class="top-search">
		 	<select>
		 		<option value="united">Movies</option>
		 		<option value="saab">Others</option>
		 	</select>
		 	<input type="text" placeholder="Search for a movie, TV Show or celebrity that you are looking for">
		 </div> -->

		</div>

	</header>
	<!-- END | Header -->

	<!--preloading-->
	<div id="preloader">
		<div id="status">
			<span></span>
			<span></span>
		</div>
	</div>
	<!--end of preloading-->

	<!--    TODO: add codecs-->

	<div class="page-single">
		<video id="player" playsinline controls width="100%" style="outline: none" poster="http://dsconlimited.net/dsconlimitedmovies/<?php echo $movies['backdrop']; ?>">
			<source src="http://dsconlimited.net/dsconlimitedmovies/<?php echo $link; ?>" type="video/mp4">
			Your browser does not support HTML5 video.

		</video>
	</div>

	<script src="js/plyr.min.js"></script>
	<script>
		const player = new Plyr('#player');
	</script>

	<script defer src="js/jquery.js"></script>
	<script defer src="js/plugins.js"></script>
	<script defer src="js/plugins2.js"></script>
	<script defer src="js/custom.js"></script>
</body>

</body>

</html>