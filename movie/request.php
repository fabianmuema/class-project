<?php

include '../includes/login_status.php';

include '../includes/db_conf.php';

$div = "";

if($_SERVER['REQUEST_METHOD'] == "POST") {
	$request = $_POST['request'];

	include '../includes/db_conf.php';

	$sql = "INSERT INTO requests (movie, username) VALUES ('$request', '$username')";
	if(mysqli_query($conn, $sql)) {
		$div = "<h4 style='color: white'>We will notify you when the requested item is ready.</h4>";

	} else {
		$div = "<h4 style='color: white'>An error occured! Please try again later.</h4>";
	}

}


?>


<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7 no-js" lang="en-US">
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8 no-js" lang="en-US">
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html lang="en" class="no-js">

<!-- comingsoon14:54-->
<head>
	<!-- Basic need -->
	<title>Dscon | Request</title>
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="">
	<link rel="profile" href="#">

   	<!-- Mobile specific meta -->
	<meta name=viewport content="width=device-width, initial-scale=1">

	<link rel="shortcut icon" href="images/logo/favicon.ico" type="image/x-icon">


	<!-- CSS files -->
	<link rel="stylesheet" href="css/plugins.css">
	<link rel="stylesheet" href="css/style.css">

</head>
<body>
<!--preloading-->
<div id="preloader">
    <div id="status">
        <span></span>
        <span></span>
    </div>
</div>
<!--end of preloading-->

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
				<a href="../movie/"><img class="logo" src="images/logo/d_logo-transparent-black.png" alt="Dscon Logo"
						width="40" height="40"></a>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse flex-parent" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav flex-child-menu menu-left">
					<li class="hidden">
						<a href="#page-top"></a>
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
								$sql = "SELECT DISTINCT genre FROM moviegenres ORDER BY genre ASC";
								$result = mysqli_query($conn, $sql);
								while($genres = mysqli_fetch_assoc($result)){
								?>
							<li><a
									href="genre.php?genre=<?php echo $genres['genre']; ?>"><?php echo $genres['genre']; ?></a>
							</li>
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
<!--					<li class="dropdown first">-->
<!--						<a class="btn btn-default dropdown-toggle lv1" href="#">-->
<!--							Music-->
<!--						</a>-->
<!--					</li>-->
				</ul>
				<ul class="nav navbar-nav flex-child-menu menu-right">
<!--					<li class="dropdown first">-->
<!--						<a class="btn btn-default dropdown-toggle lv1" data-toggle="dropdown" data-hover="dropdown">-->
<!--							Favourites <i class="fa fa-angle-down" aria-hidden="true"></i>-->
<!--						</a>-->
<!--						<ul class="dropdown-menu level1">-->
<!--							<li><a href="userfavoritegrid.html">Movies</a></li>-->
<!--							<li><a href="userfavoritegrid.html">Tv Shows</a></li>-->
<!--<!--							<li><a href="userfavoritegrid.html">Music</a></li>-->
<!---->
<!--						</ul>-->
<!--					</li>-->
					<li class=""><a href="request.php">Request</a></li>
					<li class="btn"><a href="../dashboard/">Profile</a></li>
				</ul>
			</div>
			<!-- /.navbar-collapse -->
		</nav>
		<!-- search form -->
	</div>

</header>
<!-- END | Header -->


<div class="page-single-2" style="padding-top: 80px;">
	<div class="container">
		<div class="row ipad-width">
			<div class="left-content">
				<h1>Request</h1>
				<p>Request Movies and Tv Shows</p>
				<div class="row">
					<div class="col-md-6 col-sm-12 col-xs-12">
						<form action="" method="post">
							<input class="email" type="text" name="request" placeholder="Enter name of item.">
							<input class="redbtn" type="submit" placeholder="submit">
						</form>

						<?php echo $div; ?>
					</div>
					<div class="col-md-6 col-sm-12 col-xs-12">
						<img class="cm-img" src="images/uploads/cm-img.png" alt="">
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
<script src="js/jquery.js"></script>
<script src="js/plugins.js"></script>
<script src="js/plugins2.js"></script>
<script src="js/custom.js"></script>
</body>

<!-- comingsoon14:55-->
</html>
