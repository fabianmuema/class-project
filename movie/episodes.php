<?php

require '../includes/login_status.php';

include_once '../includes/db_conf.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $series = $_GET['series'];
    $season = $_GET['season'];
}
$sql = "SELECT * FROM episodes WHERE showname = '" . $series . "' AND season = '" . $season . "' ORDER BY epNum ASC";
$resultx = mysqli_query($conn, $sql);

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

<!-- moviegridfw07:38-->

<head>
    <!-- Basic need -->
    <title>Dscon | <?php echo $series; ?></title>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <link rel="profile" href="#">

    <!--Google Font-->
    <link rel="stylesheet" href='http://fonts.googleapis.com/css?family=Dosis:400,700,500|Nunito:300,400,600' />
    <!-- Mobile specific meta -->
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone-no">

    <link rel="shortcut icon" href="images/logo/favicon.ico" type="image/x-icon">

    <!-- CSS files -->
    <link rel="stylesheet" href="css/plugins.css">
    <link rel="stylesheet" href="css/style.css">


</head>

<body style="background: black;">

    <!--preloading-->
    <!-- <div id="preloader">
        <div id="status">
            <span></span>
            <span></span>
        </div>
    </div> -->
    <!--end of preloading-->

    <!-- BEGIN | Header -->
    <header class="ht-header full-width-hd" style="padding-bottom: 20px;">
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
                    <a href="index.php"><img class="logo" src="images/logo/d_logo-transparent-black.png" alt="Dscon Logo" width="40" height="40"></a>
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
                                $sql = "SELECT DISTINCT genre FROM moviegenres ORDER BY genre ASC";
                                $result = mysqli_query($conn, $sql);
                                while ($genres = mysqli_fetch_assoc($result)) {
                                ?>
                                    <li>
                                        <a href="genre.php?genre=<?php echo $genres['genre']; ?>"><?php echo $genres['genre']; ?></a>
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
                        <!--                        <li class="dropdown first">-->
                        <!--                            <a class="btn btn-default dropdown-toggle lv1" href="#">-->
                        <!--                                Music-->
                        <!--                            </a>-->
                        <!--                        </li>-->
                    </ul>
                    <ul class="nav navbar-nav flex-child-menu menu-right">
                        <!--                        <li class="dropdown first">-->
                        <!--                            <a class="btn btn-default dropdown-toggle lv1" data-toggle="dropdown" data-hover="dropdown">-->
                        <!--                                Favourites <i class="fa fa-angle-down" aria-hidden="true"></i>-->
                        <!--                            </a>-->
                        <!--                            <ul class="dropdown-menu level1">-->
                        <!--                                <li><a href="userfavoritegrid.html">Movies</a></li>-->
                        <!--                                <li><a href="userfavoritegrid.html">Tv Shows</a></li>-->
                        <!--                               <li><a href="userfavoritegrid.html">Music</a></li>-->
                        <!---->
                        <!--                            </ul>-->
                        <!--                        </li>-->
                        <li class=""><a href="request.php">Request</a></li>
                        <li class="btn signupLink"><a href="../dashboard/">Profile</a></li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </nav>
            <!-- search form -->
            <!-- top search form -->
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


    <div class="page-single" style="padding-top: 100px">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="topbar-filter fw">

                        <p><?php echo $series; ?> Season <?php echo $season; ?></p>


                    </div>
                    <div class="flex-wrap-movielist mv-grid-fw">
                        <?php
                        while ($shows = mysqli_fetch_assoc($resultx)) {
                            $name = $shows['showname'];
                            $episode = $shows['epNum'];
                            $sql = "SELECT * FROM episodeslink WHERE showname = '" . $name . "' AND season = '" . $season . "' AND episodeNum = '" . $episode . "'";
                            $res = mysqli_query($conn, $sql);
                            while ($series = mysqli_fetch_assoc($res)) { ?>
                                <div class="movie-item-style-2 movie-item-style-1 thumbnail">
                                    <a href="episode.php?show=<?php echo $shows['showname']; ?>&episode=<?php echo $episode; ?>&season=<?php echo $season; ?>">
                                        <img class="lazy" style="height: auto" data-src="http://dsconlimited.net/dsconlimitedseries/<?php echo $series['thumbnail']; ?>" alt="">
                                        <div class="mv-item-infor" style="display: grid">
                                            <h6 style="display: block; color: white;"><a href="episode.php?show=<?php echo $shows['showname']; ?>&episode=<?php echo $episode; ?>&season=<?php echo $season; ?>"><?php echo $shows['showname']; ?></a></h6>
                                            <h6 style="display: block; color: white;">Season <a href="series.php?tv-show=<?php echo $shows['season']; ?>"><?php echo $shows['season']; ?></a></h6>
                                            <h6 style="display: block; color: white;">Episode <a href="series.php?tv-show=<?php echo $shows['showname']; ?>"><?php echo $shows['epNum']; ?></a></h6>

                                        </div>
                                    </a>
                                </div>
                        <?php }
                        } ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- footer section-->
    <footer class="ht-footer">
        <div class="ft-copyright">
            <div class="ft-left">
                <p><a target="_blank" href="https://www.dsconlimited.com">Dscon Limited</a></p>
            </div>
            <div class="backtotop">
                <p><a href="#" id="back-to-top">Back to top <i class="ion-ios-arrow-thin-up"></i></a></p>
            </div>
        </div>
    </footer>
    <!-- end of footer section-->

    <script src="js/jquery.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/plugins2.js"></script>
    <script src="js/custom.js"></script>
    <script type="text/javascript" src="js/jquery.lazy/jquery.lazy.min.js"></script>

    <script>
        $('.lazy').Lazy({
            // your configuration goes here
            scrollDirection: 'vertical',
            effect: 'fadeIn',
            visibleOnly: true,
            onError: function(element) {
                console.log('error loading ' + element.data('src'));
            }
        });
    </script>
</body>

<!-- moviegridfw07:38-->

</html>