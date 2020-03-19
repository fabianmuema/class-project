<?php

include "../includes/login_status.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    include '../includes/db_conf.php';

    $sql = "SELECT * FROM favourites WHERE username ='" . $username . "' AND category = 'movie'";
    $resultx = mysqli_query($conn, $sql);


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

<!-- userfavoritegrid13:40-->
<head>
    <!-- Basic need -->
    <title>Dscon | Favourites</title>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <link rel="profile" href="#">

    <link rel="shortcut icon" href="images/logo/favicon.ico" type="image/x-icon">

    <!--Google Font-->
    <link rel="stylesheet" href='http://fonts.googleapis.com/css?family=Dosis:400,700,500|Nunito:300,400,600'/>
    <!-- Mobile specific meta -->
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone-no">

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
                        <a href="#"></a>
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

                </ul>
                <ul class="nav navbar-nav flex-child-menu menu-right">
                    <li class="dropdown first">
                        <a class="btn btn-default dropdown-toggle lv1" data-toggle="dropdown" data-hover="dropdown">
                            Favourites <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </a>
                        <ul class="dropdown-menu level1">
                            <li><a href=favourite.php">Movies</a></li>
                            <li><a href="fabourites.php">Tv Shows</a></li>

                        </ul>
                    </li>
                    <li class=""><a href="request.php">Request</a></li>
                    <li class="btn"><a href="../dashboard/">Profile</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
        <!-- search form -->
        <div class="top-search">
            <select>
                <option value="united">Movies</option>
                <option value="saab">Others</option>
            </select>
            <input type="text" placeholder="Search for a movie, TV Show or celebrity that you are looking for">
        </div>

    </div>

</header>
<!-- END | Header -->

<div class="page-single" style="padding-top: 130px">
    <div class="container">
        <div class="row ipad-width2">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="topbar-filter user">
                    <?php
                    $count = mysqli_num_rows($resultx);

                    ?>
                    <p>Found <span><?php echo number_format($count); ?> movies</span> in total</p>
                    <label>Sort by:</label>
                    <select>
                        <option value="range">-- Choose option --</option>
                        <option value="saab">-- Choose option 2--</option>
                    </select>
                    <a href="userfavoritelist.html" class="list"><i class="ion-ios-list-outline "></i></a>
                    <a href="userfavoritegrid.html" class="grid"><i class="ion-grid active"></i></a>
                </div>
                <div class="flex-wrap-movielist grid-fav">
                    <?php
                    while ($favourite = mysqli_fetch_assoc($resultx)) {

                        ?>
                        <div class="movie-item-style-2 movie-item-style-1 style-3">
                            <img src="images/uploads/mv1.jpg" alt="">
                            <div class="hvr-inner">
                                <a href="<?php echo $link ?>"> Read more <i class="ion-android-arrow-dropright"></i>
                                </a>
                            </div>
                            <div class="mv-item-infor">
                                <h6><a href="moviesingle.html">oblivion</a></h6>
                                <p class="rate"><i class="ion-android-star"></i><span>8.1</span> /10</p>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="topbar-filter">
<!--                    <label>Movies per page:</label>-->
<!--                    <select>-->
<!--                        <option value="range">20 Movies</option>-->
<!--                        <option value="saab">10 Movies</option>-->
<!--                    </select>-->

                    <div class="pagination2">
                        <span>Page 1 of 2:</span>
                        <a class="active" href="#">1</a>
                        <a href="#">2</a>
                        <a href="#">3</a>
                        <a href="#">...</a>
                        <a href="#">78</a>
                        <a href="#">79</a>
                        <a href="#"><i class="ion-arrow-right-b"></i></a>
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

<script src="js/jquery.js"></script>
<script src="js/plugins.js"></script>
<script src="js/plugins2.js"></script>
<script src="js/custom.js"></script>
</body>

<!-- userfavoritegrid13:49-->
</html>