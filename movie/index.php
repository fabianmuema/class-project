<?php

include('../includes/top-cache.php'); 


include_once '../includes/db_conf.php';

include "../includes/login_status.php";


$sql = "SELECT * FROM movies ORDER BY id DESC LIMIT 6";
$result = mysqli_query($conn, $sql);

//convert mins to hours and mins
function convertToHoursMins($time, $format = '%02d:%02d')
{
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}

//generate random color
function random_color_part()
{
    return str_pad(dechex(mt_rand(120, 255)), 2, '0', STR_PAD_LEFT);
}

function random_color()
{
    return random_color_part() . random_color_part() . random_color_part();
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

<!-- homev206:52-->

<head>
    <!-- Basic need -->
    <title>Dscon | Movies</title>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Dscon Movies">
    <link rel="profile" href="#">

    <link rel="shortcut icon" href="images/logo/favicon.ico" type="image/x-icon">

    <!-- Mobile specific meta -->
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone-no">

    <!-- CSS files -->
    <link rel="stylesheet" href="css/plugins.css">
    <link rel="stylesheet" href="css/style.css">
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
                    <a href="index.php"><img class="logo " src="images/logo/d_logo-transparent-black.png" alt="Dscon Logo" width="40" height="40"></a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse flex-parent" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav flex-child-menu menu-left">
                        <li class="hidden">
                            <a href="#page-top"></a>
                        </li>
                        <li class="dropdown first">
                            <a class="btn btn-default lv1" href="#">
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
                        <!--<!--								<li><a href="userfavoritegrid.html">Music</a></li>-->
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
    <?php $sql = "SELECT * FROM movies ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $featured = mysqli_fetch_assoc($result);
    $backdrop = $featured['backdrop'];
    ?>
    <div class="slider sliderv2" style="background: linear-gradient( rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8) ), url('http://dsconlimited.net/dsconlimitedmovies/<?php echo  $backdrop; ?>');">
        <div class="container">
            <div class="row">
                <div class="slider-single-item">

                    <div class="movie-item">
                        <div class="row">
                            <div class="col-md-8 col-sm-12 col-xs-12">
                                <div class="title-in">
                                    <div class="cate">
                                        <?php
                                        $movie = $featured["name"];
                                        $sql = "SELECT * FROM moviegenres WHERE movie='" . $movie . "'";
                                        $result = mysqli_query($conn, $sql);
                                        $background_colors = array('#C21432', '#f5af19', '#96c93d', "#f80759");

                                        while ($genre = mysqli_fetch_assoc($result)) {
                                            $rand_background = $background_colors[array_rand($background_colors)];


                                        ?>
                                            <span style="background: <?php echo $rand_background; ?>"><a href="#"><?php echo $genre['genre']; ?></a></span>

                                        <?php } ?>
                                    </div>
                                    <h1><a href="movie.php?movie=<?php echo $featured["name"]; ?>"><?php echo $featured["name"]; ?><br>
                                        </a></h1>

                                    <div class="mv-details">
                                        <p><?php echo $featured['overview']; ?></p>

                                    </div>
                                    <div class="mv-details">
                                        <p><i class="ion-android-star"></i><span><?php echo $featured['vote_average']; ?></span> /10</p>
                                        <ul class="mv-infor">
                                            <li> Run Time: <?php
                                                            $runtime = $featured['runtime'];
                                                            echo convertToHoursMins($runtime, '%2dh%2dmin'); ?></li>
                                            <!-- <li> Homepage: <a style="color: #DD003F;" href="<?php echo $featured['homepage']; ?>"><?php echo $featured['homepage']; ?></a> </li> -->
                                            <li> Release: <?php $originalDate = $featured['release_date'];
                                                            $newDate = date("d M Y", strtotime($originalDate));
                                                            echo $newDate; ?></li>
                                        </ul>
                                    </div>
                                    <div class="btn-transform transform-vertical">
                                        <div><a href="player.php?movie=<?php echo $featured['name']; ?>" class="item item-1 redbtn">Watch</a></div>
                                        <div><a href="player.php?movie=<?php echo $featured['name']; ?>" class="item item-2 redbtn hvrbtn">Watch</a></div>
                                    </div>
                                    <div class="btn-transform transform-vertical" style="margin-left: 20%">

                                        <div><a href="movie.php?movie=<?php echo $featured['name']; ?>" class="item item-1 redbtn" style="background-color: transparent;border: solid lightgrey 2px;">info</a></div>
                                        <div><a href="movie.php?movie=<?php echo $featured['name']; ?>" class="item item-2 redbtn hvrbtn" style="background-color: transparent;border: solid lightgrey 2px;">info</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="mv-img-2">
                                    <a href="movie.php?movie=<?php echo $featured['name']; ?>"><img class="lazy" style="width: 60%;" data-src="http://dsconlimited.net/dsconlimitedmovies/<?php echo $featured['cover']; ?>" alt=""></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="movie-items  full-width">
        <div class="row">
            <div class="col-md-12">
                <div class="title-hd" style="padding-bottom: 10px">
                    <h5>Featured Tv Shows</h5>
                </div>
                <div class="row d-flex d-row justify-content-between" style="display: flex; padding-bottom: 5px;">
                    <?php
                    $sql = "SELECT * FROM series ORDER BY RAND() LIMIT 2";
                    $result = mysqli_query($conn, $sql);
                    while ($featured = mysqli_fetch_assoc($result)) {
                    ?>
                        <div class="banner">
                            <a href="series.php?tv-show=<?php echo $featured['seriesname']; ?>"><img width="700px" src="http://dsconlimited.net/dsconlimitedseries/<?php echo $featured['folder']; ?>/<?php echo $featured['ban']; ?>"></a>
                        </div>
                    <?php } ?>
                </div>

                <div class="row d-flex d-row justify-content-between" style="display: flex">
                    <?php
                    $sql = "SELECT * FROM series ORDER BY id DESC LIMIT 2";
                    $result = mysqli_query($conn, $sql);
                    while ($featured = mysqli_fetch_assoc($result)) {
                    ?>
                        <div class="banner">
                            <a href="series.php?tv-show=<?php echo $featured['seriesname']; ?>"><img width="700px" src="http://dsconlimited.net/dsconlimitedseries/<?php echo $featured['folder']; ?>/<?php echo $featured['ban']; ?>"></a>
                        </div>
                    <?php } ?>
                </div>
                <br>

                <div class="tabs">
                    <div class="tab-content">
                        <div id="tab1-h5" class="tab active">
                            <div class="row">
                                <div class="slick-multiItem2">
                                    <?php
                                    $sql = "SELECT DISTINCT series FROM watchedseries WHERE username = '" . $username . "' ORDER BY id DESC";
                                    $result = mysqli_query($conn, $sql);
                                    while ($movies = mysqli_fetch_assoc($result)) {
                                        $series = $movies['series'];
                                        $sql = "SELECT DISTINCT season FROM watchedseries WHERE series = '" . $series . "' AND username = '" . $username . "' LIMIT 1";
                                        $res = mysqli_query($conn, $sql);
                                        while ($show = mysqli_fetch_assoc($res)) {
                                            $season = $show['season'];
                                            $sql = "SELECT DISTINCT episode FROM watchedseries WHERE series = '" . $series . "' AND season = '" . $season . "' AND username = '" . $username . "' ORDER BY id DESC LIMIT 1";
                                            $rez = mysqli_query($conn, $sql);
                                            while ($tvshow = mysqli_fetch_assoc($rez)) {
                                                $episode = $tvshow['episode'];
                                                $episode = $episode + 1;
                                                $sql = "SELECT * FROM episodes WHERE showname = '" . $series . "' AND season = '" . $season . "' AND epNum = '" . $episode . "' LIMIT 1";
                                                $nextepisoderesult = mysqli_query($conn, $sql);
                                                $count = mysqli_num_rows($nextepisoderesult);
                                                if ($count > 0) {
                                                    while ($nextepisodearray = mysqli_fetch_assoc($nextepisoderesult)) {
                                                        $series = $nextepisodearray['showname'];
                                                        $season = $nextepisodearray['season'];
                                                        $episode = $nextepisodearray['epNum'];
                                                        $sql = "SELECT * FROM episodeslink WHERE showname = '" . $series . "' AND season = '" . $season . "' AND episodeNum = '" . $episode . "' LIMIT 1";
                                                        $nextseriesresult = mysqli_query($conn, $sql);
                                                        while ($episodes = mysqli_fetch_assoc($nextseriesresult)) {


                                    ?>


                                                            <div class="slide-it" style="padding-top: 20px; padding-bottom: 20px;">
                                                                <div class="movie-item">
                                                                    <div class="mv-img">
                                                                        <img class="lazy" data-src="http://dsconlimited.net/dsconlimitedseries/<?php echo $episodes['thumbnail']; ?>" alt="">
                                                                    </div>
                                                                    <div class="hvr-inner">
                                                                        <a href="episode.php?show=<?php echo $series; ?>&season=<?php echo $season; ?>&episode=<?php echo $episode; ?>"> Info <i class="ion-android-arrow-dropright"></i> </a>
                                                                    </div>
                                                                    <div class="title-in">
                                                                        <h5><a href="episode.php?show=<?php echo $series; ?>&season=<?php echo $season; ?>&episode=<?php echo $episode; ?>" style="color: white;"><?php echo $series; ?></a></5>
                                                                            <h5><a href="episode.php?show=<?php echo $series; ?>&season=<?php echo $season; ?>&episode=<?php echo $episode; ?>" style="color: white;">Season <?php echo $season ?></a></5>
                                                                                <h5><a href="episode.php?show=<?php echo $series; ?>&season=<?php echo $season; ?>&episode=<?php echo $episode; ?>" style="color: white;">Episode <?php echo $episode ?></a></5>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                } else {
                                                    $season = $season + 1;
                                                    $episode = 1;
                                                    $sql = "SELECT * FROM episodes WHERE showname = '" . $series . "' AND season = '" . $season . "' AND epNum = '" . $episode . "'";
                                                    $nextepisoderesult = mysqli_query($conn, $sql);
                                                    if ($count > 0) {
                                                        while ($nextepisodearray = mysqli_fetch_assoc($nextepisoderesult)) {
                                                            $series = $nextepisodearray['showname'];
                                                            $season = $nextepisodearray['season'];
                                                            $season = $nextepisodearray['epNum'];
                                                            $sql = "SELECT * FROM episodeslink WHERE showname = '" . $series . "' AND season = '" . $season . "' AND episodeNum = '" . $episode . "'";
                                                            $nextseriesresult = mysqli_query($conn, $sql);
                                                            while ($episodes = mysqli_fetch_assoc($nextseriesresult)) {
                                                            ?>
                                                                <div class="slide-it">
                                                                    <div class="movie-item">
                                                                        <div class="mv-img">
                                                                            <img class="lazy" data-src="http://dsconlimited.net/dsconlimitedseries/<?php echo $episodes['thumbnail']; ?>" alt="">
                                                                        </div>
                                                                        <div class="hvr-inner">
                                                                            <a href="episode.php?show=<?php echo $series; ?>&season=<?php echo $season; ?>&episode=<?php echo $episode; ?>"> Info <i class="ion-android-arrow-dropright"></i> </a>
                                                                        </div>
                                                                        <div class="title-in">
                                                                            <h5><a href="episode.php?show=<?php echo $series; ?>&season=<?php echo $season; ?>&episode=<?php echo $episode; ?>" style="color: white;"><?php echo $series; ?></a></5>
                                                                                <h5><a href="episode.php?show=<?php echo $series; ?>&season=<?php echo $season; ?>&episode=<?php echo $episode; ?>" style="color: white;">Season <?php echo $season ?></a></5>
                                                                                    <h5><a href="episode.php?show=<?php echo $series; ?>&season=<?php echo $season; ?>&episode=<?php echo $episode; ?>" style="color: white;">Episode <?php echo $episode ?></a></5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                        <?php
                                                            }
                                                        }
                                                    } else {
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    <?php  } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="title-hd" style="padding-bottom: -5px; padding-top: 0">
                    <h5>Recently Added Movies</h5>
                </div>
                <div class="tabs">
                    <div class="tab-content">
                        <div id="tab1-h5" class="tab active">
                            <div class="row">
                                <div class="slick-multiItem2">
                                    <?php
                                    $sql = "SELECT * FROM movies ORDER BY id DESC LIMIT 10";
                                    $result = mysqli_query($conn, $sql);
                                    while ($movies = mysqli_fetch_assoc($result)) {
                                        $moviename = $movies['name'];
                                        $year = $movies['year'];
                                    ?>
                                        <a href="movie.php?movie=<?php echo $moviename; ?>">
                                            <div class="slide-it">
                                                <div class="movie-item">
                                                    <div class="mv-img">

                                                        <img class="lazy" data-src="http://dsconlimited.net/dsconlimitedmovies/<?php echo $movies['cover']; ?>" alt="">
                                                    </div>

                                                </div>
                                            </div>
                                        </a>
                                    <?php  } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="title-hd" style="padding-bottom: -5px; padding-top: 0">
                    <h5>Most Watched Movies on Dscon</h5>
                </div>
                <div class="tabs">
                    <div class="tab-content">
                        <div id="tab1-h5" class="tab active">
                            <div class="row">
                                <div class="slick-multiItem2">
                                    <?php
                                    include '../includes/stats_db.php';
                                    $sql = "SELECT movie, MAX(number) AS number FROM no_movies_watched GROUP BY movie ORDER BY number DESC LIMIT 7";
                                    $result = mysqli_query($conn, $sql);
                                    while ($movie = mysqli_fetch_assoc($result)) {
                                        $moviename = $movie['movie'];

                                        include '../includes/db_conf.php';
                                        $sql = "SELECT * FROM movies WHERE name = '" . $moviename . "'";
                                        $resultx = mysqli_query($conn, $sql);
                                        while ($movies = mysqli_fetch_assoc($resultx)) {
                                            $name = $movies['name'];
                                    ?>
                                            <a href="movie.php?movie=<?php echo $name; ?>">
                                                <div class="slide-it">
                                                    <div class="movie-item">
                                                        <div class="mv-img">

                                                            <img class="lazy" data-src="http://dsconlimited.net/dsconlimitedmovies/<?php echo $movies['cover']; ?>" alt="">
                                                        </div>

                                                    </div>
                                                </div>
                                            </a>
                                    <?php  }
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="title-hd" style="padding-bottom: -5px; padding-top: -5px">
                    <h5>New Releases</h5>
                </div>
                <div class="tabs">
                    <div class="tab-content">
                        <div id="tab1-h5" class="tab active">
                            <div class="row">
                                <div class="slick-multiItem2">
                                    <?php
                                    $sql = "SELECT * FROM movies ORDER BY year DESC LIMIT 7";
                                    $result = mysqli_query($conn, $sql);
                                    while ($movies = mysqli_fetch_assoc($result)) {
                                        $moviename = $movies['name'];
                                        $year = $movies['year'];
                                    ?>
                                        <a href="movie.php?movie=<?php echo $moviename; ?>">
                                            <div class="slide-it">
                                                <div class="movie-item">
                                                    <div class="mv-img">

                                                        <img class="lazy" data-src="http://dsconlimited.net/dsconlimitedmovies/<?php echo $movies['cover']; ?>" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    <?php  } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="title-hd" style="padding-top: 10px; padding-bottom: 10px">
                    <h5>Recently Added Tv Episodes</h5>
                    <a href="episodesgrid.php" class="viewall">View all <i class="ion-ios-arrow-right"></i></a>
                </div>
                <div class="tabs" style="padding-bottom: 10px">
                    <div class="tab-content">
                        <div id="tab21-h5" class="tab active">
                            <div class="row">
                                <div class="slick-multiItem2">
                                    <?php
                                    $sql = "SELECT * FROM episodes ORDER BY id DESC LIMIT 7";
                                    $result = mysqli_query($conn, $sql);
                                    while ($recent_episodes = mysqli_fetch_assoc($result)) {
                                        $name = $recent_episodes['showname'];
                                        $season = $recent_episodes['season'];
                                        $episode = $recent_episodes['epNum'];
                                        $sql  = "SELECT * FROM episodeslink WHERE showname = '" . $name . "' AND season = '" . $season . "' AND episodeNum= '" . $episode . "'";
                                        $res = mysqli_query($conn, $sql);
                                        while ($episodes = mysqli_fetch_assoc($res)) {
                                    ?>
                                            <div class="slide-it">
                                                <div class="movie-item">
                                                    <div class="mv-img" style="height: auto">
                                                        <img class="lazy" data-src="http://dsconlimited.net/dsconlimitedseries/<?php echo $episodes['thumbnail']; ?>" alt="">
                                                    </div>
                                                    <div class="hvr-inner">
                                                        <a href="episode.php?show=<?php echo $name; ?>&season=<?php echo $season; ?>&episode=<?php echo $episode; ?>"> Info <i class="ion-android-arrow-dropright"></i> </a>
                                                    </div>
                                                    <div class="title-in">
                                                        <h5><a href="episode.php?show=<?php echo $name; ?>&season=<?php echo $season; ?>&episode=<?php echo $episode; ?>" style="color: white;"><?php echo $recent_episodes['showname']; ?></a></5>
                                                            <h5><a href="episode.php?show=<?php echo $name; ?>&season=<?php echo $season; ?>&episode=<?php echo $episode; ?>" style="color: white;">Season <?php echo $season ?></a></5>
                                                                <h5><a href="episode.php?show=<?php echo $name; ?>&season=<?php echo $season; ?>&episode=<?php echo $episode; ?>" style="color: white;">Episode <?php echo $episode ?></a></5>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php }
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="title-hd" style="padding-bottom: 20px">
                    <h5>Recently Added Seasons</h5>
                </div>
                <div class="tabs">
                    <div class="tab-content">
                        <div id="tab1-h5" class="tab active">
                            <div class="row">
                                <div class="slick-multiItem2">
                                    <?php
                                    $sql = "SELECT * FROM seasons ORDER BY id DESC LIMIT 7";
                                    $result = mysqli_query($conn, $sql);
                                    while ($recent_seasons = mysqli_fetch_assoc($result)) {
                                        $seriesname = $recent_seasons['showname'];
                                        $season = $recent_seasons['season'];
                                        $seasonposter = $recent_seasons['seasonPoster'];
                                    ?>
                                        <a href="episodes.php?series=<?php echo $seriesname; ?>&season=<?php echo $season; ?>">
                                            <div class="slide-it">
                                                <div class="movie-item">
                                                    <div class="mv-img">

                                                        <img src="http://dsconlimited.net/dsconlimitedseries/<?php echo $seriesname; ?>/<?php echo $seasonposter; ?>" alt="">
                                                    </div>

                                                </div>
                                            </div>
                                        </a>
                                    <?php  } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

                <div class="title-hd" style="padding: 10px">
                    <h5>Networks</h5>
                </div>
                <div class="tabs">
                    <div class="tab-content">
                        <div id="tab21-h5" class="tab active">
                            <div class="row">
                                <div class="slick-multiItem2">
                                    <?php
                                    $sql = "SELECT DISTINCT network, count(network) AS number FROM series GROUP BY network ORDER BY number DESC";
                                    $result = mysqli_query($conn, $sql);
                                    while ($network = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <a href="network.php?network=<?php echo $network['network']; ?>" title="<?php echo $network['network']; ?>">
                                            <div class="slide-it">
                                                <div class="movie-item" style="background-color: white;">
                                                    <?php
                                                    $name = $network['network'];
                                                    $sql = "SELECT DISTINCT networkimg FROM series WHERE network = '" . $name . "'";
                                                    $imageresult = mysqli_query($conn, $sql);
                                                    while ($imagearray = mysqli_fetch_assoc($imageresult)) {
                                                        $image = $imagearray['networkimg'];
                                                    ?>
                                                        <div class="mv-img" style="background: url(http://dsconlimited.net/dsconlimitedtrailers/<?php echo $image ?>); background-size: contain; height: 100px; background-position: center!important; background-repeat: no-repeat ">
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </a>

                                    <?php }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="title-hd" style="padding-bottom: 20px; padding-top: 20px;">
                    <h5>Recently Added Tv Shows</h5>
                </div>
                <div class="tabs">
                    <div class="tab-content">
                        <div id="tab21-h5" class="tab active">
                            <div class="row">
                                <div class="slick-multiItem2">
                                    <?php
                                    $sql = "SELECT * FROM series ORDER BY id desc LIMIT 6;";
                                    $results = mysqli_query($conn, $sql);
                                    while ($series = mysqli_fetch_assoc($results)) {
                                        $seriesname = $series['seriesname'];
                                        $folder = $series['folder'];
                                        $year = $series['year'];
                                        $poster = $series['poster']
                                    ?>
                                        <div class="slide-it">
                                            <div class="movie-item">
                                                <a href="http://dsconlimited.net/movie/series.php?tv-show=<?php echo $seriesname; ?>">
                                                    <div class="mv-img">
                                                        <img class="lazy" data-src="http://dsconlimited.net/dsconlimitedseries/<?php echo $folder; ?>/<?php echo $poster; ?>" alt="">
                                                    </div>
                                                </a>


                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="title-hd" style="padding-bottom: 20px; padding-top: 20px;">
                    <h5>Most Watched Tv Shows</h5>
                </div>
                <div class="tabs">
                    <div class="tab-content">
                        <div id="tab21-h5" class="tab active">
                            <div class="row">
                                <div class="slick-multiItem2">
                                    <?php
                                    include "../includes/stats_db.php";
                                    $sql = "SELECT series, MAX(number) AS number FROM no_shows_watched GROUP BY series ORDER BY number DESC LIMIT 7";
                                    $resultx = mysqli_query($conn, $sql);
                                    while ($show = mysqli_fetch_assoc($resultx)) {
                                        $name = $show['series'];
                                        include '../includes/db_conf.php';
                                        $sql = "SELECT * FROM series WHERE seriesname = '" . $name . "'";
                                        $results = mysqli_query($conn, $sql);
                                        while ($series = mysqli_fetch_assoc($results)) {
                                            $seriesname = $series['seriesname'];
                                            $folder = $series['folder'];
                                            $year = $series['year'];
                                            $poster = $series['poster'];
                                    ?>
                                            <div class="slide-it">
                                                <div class="movie-item">
                                                    <a href="http://dsconlimited.net/movie/series.php?tv-show=<?php echo $seriesname; ?>">
                                                        <div class="mv-img">
                                                            <img class="lazy" data-src="http://dsconlimited.net/dsconlimitedseries/<?php echo $folder; ?>/<?php echo $poster; ?>" alt="">
                                                        </div>
                                                    </a>


                                                </div>
                                            </div>
                                    <?php
                                        }
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- <div class="title-hd">
					<h5>Recommended Movies</h5>
					<a href="#" class="viewall">View all <i class="ion-ios-arrow-right"></i></a>
				</div> -->
                <!-- <div class="tabs">
					<div class="tab-content">
						<div id="tab21-h5" class="tab active">
							<div class="row">
								<div class="slick-multiItem2">
									<div class="slide-it">
										<div class="movie-item">
											<div class="mv-img">
												<img src="images/uploads/mv-it7.jpg" alt="">
											</div>
											<div class="hvr-inner">
												<a href="moviesingle.html"> Info <i class="ion-android-arrow-dropright"></i>
												</a>
											</div>
											<div class="title-in">
												<h6><a href="#">Interstellar</a></h6>
												<p><i class="ion-android-star"></i><span>7.4</span> /10</p>
											</div>
										</div>
									</div>
									<div class="slide-it">
										<div class="movie-item">
											<div class="mv-img">
												<img src="images/uploads/mv-it8.jpg" alt="">
											</div>
											<div class="hvr-inner">
												<a href="moviesingle.html"> Info <i class="ion-android-arrow-dropright"></i>
												</a>
											</div>
											<div class="title-in">
												<h6><a href="#">The revenant</a></h6>
												<p><i class="ion-android-star"></i><span>7.4</span> /10</p>
											</div>
										</div>
									</div>
									<div class="slide-it">
										<div class="movie-item">
											<div class="mv-img">
												<img src="images/uploads/mv-it9.jpg" alt="">
											</div>
											<div class="hvr-inner">
												<a href="moviesingle.html"> Info <i class="ion-android-arrow-dropright"></i>
												</a>
											</div>
											<div class="title-in">
												<h6><a href="#">Die hard</a></h6>
												<p><i class="ion-android-star"></i><span>7.4</span> /10</p>
											</div>
										</div>
									</div>
									<div class="slide-it">
										<div class="movie-item">
											<div class="mv-img">
												<img src="images/uploads/mv-it4.jpg" alt="">
											</div>
											<div class="hvr-inner">
												<a href="moviesingle.html"> Info <i class="ion-android-arrow-dropright"></i>
												</a>
											</div>
											<div class="title-in">
												<h6><a href="#">The walk</a></h6>
												<p><i class="ion-android-star"></i><span>7.4</span> /10</p>
											</div>
										</div>
									</div>
									<div class="slide-it">
										<div class="movie-item">
											<div class="mv-img">
												<img src="images/uploads/mv-it5.jpg" alt="">
											</div>
											<div class="hvr-inner">
												<a href="moviesingle.html"> Info <i class="ion-android-arrow-dropright"></i>
												</a>
											</div>
											<div class="title-in">
												<h6><a href="#">Die hard</a></h6>
												<p><i class="ion-android-star"></i><span>7.4</span> /10</p>
											</div>
										</div>
									</div>
									<div class="slide-it">
										<div class="movie-item">
											<div class="mv-img">
												<img src="images/uploads/mv-it6.jpg" alt="">
											</div>
											<div class="hvr-inner">
												<a href="moviesingle.html"> Info <i class="ion-android-arrow-dropright"></i>
												</a>
											</div>
											<div class="title-in">
												<h6><a href="#">Interstellar</a></h6>
												<p><i class="ion-android-star"></i><span>7.4</span> /10</p>
											</div>
										</div>
									</div>
									<div class="slide-it">
										<div class="movie-item">
											<div class="mv-img">
												<img src="images/uploads/mv-it7.jpg" alt="">
											</div>
											<div class="hvr-inner">
												<a href="moviesingle.html"> Info <i class="ion-android-arrow-dropright"></i>
												</a>
											</div>
											<div class="title-in">
												<h6><a href="#">Die hard</a></h6>
												<p><i class="ion-android-star"></i><span>7.4</span> /10</p>
											</div>
										</div>
									</div>
									<div class="slide-it">
										<div class="movie-item">
											<div class="mv-img">
												<img src="images/uploads/mv-it8.jpg" alt="">
											</div>
											<div class="hvr-inner">
												<a href="moviesingle.html"> Info <i class="ion-android-arrow-dropright"></i>
												</a>
											</div>
											<div class="title-in">
												<h6><a href="#">Die hard</a></h6>
												<p><i class="ion-android-star"></i><span>7.4</span> /10</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>  -->
            </div>
        </div>
    </div>



    <!-- footer v2 section-->
    <footer class="ht-footer full-width-ft">
        <div class="row">
            <div class="ft-copyright">
                <div class="ft-left">
                    <p><a target="_blank" href="http://dsconlimited.net">Dscon Limited</a></p>
                </div>
                <div class="backtotop">
                    <p><a href="#" id="back-to-top">Back to top <i class="ion-ios-arrow-thin-up"></i></a></p>
                </div>
            </div>
        </div>
    </footer>
    <!-- end of footer v2 section-->

    <script defer src="js/jquery-3.1.0.min.js"></script>
    <script defer src="js/plugins.js"></script>
    <script defer src="js/plugins2.js"></script>
    <script defer src="js/custom.js"></script>
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

</body>





<!-- homev207:28-->

</html>

<?php

include('../includes/bottom-cache.php');
?>