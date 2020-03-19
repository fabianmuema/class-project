<?php

session_start();

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $show = $_GET['show'];
    $season = $_GET['season'];
    $episode = $_GET['episode'];

    include '../includes/db_conf.php';

    $sql = "SELECT * FROM episodes WHERE showname ='" . $show . "' AND season = '" . $season . "' AND epNum = '" . $episode . "'";
    $result = mysqli_query($conn, $sql);
    $series = mysqli_fetch_assoc($result);

    $sql = "SELECT * FROM episodeslink WHERE showname ='" . $show . "' AND season = '" . $season . "' AND episodeNum = '" . $episode . "'";
    $result = mysqli_query($conn, $sql);
    $seriez = mysqli_fetch_assoc($result);
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

<!-- moviesingle07:38-->

<head>
    <!-- Basic need -->
    <title>Dscon | <?php echo $series['showname']; ?> (<?php echo $series['year']; ?>)</title>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <link rel="profile" href="#">

    <link rel="shortcut icon" href="images/logo/favicon.ico" type="image/x-icon">

    <!--Google Font-->
    <link rel="stylesheet" href='http://fonts.googleapis.com/css?family=Dosis:400,700,500|Nunito:300,400,600' />
    <!-- Mobile specific meta -->
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone-no">

    <!-- CSS files -->
    <link rel="stylesheet" href="css/plugins.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/plyr.css">

    <link rel="stylesheet" href="css/custom.css">

</head>

<body style="background-color: black">
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
                            <li><a href="moviegrid.php">All</a></li>
                            <?php
                            $sql = "SELECT DISTINCT genre FROM moviegenres ORDER BY genre ASC";
                            $result = mysqli_query($conn, $sql);
                            while($genres = mysqli_fetch_assoc($result)){
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
<!--                    <li class="dropdown first">-->
<!--                        <a class="btn btn-default dropdown-toggle lv1" href="#">-->
<!--                            Music-->
<!--                        </a>-->
<!--                    </li>-->
                </ul>
                <ul class="nav navbar-nav flex-child-menu menu-right">
<!--                    <li class="dropdown first">-->
<!--                        <a class="btn btn-default dropdown-toggle lv1" data-toggle="dropdown" data-hover="dropdown">-->
<!--                            Favourites <i class="fa fa-angle-down" aria-hidden="true"></i>-->
<!--                        </a>-->
<!--                        <ul class="dropdown-menu level1">-->
<!--                            <li><a href="userfavoritegrid.html">Movies</a></li>-->
<!--                            <li><a href="userfavoritegrid.html">Tv Shows</a></li>-->
<!--<!--                            <li><a href="userfavoritegrid.html">Music</a></li>-->
<!---->
<!--                        </ul>-->
<!--                    </li>-->
                    <li class=""><a href="request.php">Request</a></li>
                    <li class="btn"><a href="../dashboard/">Profile</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
        <!-- search form -->
        <!-- <div class="top-search">
            <select>
                <option value="series">Tv Show</option>
                <option value="movies">Movies</option>
            </select>
            <input type="text" placeholder="Search for a movie, TV Show or celebrity that you are looking for">
        </div> -->

    </div>

</header>
<!-- END | Header -->

<?php
$name = $series['showname'];
$sql = "SELECT * FROM series WHERE seriesname ='" . $name . "'";
$result = mysqli_query($conn, $sql);
$show = mysqli_fetch_assoc($result);
?>

<div class="page-single movie-single movie_single">
    <div class="container" style="margin-top: -150px"
        <div class="row ipad-width2">
            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="movie-img">

                    <img src="http://dsconlimited.net/dsconlimitedseries/<?php echo $seriez['thumbnail']; ?>" alt="">
                    <div class="movie-btn">
                        <div class="btn-transform transform-vertical red">

                            <div>
                                <a href="xilosi.php?series=<?php echo $series['showname']; ?>&season=<?php echo $series['season']; ?>&episode=<?php echo $series['epNum']; ?>"
                                   class="item item-1 redbtn"> <i class="ion-play"></i> Play</a></div>
                            <div>
                                <a href="xilosi.php?series=<?php echo $series['showname']; ?>&season=<?php echo $series['season']; ?>&episode=<?php echo $series['epNum']; ?>"
                                   class="item item-2 redbtn fancybox-media hvr-grow"><i class="ion-play"></i></a></div>
                        </div>
<!--                        <div class="btn-transform transform-vertical red">-->
<!--                            <div><a href="#" class="item item-1 yellowbtn"> <i class="ion-play"></i>Watch Trailer</a></div>-->
<!--                            <div><a href="#open-modal" class="item item-2 yellowbtn"><i class="ion-play"></i></a></div>-->
<!--                            <div id="open-modal" class="modal-window">-->
<!--                                <div>-->
<!---->
<!--                                    <h3 style="color: white">--><?php //echo $name; ?><!-- Trailer</h3>-->
<!--                                    <a href="#" title="Close" class="modal-close">Close</a>-->
<!--                                    <br>-->
<!--                                    <div>-->
<!--                                        <video id="player" width="100%" height="100%" controls>-->
<!--                                            <source src="http://dsconlimited.net/dsconlimitedtrailers/--><?php //echo $show['trailer']; ?><!--">-->
<!--                                        </video>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="movie-single-ct main-content">
                    <h1 class="bd-hd"><?php echo $show['seriesname']; ?><span> <?php echo $series['year']; ?></span>
                    Season <?php echo $series['season']?> Episode <?php echo $series['epNum']; ?> </h1>
                    <div class="social-btn">
                        <!-- <a href="#" class="parent-btn"><i class="ion-heart"></i> Add to Favorite</a> -->

                    </div>
                    <div class="movie-rate">
                        <div class="rate">
                            <p style="font-size: 1.4em"><?php echo $series['epName']; ?>
                            </p>
                        </div>
                    </div>
                    <div class="movie-tabs">
                        <div class="tabs">
                            <ul class="tab-links tabs-mv">
                                <li class="active"><a href="#overview">Overview</a></li>
<!--                                <li><a href="#cast"> Cast & Crew </a></li>-->
                            </ul>
                            <div class="tab-content">
                                <div id="overview" class="tab active">
                                    <div class="row">
                                        <div class="col-md-8 col-sm-12 col-xs-12">
                                            <p><?php echo $series['epDescription']; ?></p>
<!--                                            <div class="title-hd-sm">-->
<!--                                                <h4>Videos & Photos</h4>-->
<!--                                                <a href="#" class="time">All 5 Videos & 245 Photos <i class="ion-ios-arrow-right"></i></a>-->
<!--                                            </div>-->
<!--                                            <div class="mvsingle-item ov-item">-->
<!--                                                <a class="img-lightbox" data-fancybox-group="gallery" href="images/uploads/image11.jpg"><img src="images/uploads/image1.jpg" alt=""></a>-->
<!--                                                <a class="img-lightbox" data-fancybox-group="gallery" href="images/uploads/image21.jpg"><img src="images/uploads/image2.jpg" alt=""></a>-->
<!--                                                <a  class="img-lightbox" data-fancybox-group="gallery" href="images/uploads/image31.jpg"><img src="images/uploads/image3.jpg" alt=""></a>-->
<!--                                                <div class="vd-it">-->
<!--                                                    <img class="vd-img" src="images/uploads/image4.jpg" alt="">-->
<!--                                                    <a class="fancybox-media hvr-grow" href="https://www.youtube.com/embed/o-0hcF97wy0"><img src="images/uploads/play-vd.png" alt=""></a>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <div class="title-hd-sm">-->
<!--                                                <h4>cast</h4>-->
<!--                                                <a href="#" class="time">Full Cast & Crew <i class="ion-ios-arrow-right"></i></a>-->
<!--                                            </div>-->
                                            <!-- movie cast -->
<!--                                            <div class="mvcast-item">-->
<!--                                                <div class="cast-it">-->
<!--                                                    <div class="cast-left">-->
<!--                                                        <img src="images/uploads/cast1.jpg" alt="">-->
<!--                                                        <a href="#">Robert Downey Jr.</a>-->
<!--                                                    </div>-->
<!--                                                    <p>... Robert Downey Jr.</p>-->
<!--                                                </div>-->
<!--                                                <div class="cast-it">-->
<!--                                                    <div class="cast-left">-->
<!--                                                        <img src="images/uploads/cast2.jpg" alt="">-->
<!--                                                        <a href="#">Chris Hemsworth</a>-->
<!--                                                    </div>-->
<!--                                                    <p>... Thor</p>-->
<!--                                                </div>-->
<!--                                                <div class="cast-it">-->
<!--                                                    <div class="cast-left">-->
<!--                                                        <img src="images/uploads/cast3.jpg" alt="">-->
<!--                                                        <a href="#">Mark Ruffalo</a>-->
<!--                                                    </div>-->
<!--                                                    <p>... Bruce Banner/ Hulk</p>-->
<!--                                                </div>-->
<!--                                                <div class="cast-it">-->
<!--                                                    <div class="cast-left">-->
<!--                                                        <img src="images/uploads/cast4.jpg" alt="">-->
<!--                                                        <a href="#">Chris Evans</a>-->
<!--                                                    </div>-->
<!--                                                    <p>... Steve Rogers/ Captain America</p>-->
<!--                                                </div>-->
<!--                                                <div class="cast-it">-->
<!--                                                    <div class="cast-left">-->
<!--                                                        <img src="images/uploads/cast5.jpg" alt="">-->
<!--                                                        <a href="#">Scarlett Johansson</a>-->
<!--                                                    </div>-->
<!--                                                    <p>... Natasha Romanoff/ Black Widow</p>-->
<!--                                                </div>-->
<!--                                                <div class="cast-it">-->
<!--                                                    <div class="cast-left">-->
<!--                                                        <img src="images/uploads/cast6.jpg" alt="">-->
<!--                                                        <a href="#">Jeremy Renner</a>-->
<!--                                                    </div>-->
<!--                                                    <p>... Clint Barton/ Hawkeye</p>-->
<!--                                                </div>-->
<!--                                                <div class="cast-it">-->
<!--                                                    <div class="cast-left">-->
<!--                                                        <img src="images/uploads/cast7.jpg" alt="">-->
<!--                                                        <a href="#">James Spader</a>-->
<!--                                                    </div>-->
<!--                                                    <p>... Ultron</p>-->
<!--                                                </div>-->
<!--                                                <div class="cast-it">-->
<!--                                                    <div class="cast-left">-->
<!--                                                        <img src="images/uploads/cast9.jpg" alt="">-->
<!--                                                        <a href="#">Don Cheadle</a>-->
<!--                                                    </div>-->
<!--                                                    <p>... James Rhodes/ War Machine</p>-->
<!--                                                </div>-->
<!--                                            </div>-->
                                        </div>
                                        <div class="col-md-4 col-xs-12 col-sm-12">
                                            <!-- <div class="sb-it">
                                                <h6>Director: </h6>
                                                <p><a href="#">Joss Whedon</a></p>
                                            </div>
                                            <div class="sb-it">
                                                <h6>Writer: </h6>
                                                <p><a href="#">Joss Whedon,</a> <a href="#">Stan Lee</a></p>
                                            </div> -->
<!--                                            <div class="sb-it">-->
<!--                                                <h6>Stars: </h6>-->
<!--                                                <p><a href="#">Robert Downey Jr,</a> <a href="#">Chris Evans,</a> <a href="#">Mark Ruffalo,</a><a href="#"> Scarlett Johansson</a></p>-->
<!--                                            </div>-->
<!--                                            <div class="sb-it">-->
<!--                                                <h6>Genres:</h6>-->
<!--                                                <p><a href="#">-->
<!--                                                        --><?php
//                                                        $name = $movie['name'];
//                                                        $sql = "SELECT * FROM moviegenres WHERE movie='" . $name . "'";
//                                                        $results = mysqli_query($conn, $sql);
//                                                        while ($genres = mysqli_fetch_assoc($results)) {
//                                                            echo $genres['genre'], ", ";
//                                                        }
//                                                        ?>
<!--                                                    </a>-->
<!--                                            </div>-->
                                            <div class="sb-it">
                                                <h6>Release Date:</h6>
                                                <p> <?php echo $series['showDate']; ?></p>
                                            </div>
                                            <!-- <div class="sb-it">
                                                <h6>Run Time:</h6>
                                                <p>141 min</p>
                                            </div> -->
<!--                                            <div class="sb-it">-->
<!--                                                <h6>MMPA Rating:</h6>-->
<!--                                                <p>PG-13</p>-->
<!--                                            </div>-->
<!--                                            <div class="sb-it">-->
<!--                                                <h6>Plot Keywords:</h6>-->
<!--                                                <p class="tags">-->
<!--                                                    <span class="time"><a href="#">superhero</a></span>-->
<!--                                                    <span class="time"><a href="#">marvel universe</a></span>-->
<!--                                                    <span class="time"><a href="#">comic</a></span>-->
<!--                                                    <span class="time"><a href="#">blockbuster</a></span>-->
<!--                                                    <span class="time"><a href="#">final battle</a></span>-->
<!--                                                </p>-->
<!--                                            </div>-->
<!--                                            <div class="ads">-->
<!--                                                <img src="images/uploads/ads1.png" alt="">-->
<!--                                            </div>-->
                                        </div>
                                    </div>
                                </div>
                                <div id="reviews" class="tab review">
                                    <div class="row">
                                        <div class="rv-hd">
                                            <div class="div">
                                                <!--                                                <h3>Reviews of</h3>-->
                                                <!--                                                <h2>-->
                                                <?php //echo $movie['name']; ?><!--</h2>-->
                                            </div>
                                        </div>
                                        <?php
                                        $movietitle = $movie['name'];
                                        $sql = "SELECT * FROM moviereviews WHERE movie='" . $movietitle . "'";
                                        $result = mysqli_query($conn, $sql);
                                        while ($review = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <div class="mv-user-review-item">
                                                <div class="user-infor">
                                                    <div>
                                                        <p class="time">
                                                            <?php echo $review['date']; ?> by <a href="#"> <?php echo $review['author']; ?></a>
                                                        </p>
                                                        <p><?php echo $review['review']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div id="cast" class="tab">
                                    <div class="row">
                                        <h3>Cast & Crew of</h3>
                                        <h2><?php echo $movie['name']; ?></h2>
                                        <!-- //== -->
                                        <div class="title-hd-sm">
                                            <h4>Directors & Credit Writers</h4>
                                        </div>
                                        <div class="mvcast-item">
                                            <div class="cast-it">
                                                <div class="cast-left">
                                                    <h4>JW</h4>
                                                    <a href="#">Joss Whedon</a>
                                                </div>
                                                <p>... Director</p>
                                            </div>
                                        </div>
                                        <!-- //== -->
                                        <div class="title-hd-sm">
                                            <h4>Directors & Credit Writers</h4>
                                        </div>
                                        <div class="mvcast-item">
                                            <div class="cast-it">
                                                <div class="cast-left">
                                                    <h4>SL</h4>
                                                    <a href="#">Stan Lee</a>
                                                </div>
                                                <p>... (based on Marvel comics)</p>
                                            </div>
                                            <div class="cast-it">
                                                <div class="cast-left">
                                                    <h4>JK</h4>
                                                    <a href="#">Jack Kirby</a>
                                                </div>
                                                <p>... (based on Marvel comics)</p>
                                            </div>
                                            <div class="cast-it">
                                                <div class="cast-left">
                                                    <h4>JS</h4>
                                                    <a href="#">Joe Simon</a>
                                                </div>
                                                <p>... (character created by: Captain America)</p>
                                            </div>
                                            <div class="cast-it">
                                                <div class="cast-left">
                                                    <h4>JS</h4>
                                                    <a href="#">Joe Simon</a>
                                                </div>
                                                <p>... (character created by: Thanos)</p>
                                            </div>
                                            <div class="cast-it">
                                                <div class="cast-left">
                                                    <h4>RT</h4>
                                                    <a href="#">Roy Thomas</a>
                                                </div>
                                                <p>... (character created by: Ultron, Vision)</p>
                                            </div>
                                            <div class="cast-it">
                                                <div class="cast-left">
                                                    <h4>JB</h4>
                                                    <a href="#">John Buscema</a>
                                                </div>
                                                <p>... (character created by: Ultron, Vision)</p>
                                            </div>
                                        </div>
                                        <!-- //== -->
                                        <div class="title-hd-sm">
                                            <h4>Cast</h4>
                                        </div>
                                        <div class="mvcast-item">
                                            <div class="cast-it">
                                                <div class="cast-left">
                                                    <img src="images/uploads/cast1.jpg" alt="">
                                                    <a href="#">Robert Downey Jr.</a>
                                                </div>
                                                <p>... Robert Downey Jr.</p>
                                            </div>
                                            <div class="cast-it">
                                                <div class="cast-left">
                                                    <img src="images/uploads/cast2.jpg" alt="">
                                                    <a href="#">Chris Hemsworth</a>
                                                </div>
                                                <p>... Thor</p>
                                            </div>
                                            <div class="cast-it">
                                                <div class="cast-left">
                                                    <img src="images/uploads/cast3.jpg" alt="">
                                                    <a href="#">Mark Ruffalo</a>
                                                </div>
                                                <p>... Bruce Banner/ Hulk</p>
                                            </div>
                                            <div class="cast-it">
                                                <div class="cast-left">
                                                    <img src="images/uploads/cast4.jpg" alt="">
                                                    <a href="#">Chris Evans</a>
                                                </div>
                                                <p>... Steve Rogers/ Captain America</p>
                                            </div>
                                            <div class="cast-it">
                                                <div class="cast-left">
                                                    <img src="images/uploads/cast5.jpg" alt="">
                                                    <a href="#">Scarlett Johansson</a>
                                                </div>
                                                <p>... Natasha Romanoff/ Black Widow</p>
                                            </div>
                                            <div class="cast-it">
                                                <div class="cast-left">
                                                    <img src="images/uploads/cast6.jpg" alt="">
                                                    <a href="#">Jeremy Renner</a>
                                                </div>
                                                <p>... Clint Barton/ Hawkeye</p>
                                            </div>
                                            <div class="cast-it">
                                                <div class="cast-left">
                                                    <img src="images/uploads/cast7.jpg" alt="">
                                                    <a href="#">James Spader</a>
                                                </div>
                                                <p>... Ultron</p>
                                            </div>
                                            <div class="cast-it">
                                                <div class="cast-left">
                                                    <img src="images/uploads/cast9.jpg" alt="">
                                                    <a href="#">Don Cheadle</a>
                                                </div>
                                                <p>... James Rhodes/ War Machine</p>
                                            </div>
                                        </div>
                                        <!-- //== -->
                                        <div class="title-hd-sm">
                                            <h4>Produced by</h4>
                                        </div>
                                        <div class="mvcast-item">
                                            <div class="cast-it">
                                                <div class="cast-left">
                                                    <h4>VA</h4>
                                                    <a href="#">Victoria Alonso</a>
                                                </div>
                                                <p>... executive producer</p>
                                            </div>
                                            <div class="cast-it">
                                                <div class="cast-left">
                                                    <h4>MB</h4>
                                                    <a href="#">Mitchel Bell</a>
                                                </div>
                                                <p>... co-producer (as Mitch Bell)</p>
                                            </div>
                                            <div class="cast-it">
                                                <div class="cast-left">
                                                    <h4>JC</h4>
                                                    <a href="#">Jamie Christopher</a>
                                                </div>
                                                <p>... associate producer</p>
                                            </div>
                                            <div class="cast-it">
                                                <div class="cast-left">
                                                    <h4>LD</h4>
                                                    <a href="#">Louis D’Esposito</a>
                                                </div>
                                                <p>... executive producer</p>
                                            </div>
                                            <div class="cast-it">
                                                <div class="cast-left">
                                                    <h4>JF</h4>
                                                    <a href="#">Jon Favreau</a>
                                                </div>
                                                <p>... executive producer</p>
                                            </div>
                                            <div class="cast-it">
                                                <div class="cast-left">
                                                    <h4>KF</h4>
                                                    <a href="#">Kevin Feige</a>
                                                </div>
                                                <p>... producer</p>
                                            </div>
                                            <div class="cast-it">
                                                <div class="cast-left">
                                                    <h4>AF</h4>
                                                    <a href="#">Alan Fine</a>
                                                </div>
                                                <p>... executive producer</p>
                                            </div>
                                            <div class="cast-it">
                                                <div class="cast-left">
                                                    <h4>JF</h4>
                                                    <a href="#">Jeffrey Ford</a>
                                                </div>
                                                <p>... associate producer</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="moviesrelated" class="tab">
                                    <div class="row">
                                        <h3>Related Movies To</h3>
                                        <h2><?php echo $movie['name']; ?></h2>
                                        <?php
                                        $name = $movie['name'];
                                        $sql = "SELECT * FROM moviegenres WHERE movie='" . $name . "' LIMIT 4";
                                        $results = mysqli_query($conn, $sql);
                                        while ($genres = mysqli_fetch_assoc($results)) {
                                            $genre = $genres['genre'];
                                            $sql = "SELECT * FROM moviegenres WHERE genre='" . $genre . "' LIMIT 4";
                                            $result = mysqli_query($conn, $sql);
                                            while ($movies = mysqli_fetch_assoc($result)) {
                                                $name = $movies['movie'];
                                                if ($name != $movie['name']) {
                                                    $sql = "SELECT * FROM movies WHERE name='" . $name . "' LIMIT 4";
                                                    $resultz = mysqli_query($conn, $sql);
                                                    while ($movie = mysqli_fetch_assoc($resultz)) {
                                                        ?>
                                                        <div class="movie-item-style-2">
                                                            <img src="http://dsconlimited.net/dsconlimitedposters/<?php echo $movie['cover']; ?>" alt="">
                                                            <div class="mv-item-infor">
                                                                <h6><a href="movie.php?movie=<?php echo $movie['name']; ?>"><?php echo $movie['name']; ?> <span>(<?php echo $movie['year']; ?>)</span></a></h6>
                                                                <p class="rate"><?php echo $series['epName']; ?></p>
                                                                <!-- <p class="run-time"> Run Time: 2h21’ . <span>MMPA: PG-13 </span> . <span>Release: 1 May 2015</span></p> -->
                                                                <!-- <p>Director: <a href="#">Joss Whedon</a></p> -->
                                                                <!-- <p>Stars: <a href="#">Robert Downey Jr.,</a> <a href="#">Chris Evans,</a> <a href="#"> Chris Hemsworth</a></p> -->
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- footer section-->
<footer class="ht-footer">
    <div class="ft-copyright">
        <div class="ft-left">
            <p><a target="_blank" href="http://dsconlimited.net">Dscon Limited</a></p>
        </div>
        <div class="backtotop">
            <p><a href="#" id="back-to-top">Back to top <i class="ion-ios-arrow-thin-up"></i></a></p>
        </div>
    </div>
</footer>
<!-- end of footer section-->

<script src="js/plyr.min.js"></script>
<script>
    const player = new Plyr('player');
</script>

<script src="js/jquery.js"></script>
<script src="js/plugins.js"></script>
<script src="js/plugins2.js"></script>
<script src="js/custom.js"></script>
</body>
<!-- moviesingle11:03-->

</html>
