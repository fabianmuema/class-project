<?php
require '../includes/login_status.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    include_once '../includes/db_conf.php';

    $tvshow = urldecode($_GET['tv-show']);
    $tvshow = mysqli_real_escape_string($conn, $tvshow);


    $sql = "SELECT * FROM series WHERE seriesname='" . $tvshow . "'";
    $results = mysqli_query($conn, $sql);
    $tvshow = mysqli_fetch_assoc($results);
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

<!-- seriessingle11:03-->

<head>
    <!-- Basic need -->
    <title>Dscon | <?php echo $tvshow['seriesname']; ?> (<?php echo $tvshow['year']; ?>)</title>
    <meta charset="UTF-8">
    <meta name="description" content="<?php echo $tvshow['overview']; ?>">
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
                        <!--                         <li><a href="userfavoritegrid.html">Music</a></li>-->
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
        </div>

    </header>
    <!-- END | Header -->

    <div class="page-single movie-single movie_single" style="background: transparent; ">
        <div class="container" style="margin-top: -150px;">
            <div class="row ipad-width2">
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="movie-img" style="height: 400px">
                        <img style="height: 350px; width: 300px" src="http://dsconlimited.net/dsconlimitedseries/<?php echo $tvshow['folder']; ?>/<?php echo $tvshow['poster']; ?>" alt="">
                        <div class="movie-btn" style="width: 300px">
                            <!-- <div class="btn-transform transform-vertical red">
                            <div><a href="player.php?movie=<?php echo $movie['name']; ?>" class="item item-1 redbtn"> <i
                                            class="ion-play"></i> Play</a></div>
                            <div><a href="player.php?movie=<?php echo $movie['name']; ?>"
                                    class="item item-2 redbtn fancybox-media hvr-grow"><i class="ion-play"></i></a>
                            </div>
                        </div> -->
                            <div class="btn-transform transform-vertical red">
                                <div><a href="#" class="item item-1 yellowbtn"> <i class="ion-play"></i>Watch Trailer</a>
                                </div>
                                <div><a href="#open-modal" class="item item-2 yellowbtn"><i class="ion-play"></i></a></div>
                                <div id="open-modal" class="modal-window">
                                    <div>
                                        <h3 style="color: white"><?php echo $tvshow['seriesname']; ?> Trailer</h3>
                                        <a href="#" title="Close" class="modal-close">Close</a>
                                        <br>
                                        <div>
                                            <video width="100%" height="100%" controls>
                                                <source src="http://dsconlimited.net/dsconlimitedtrailers/<?php echo $tvshow['trailer']; ?>" type="video/mp4">
                                                <source src="http://dsconlimited.net/dsconlimitedtrailers/<?php echo $tvshow['trailer']; ?>" type="video/webm">
                                                <source src="http://dsconlimited.net/dsconlimitedtrailers/<?php echo $tvshow['trailer']; ?>" type="video/flv">
                                            </video>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-sm-12 col-xs-12">
                    <div class="movie-single-ct main-content">
                        <div class="row d-row d-flex" style="display: flex; position: relative; margin-bottom: 20px;">
                            <div style="margin-right: 40px;">
                                <h1 class="bd-hd"><?php echo $tvshow['seriesname']; ?>
                                    <span> <?php echo $tvshow['year']; ?> - </span></h1>
                                <!--                            <div class="social-btn">-->
                                <!--                                <a href="#" class="parent-btn"><i class="ion-heart"></i> Add to Favorite</a>-->
                                <!--                            </div>-->
                                <!--                            </div>-->
                            </div>
                            <div>
                                <!-- <div class="networks" style="position: absolute; right: 0">
                                <img src="http://dsconlimited.net/dsconlimitednetworks/<?php echo $tvshow["network"]; ?>.jpg" width="100px" height="100px" alt="">
                            </div> -->
                            </div>

                        </div>
                        <div class="movie-rate">
                            <div class="rate">
                                <i class="ion-android-star"></i>
                                <p><span><?php echo $tvshow['vote_average']; ?></span> /10<br>
                                </p>
                            </div>
                            <div class="rate" style="color: white; margin-left: 40px">
                                <span class="status" style="padding-right: 20px">Status: </span> <?php
                                                                                                    $status =  $tvshow['status'];
                                                                                                    if ($status == 1) {
                                                                                                        $status = "Continuing";
                                                                                                        $color = "green";
                                                                                                    } else {
                                                                                                        $status = "Ended";
                                                                                                        $color = "red";
                                                                                                    }
                                                                                                    echo "<span style='background: {$color}; padding:0 5px 0 5px; border: solid 1px transparent; border-radius: 7px;'>" . $status . "</span>"; ?>
                            </div>
                            <div class="rate" style="color: white; margin-left: 40px;">
                                <span class="homepage" style="padding-right: 20px;">Homepage: </span> <a style="color: #DD003F" href="<?php echo $tvshow['homepage']; ?>"><?php echo $tvshow['homepage']; ?></a>
                            </div>
                        </div>
                        <div class="movie-tabs">
                            <div class="tabs">
                                <ul class="tab-links tabs-mv tabs-series">
                                    <li class="active"><a href="#overview">Overview</a></li>
                                    <!--                                <li><a href="#reviews"> Reviews</a></li>-->
                                    <!--                                <li><a href="#cast"> Cast</a></li>-->
                                    <li><a href="#season"> Seasons</a></li>
                                    <!--                                <li><a href="#moviesrelated"> Related</a></li>-->
                                </ul>
                                <div class="tab-content">
                                    <div id="overview" class="tab active">
                                        <div class="row">
                                            <div class="col-md-8 col-sm-12 col-xs-12">
                                                <p><?php echo $tvshow['overview']; ?></p>
                                                <div class="title-hd-sm">
                                                    <!--                                                <h4>Seasons</h4>-->
                                                    <!--                                                <a href="seasons.php" class="time">View All Seasons <i-->
                                                    <!--                                                            class="ion-ios-arrow-right"></i></a>-->
                                                </div>
                                                <!-- movie cast -->
                                                <div class="mvcast-item">
                                                    <div class="cast-it">


                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-4 col-xs-12 col-sm-12">
                                                <!--                                            <div class="sb-it">-->
                                                <!--                                                <h6>Director: </h6>-->
                                                <!--                                                <p><a href="#">Mark Cendrowski</a></p>-->
                                                <!--                                            </div>-->
                                                <!--                                            <div class="sb-it">-->
                                                <!--                                                <h6>Writer: </h6>-->
                                                <!--                                                <p><a href="#"> Chuck Lorre,</a> <a href="#">Bill Prady</a></p>-->
                                                <!--                                            </div>-->
                                                <!--                                            <div class="sb-it">-->
                                                <!--                                                <h6>Stars: </h6>-->
                                                <!--                                                <p><a href="#">Robert Downey Jr,</a> <a href="#">Chris Evans,</a> <a-->
                                                <!--                                                            href="#">Mark Ruffalo,</a><a href="#"> Scarlett-->
                                                <!--                                                        Johansson</a></p>-->
                                                <!--                                            </div>-->
                                                <div class="sb-it">
                                                    <h6>Genre:</h6>
                                                    <p><?php
                                                        if ($_SERVER["REQUEST_METHOD"] == "GET") {
                                                            $name = $_GET['tv-show'];
                                                            $sql = "SELECT DISTINCT genre FROM seriesgenres where showname = '" . $name . "'";
                                                            $results = mysqli_query($conn, $sql);
                                                            while ($series = mysqli_fetch_assoc($results)) {
                                                        ?>
                                                                <a href="genres.php?genre=<?php echo $series['genre']; ?>"><?php echo $series['genre']; ?></a>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </p>

                                                </div>
                                                <div class="sb-it">
                                                    <h6>Release Date:</h6>
                                                    <p><?php echo $tvshow['first_air_date']; ?></p>
                                                </div>
                                                <!--                                            <div class="sb-it">-->
                                                <!--                                                <h6>Run Time:</h6>-->
                                                <!--                                                <p>22 min</p>-->
                                                <!--                                            </div>-->
                                                <!--                                            <div class="sb-it">-->
                                                <!--                                                <h6>MMPA Rating:</h6>-->
                                                <!--                                                <p>TV-14</p>-->
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
                                            </div>
                                        </div>
                                    </div>

                                    <div id="season" class="tab">
                                        <div class="row">
                                            <div class="mvcast-item" style="display: flex; flex-wrap: wrap;">
                                                <?php
                                                $name = $tvshow['seriesname'];
                                                $sql = "SELECT DISTINCT season FROM episodes WHERE showname = '" . $name . "' ORDER BY season ASC";
                                                $result = mysqli_query($conn, $sql);
                                                while ($series = mysqli_fetch_assoc($result)) {
                                                    $season = $series['season'];
                                                    $sql = "SELECT * FROM episodes WHERE season = '" . $season . "' AND showname = '" . $name . "' ORDER BY season DESC";
                                                    $res = mysqli_query($conn, $sql);
                                                    $season = mysqli_fetch_assoc($res)
                                                ?>
                                                    <div class="cast-it">
                                                        <div class="cast-left series-it">
                                                            <a style="margin-right: 0;" href="episodes.php?series=<?php echo $tvshow['seriesname']; ?>&season=<?php echo $series['season']; ?>">
                                                                <div>
                                                                    <p><?php echo $tvshow['seriesname']; ?></p>
                                                                    <a style="display: flex" href="episodes.php?series=<?php echo $tvshow['seriesname']; ?>&season=<?php echo $series['season']; ?>">Season <?php echo $series['season']; ?></a>
                                                                </div>
                                                        </div>
                                                        </a>
                                                    </div>
                                                <?php } ?>
                                            </div>

                                        </div>
                                    </div>
                                    <div id="moviesrelated" class="tab">
                                        <div class="row">
                                            <h3>Related Shows To</h3>
                                            <h2><?php echo $tvshow['seriesname']; ?></h2>
                                            <div class="topbar-filter">
                                                <p>Found <span>12 movies</span> in total</p>
                                                <label>Sort by:</label>
                                                <select>
                                                    <option value="popularity">Popularity Descending</option>
                                                    <option value="popularity">Popularity Ascending</option>
                                                    <option value="rating">Rating Descending</option>
                                                    <option value="rating">Rating Ascending</option>
                                                    <option value="date">Release date Descending</option>
                                                    <option value="date">Release date Ascending</option>
                                                </select>
                                            </div>
                                            <div class="movie-item-style-2">
                                                <img src="images/uploads/mv1.jpg" alt="">
                                                <div class="mv-item-infor">
                                                    <h6><a href="#">oblivion <span>(2012)</span></a></h6>
                                                    <p class="rate"><i class="ion-android-star"></i><span>8.1</span> /10</p>
                                                    <p class="describe">Earth's mightiest heroes must come together and
                                                        learn to fight as a team if they are to stop the mischievous Loki
                                                        and his alien army from enslaving humanity...</p>
                                                    <p class="run-time"> Run Time: 2h21’ . <span>MMPA: PG-13 </span> .
                                                        <span>Release: 1 May 2015</span></p>
                                                    <p>Director: <a href="#">Joss Whedon</a></p>
                                                    <p>Stars: <a href="#">Robert Downey Jr.,</a> <a href="#">Chris
                                                            Evans,</a> <a href="#"> Chris Hemsworth</a></p>
                                                </div>
                                            </div>
                                            <div class="movie-item-style-2">
                                                <img src="images/uploads/mv2.jpg" alt="">
                                                <div class="mv-item-infor">
                                                    <h6><a href="#">into the wild <span>(2014)</span></a></h6>
                                                    <p class="rate"><i class="ion-android-star"></i><span>7.8</span> /10</p>
                                                    <p class="describe">As Steve Rogers struggles to embrace his role in the
                                                        modern world, he teams up with a fellow Avenger and S.H.I.E.L.D
                                                        agent, Black Widow, to battle a new threat...</p>
                                                    <p class="run-time"> Run Time: 2h21’ . <span>MMPA: PG-13 </span> .
                                                        <span>Release: 1 May 2015</span></p>
                                                    <p>Director: <a href="#">Anthony Russo,</a><a href="#">Joe Russo</a></p>
                                                    <p>Stars: <a href="#">Chris Evans,</a> <a href="#">Samuel L.
                                                            Jackson,</a> <a href="#"> Scarlett Johansson</a></p>
                                                </div>
                                            </div>
                                            <div class="movie-item-style-2">
                                                <img src="images/uploads/mv3.jpg" alt="">
                                                <div class="mv-item-infor">
                                                    <h6><a href="#">blade runner <span>(2015)</span></a></h6>
                                                    <p class="rate"><i class="ion-android-star"></i><span>7.3</span> /10</p>
                                                    <p class="describe">Armed with a super-suit with the astonishing ability
                                                        to shrink in scale but increase in strength, cat burglar Scott Lang
                                                        must embrace his inner hero and help...</p>
                                                    <p class="run-time"> Run Time: 2h21’ . <span>MMPA: PG-13 </span> .
                                                        <span>Release: 1 May 2015</span></p>
                                                    <p>Director: <a href="#">Peyton Reed</a></p>
                                                    <p>Stars: <a href="#">Paul Rudd,</a> <a href="#"> Michael Douglas</a>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="movie-item-style-2">
                                                <img src="images/uploads/mv4.jpg" alt="">
                                                <div class="mv-item-infor">
                                                    <h6><a href="#">Mulholland pride<span> (2013) </span></a></h6>
                                                    <p class="rate"><i class="ion-android-star"></i><span>7.2</span> /10</p>
                                                    <p class="describe">When Tony Stark's world is torn apart by a
                                                        formidable terrorist called the Mandarin, he starts an odyssey of
                                                        rebuilding and retribution.</p>
                                                    <p class="run-time"> Run Time: 2h21’ . <span>MMPA: PG-13 </span> .
                                                        <span>Release: 1 May 2015</span></p>
                                                    <p>Director: <a href="#">Shane Black</a></p>
                                                    <p>Stars: <a href="#">Robert Downey Jr., </a> <a href="#"> Guy
                                                            Pearce,</a><a href="#">Don Cheadle</a></p>
                                                </div>
                                            </div>
                                            <div class="movie-item-style-2">
                                                <img src="images/uploads/mv5.jpg" alt="">
                                                <div class="mv-item-infor">
                                                    <h6><a href="#">skyfall: evil of boss<span> (2013) </span></a></h6>
                                                    <p class="rate"><i class="ion-android-star"></i><span>7.0</span> /10</p>
                                                    <p class="describe">When Tony Stark's world is torn apart by a
                                                        formidable terrorist called the Mandarin, he starts an odyssey of
                                                        rebuilding and retribution.</p>
                                                    <p class="run-time"> Run Time: 2h21’ . <span>MMPA: PG-13 </span> .
                                                        <span>Release: 1 May 2015</span></p>
                                                    <p>Director: <a href="#">Alan Taylor</a></p>
                                                    <p>Stars: <a href="#">Chris Hemsworth, </a> <a href="#"> Natalie
                                                            Portman,</a><a href="#">Tom Hiddleston</a></p>
                                                </div>
                                            </div>
                                            <div class="topbar-filter">
                                                <label>Movies per page:</label>
                                                <select>
                                                    <option value="range">5 Movies</option>
                                                    <option value="saab">10 Movies</option>
                                                </select>
                                                <div class="pagination2">
                                                    <span>Page 1 of 2:</span>
                                                    <a class="active" href="#">1</a>
                                                    <a href="#">2</a>
                                                    <a href="#"><i class="ion-arrow-right-b"></i></a>
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
        </div>
    </div>
    <!-- footer v2 section-->
    <!-- <footer class="ht-footer full-width-ft" style="margin-top: 60px">
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
</footer> -->
    <!-- end of footer v2 section-->
    <script src="js/plyr.min.js"></script>
    <script>
        const player = new Plyr('#player');
    </script>
    <script src="js/jquery.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/plugins2.js"></script>
    <script src="js/custom.js"></script>

</body>

<!-- seriessingle11:24-->

</html>