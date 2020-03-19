<?php

require '../includes/login_status.php';

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $episode = $_GET['episode'];
    $season = $_GET['season'];
    $show = $_GET['series'];

    include_once '../includes/db_conf.php';

    include 'check_payment.php';

    $sql = "SELECT * FROM watchedseries WHERE username = '$username' AND series = '$show' AND season = '$season' AND episode = '$episode'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    if ($count == 0) {
        $sql = "INSERT INTO watchedseries (username, series, season, episode) VALUES ('$username', '$show', '$season', '$episode')";
        mysqli_query($conn, $sql);
        $time = 0;
    } else {
        $user = mysqli_fetch_assoc($result);
        $time = $user['currentTime'];
    }

    $sql = "SELECT * FROM episodeslink WHERE season = '" . $season . "' AND episodeNum = '" . $episode . "' AND showname = '" . $show . "'";
    $result = mysqli_query($conn, $sql);
    $episode = mysqli_fetch_assoc($result);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dscon | <?php echo $show ?></title>

    <link rel="shortcut icon" href="images/logo/favicon.ico" type="image/x-icon">

    <!-- CSS files -->
    <link rel="stylesheet" href="css/plugins.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/player.css">
    <link rel="stylesheet" href="css/plyr.css">

    <link href="../node_modules/video.js/dist/video-js.min.css" rel="stylesheet">
    <script src="../node_modules/video.js/dist/video.min.js"></script>
    <script src="../node_modules/videojs-contrib-hls/dist/videojs-contrib-hls.min.js"></script>

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

    <!--TODO: add codecs-->

    <video id="my_video_1" class="video-js vjs-default-skin" controls preload="auto" width="640" height="268" data-setup='{}'>
    </video>

    <script>
        const player = videojs('my_video_1');
        player.src({
            src: 'http://dsconlimited.net/dsconlimitedseries/<?php echo $episode['epLink']; ?>',
            type: 'application/x-mpegURL'
        });
    </script>

</body>

</html>