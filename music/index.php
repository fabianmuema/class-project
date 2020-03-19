<?php

include "../includes/db_conf.php";

include "../includes/login_status.php";

?>

<!DOCTYPE HTML>
<html lang="en">

<head>
    <title>Dscon | Music</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="../img/logo/favicon.ico" type="image/x-icon">

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <!-- Custom CSS -->
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <!-- Graph CSS -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- jQuery -->
    <!-- lined-icons -->
    <link rel="stylesheet" href="css/icon-font.css" type='text/css' />
    <!-- //lined-icons -->
    <!-- Meters graphs -->
    <script src="js/jquery-2.1.4.js"></script>

    <link href="css/plyr.css" rel="stylesheet">


</head>
<!-- /w3layouts-agile -->

<body class="sticky-header left-side-collapsed" onload="initMap()">
    <section>
        <!-- /w3l-agile -->
        <!-- main content start-->
        <div class="main-content">
            <!-- header-starts -->
            <div class="header-section">

                <!--notification menu start -->
                <div class="menu-right">
                    <div class="profile_details">

                        <!---->
                        <div class="col-md-4 player">
                            <div class="audio-player" style="display: flex;">
                                <div class="image" style="padding-right: 5px;">
                                    <img alt="" height="60" src="images/a1.jpg" srcset="" width="60">

                                </div>
                                <div class="playinfo">
                                    <h4 style="margin-bottom: -10px; margin-top: -5px;">Chris Brown</h4>
                                    <span style="font-size: 0.7em; opacity: 0.7;">Indigo</span>
                                </div>
                                <audio controls="controls" id="player">
                                    <source src="media/Blue Browne.ogg" type="audio/ogg">
                                    <source src="media/Blue Browne.mp3" type="audio/mpeg">
                                    <source src="media/Georgia.ogg" type="audio/ogg">
                                    <source src="media/Georgia.mp3" type="audio/mpeg">
                                </audio>
                            </div>

                            <!--audio-->
                            <link rel="stylesheet" type="text/css" media="all" href="css/audio.css">
                            <script type="text/javascript" src="js/mediaelement-and-player.min.js"></script>
                            <!---->



                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <!-------->
                </div>
                <div class="clearfix"></div>
            </div>
            <!--notification menu end -->
            <!-- //header-ends -->
            <!-- /w3l-agileits -->
            <!-- //header-ends -->
            <div id="page-wrapper">
                <div class="inner-content">

                    <div class="music-left">
                        <!--banner-section-->
                        <div class="banner-section">
                            <div class="banner" style="display: flex; flex-direction: row; justify-content: space-between;">
                                <div class="callbacks_container" style="margin-right: 20px">
                                    <ul class="rslides callbacks callbacks1" id="slider4">
                                        <li>
                                            <div class="banner-img">
                                                <img src="images/11.jpg" class="img-responsive" alt="">
                                            </div>
                                            <div class="banner-info">
                                                <a class="trend" href="single.html">TRENDING</a>
                                                <h3>Let Your Home</h3>
                                                <p>Album by <span>Rock star</span></p>
                                            </div>

                                        </li>
                                        <li>
                                            <div class="banner-img">
                                                <img src="images/22.jpg" class="img-responsive" alt="">
                                            </div>
                                            <div class="banner-info">
                                                <a class="trend" href="single.html">TRENDING</a>
                                                <h3>Charis Brown feet</h3>
                                                <p>Album by <span>Rock star</span></p>
                                            </div>


                                        </li>
                                        <li>
                                            <div class="banner-img">
                                                <img src="images/33.jpg" class="img-responsive" alt="">
                                            </div>
                                            <div class="banner-info">
                                                <a class="trend" href="single.html">TRENDING</a>
                                                <h3>Let Your Home</h3>
                                                <p>Album by <span>Rock star</span></p>
                                            </div>

                                            <!-- /w3layouts-agileits -->
                                        </li>
                                    </ul>
                                </div>
                                <div class="callbacks_container">
                                    <ul class="rslides callbacks callbacks1" id="slider5">
                                        <li>
                                            <div class="banner-img">
                                                <img alt="" class="img-responsive" src="images/11.jpg">
                                            </div>
                                            <div class="banner-info">
                                                <a class="trend" href="single.html">TRENDING</a>
                                                <h3>Let Your Home</h3>
                                                <p>Album by <span>Rock star</span></p>
                                            </div>

                                        </li>
                                        <li>
                                            <div class="banner-img">
                                                <img alt="" class="img-responsive" src="images/22.jpg">
                                            </div>
                                            <div class="banner-info">
                                                <a class="trend" href="single.html">TRENDING</a>
                                                <h3>Charis Brown feet</h3>
                                                <p>Album by <span>Rock star</span></p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="banner-img">
                                                <img alt="" class="img-responsive" src="images/33.jpg">
                                            </div>
                                            <div class="banner-info">
                                                <a class="trend" href="single.html">TRENDING</a>
                                                <h3>Let Your Home</h3>
                                                <p>Album by <span>Rock star</span></p>
                                            </div>

                                            <!-- /w3layouts-agileits -->
                                        </li>
                                    </ul>
                                </div>
                                <!--banner-->

                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <!--//End-banner-->

                        <!--//pop-up-box -->
                        <div class="albums">
                            <div class="tittle-head">
                                <h3 class="tittle">Genres and Moods</h3>
                                <a href="index.html">
                                    <h4 class="tittle">See all</h4>
                                </a>
                                <div class="clearfix"></div>
                            </div>

                            <div class="col-md-3 content-grid genre" style="background-image: linear-gradient(to right, #0acffe 0%, #495aff 100%);">
                                <a class="play-icon popup-with-zoom-anim" href="#small-dialog" style="display: flex; align-items: center; justify-content: center; ">
                                    <h3 style="color: white!important;">Rap</h3>
                                </a>

                            </div>
                            <div class="col-md-3 content-grid genre" style="background-image: linear-gradient(-225deg, #A445B2 0%, #D41872 52%, #FF0066 100%);">
                                <a class="play-icon popup-with-zoom-anim" href="#small-dialog">
                                    <h3 style="color: white!important;">Pop</h3>
                                </a>
                            </div>

                            <div class="col-md-3 content-grid genre" style="background-image: linear-gradient(to right, #FDC830 0%, #F37335 100%);">
                                <a class="play-icon popup-with-zoom-anim" href="#small-dialog">
                                    <h3 style="color: white!important;">R&B</h3>
                                </a>

                            </div>
                            <div class="col-md-3 content-grid genre" style="background-image: linear-gradient(to right, #a8c0ff 0%, #3f2b96 100%);">
                                <a class="play-icon popup-with-zoom-anim" href="#small-dialog">
                                    <h3 style="color: white!important;">Soul & Funk</h3>
                                </a>

                            </div>

                            <div class="clearfix"></div>
                        </div>

                        <!--//pop-up-box -->
                        <div class="albums">
                            <div class="tittle-head">
                                <h3 class="tittle">Artists</h3>
                                <a href="index.html">
                                    <h4 class="tittle">See all</h4>
                                </a>
                                <div class="clearfix"></div>
                            </div>

                            <?php
                            $sql = "SELECT * FROM artist LIMIT 5";
                            $artist_result = mysqli_query($conn, $sql);
                            while ($artist = mysqli_fetch_assoc($artist_result)) {
                                $name = $artist['name'];
                                $photo = $artist['artistphoto'];
                                ?>
                                <div class="col-md-3 content-grid" style="margin-right: 50px;background-image: url('http://dsconlimited.net/dsconlimitedmusic/<?php echo $photo; ?>'); width: 200px; height: 200px; background-size: cover; border: solid 0.0001px transparent; border-radius: 50%; background-position: 50% 50%">
                                    <a class="play-icon popup-with-zoom-anim" href="#small-dialog" style="display: flex; align-items: center; justify-content: center; ">
                                        <h3 style="color: white!important; position: absolute; top: 40%; left: 40%;"><svg fill="white" xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24">
                                                <path d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z" /></svg></h3>
                                    </a>
                                </div>
                            <?php } ?>
                            <div class="clearfix"></div>
                        </div>
                        <!--//End-albums-->

                        <!--                    &lt;!&ndash;//pop-up-box &ndash;&gt;-->
                        <!--                    <div class="albums">-->
                        <!--                        <div class="tittle-head">-->
                        <!--                            <h3 class="tittle">Top Charts </h3>-->

                        <!--                            <div class="clearfix"></div>-->
                        <!--                        </div>-->
                        <!--                        <div class="col-md-3 content-grid">-->
                        <!--                            <a class="play-icon popup-with-zoom-anim" href="#small-dialog">-->
                        <!--                                <img src="images/v1.jpg" alt="" title="allbum-name">-->
                        <!--                            </a>-->
                        <!--                        </div>-->


                        <!--                        </div>-->


                        <!--                        <div class="clearfix"></div>-->
                        <!--                    </div>-->
                        <!--                    &lt;!&ndash;//End-albums&ndash;&gt;-->

                        <!--//pop-up-box -->
                        <div class="albums">
                            <div class="tittle-head">
                                <h3 class="tittle">New Releases <span class="new">New</span></h3>

                                <div class="clearfix"></div>
                            </div>
                            <?php
                            $sql = "SELECT * FROM album ORDER BY id DESC LIMIT 5";
                            $album_result = mysqli_query($conn, $sql);
                            while ($album = mysqli_fetch_assoc($album_result)) {
                                $name = $album['name'];
                                $artist = $album['artist'];
                                $year = $album['year'];
                                ?>
                                <div class="col-md-3 content-grid" style="text-align: left;">
                                    <a class="play-icon popup-with-zoom-anim" href="#small-dialog">
                                        <img src="http://dsconlimited.net/dsconlimitedmusic/<?php echo $artist; ?>/<?php echo $name; ?>(<?php echo $year; ?>)/album.jpg" alt="" title="allbum-name"></a>
                                    <a class="" style="color: black;" href="#small-dialog"><?php echo $name; ?> </a>
                                    <br> by
                                    <a class="" style="color: black; font-size: 0.7em" href="#small-dialog"><?php echo $artist; ?> </a>

                                </div>
                            <?php } ?>


                            <div class="clearfix"></div>
                        </div>
                        <!--//End-albums-->


                        <!--//discover-view-->

                        <div class="albums second">
                            <div class="tittle-head">
                                <h3 class="tittle">Discover</h3>
                                <a href="index.html">
                                    <h4 class="tittle two">See all</h4>
                                </a>
                                <div class="clearfix"></div>
                            </div>

                            <?php
                            $sql = "SELECT * FROM album ORDER BY RAND() LIMIT 5";
                            $random_album = mysqli_query($conn, $sql);
                            while ($album = mysqli_fetch_assoc($random_album)) {
                                $name = $album['name'];
                                $artist = $album['artist'];
                                $year = $album['year'];
                                ?>
                                <div class="col-md-3 content-grid last-grid">
                                    <a href="single.html"><img src="http://dsconlimited.net/dsconlimitedmusic/<?php echo $artist; ?>/<?php echo $name; ?>(<?php echo $year; ?>)/album.jpg" title="allbum-name"></a>
                                    <div class="inner-info"><a href="single.html">
                                            <h5><?php echo $name; ?></h5>
                                        </a></div>
                                </div>
                            <?php } ?>
                            <div class="clearfix"></div>
                        </div>
                        <!--//discover-view-->
                    </div>
                    <!--//music-left-->

                    <div class="clearfix"></div>
                    <!-- /w3l-agile-its -->
                </div>
                <!--body wrapper start-->

                <div class="review-slider" style="padding-bottom: 100px">
                    <div class="tittle-head">
                        <h3 class="tittle">Featured Albums</h3>
                        <div class="clearfix"></div>
                    </div>
                    <ul id="flexiselDemo1">
                        <?php
                        $sql = "SELECT * FROM album ORDER BY RAND() LIMIT 5";
                        $random_album = mysqli_query($conn, $sql);
                        while ($album = mysqli_fetch_assoc($random_album)) {
                            $name = $album['name'];
                            $artist = $album['artist'];
                            $year = $album['year'];
                            ?>
                            <li>
                                <a href="single.html"><img src="http://dsconlimited.net/dsconlimitedmusic/<?php echo $artist; ?>/<?php echo $name; ?>(<?php echo $year; ?>)/album.jpg" alt="" /></a>
                                <div class="slide-title">
                                    <h4><?php echo $name; ?></h4>
                                </div>
                                <div class="date-city">
                                    <h5><?php echo $year; ?></h5>
                                    <div class="buy-tickets">
                                        <a href="single.html">READ MORE</a>
                                    </div>
                                </div>
                            </li>

                        <?php } ?>

                    </ul>
                    <script type="text/javascript">
                        $(window).load(function() {

                            $("#flexiselDemo1").flexisel({
                                visibleItems: 5,
                                animationSpeed: 1000,
                                autoPlay: true,
                                autoPlaySpeed: 3000,
                                pauseOnHover: false,
                                enableResponsiveBreakpoints: true,
                                responsiveBreakpoints: {
                                    portrait: {
                                        changePoint: 480,
                                        visibleItems: 2
                                    },
                                    landscape: {
                                        changePoint: 640,
                                        visibleItems: 3
                                    },
                                    tablet: {
                                        changePoint: 800,
                                        visibleItems: 4
                                    }
                                }
                            });
                        });
                    </script>
                    <script type="text/javascript" src="js/jquery.flexisel.js"></script>
                </div>
            </div>
            <div class="clearfix"></div>
            <!--body wrapper end-->
            <!-- /w3l-agile -->
        </div>
        <!--body wrapper end-->

        <!--footer section start-->
        <!--    TODO: add footer-->
        <!--footer section end-->
        <!-- /w3l-agile -->
        <!-- main content end-->
    </section>
    <script src="js/jquery.magnific-popup.js" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $('.popup-with-zoom-anim').magnificPopup({
                type: 'inline',
                fixedContentPos: false,
                fixedBgPos: true,
                overflowY: 'auto',
                closeBtnInside: true,
                preloader: false,
                midClick: true,
                removalDelay: 300,
                mainClass: 'my-mfp-zoom-in'
            });
        });
    </script>

    <script src="js/responsiveslides.min.js"></script>
    <script>
        // You can also use "$(window).load(function() {"
        $(function() {
            // Slideshow 4
            $("#slider4").responsiveSlides({
                auto: true,
                pager: true,
                nav: true,
                speed: 500,
                namespace: "callbacks",
                before: function() {
                    $('.events').append("<li>before event fired.</li>");
                },
                after: function() {
                    $('.events').append("<li>after event fired.</li>");
                }
            });

        });
    </script>
    <script>
        // You can also use "$(window).load(function() {"
        $(function() {
            // Slideshow 4
            $("#slider5").responsiveSlides({
                auto: true,
                pager: true,
                nav: true,
                speed: 500,
                namespace: "callbacks",
                before: function() {
                    $('.events').append("<li>before event fired.</li>");
                },
                after: function() {
                    $('.events').append("<li>after event fired.</li>");
                }
            });

        });
    </script>

    <script src="js/plyr.min.js"></script>
    <script>
        const controls = `
<div class="plyr__controls">
    <button type="button" class="plyr__control" data-plyr="restart">
        <svg role="presentation"><use xlink:href="#plyr-restart"></use></svg>
        <span class="plyr__tooltip" role="tooltip">Restart</span>
    </button>
    <button type="button" class="plyr__control" data-plyr="rewind">
        <svg role="presentation"><use xlink:href="#plyr-rewind"></use></svg>
        <span class="plyr__tooltip" role="tooltip">Rewind {seektime} secs</span>
    </button>
    <button type="button" class="plyr__control" aria-label="Play, {title}" data-plyr="play">
        <svg class="icon--pressed" role="presentation"><use xlink:href="#plyr-pause"></use></svg>
        <svg class="icon--not-pressed" role="presentation"><use xlink:href="#plyr-play"></use></svg>
        <span class="label--pressed plyr__tooltip" role="tooltip">Pause</span>
        <span class="label--not-pressed plyr__tooltip" role="tooltip">Play</span>
    </button>
    <button type="button" class="plyr__control" data-plyr="fast-forward">
        <svg role="presentation"><use xlink:href="#plyr-fast-forward"></use></svg>
        <span class="plyr__tooltip" role="tooltip">Forward {seektime} secs</span>
    </button>
    <div class="plyr__progress">
        <input data-plyr="seek" type="range" min="0" max="100" step="0.01" value="0" aria-label="Seek">
        <progress class="plyr__progress__buffer" min="0" max="100" value="0">% buffered</progress>
        <span role="tooltip" class="plyr__tooltip">00:00</span>
    </div>
    <div class="plyr__time plyr__time--current" aria-label="Current time">00:00</div>
    <div class="plyr__time plyr__time--duration" aria-label="Duration">00:00</div>
    <button type="button" class="plyr__control" aria-label="Mute" data-plyr="mute">
        <svg class="icon--pressed" role="presentation"><use xlink:href="#plyr-muted"></use></svg>
        <svg class="icon--not-pressed" role="presentation"><use xlink:href="#plyr-volume"></use></svg>
        <span class="label--pressed plyr__tooltip" role="tooltip">Unmute</span>
        <span class="label--not-pressed plyr__tooltip" role="tooltip">Mute</span>
    </button>
    <div class="plyr__volume">
        <input data-plyr="volume" style="width: 400px" type="range" min="0" max="1" step="0.05" value="1" autocomplete="off" aria-label="Volume">
    </div>
    <button type="button" class="plyr__control" data-plyr="captions">
        <svg class="icon--pressed" role="presentation"><use xlink:href="#plyr-captions-on"></use></svg>
        <svg class="icon--not-pressed" role="presentation"><use xlink:href="#plyr-captions-off"></use></svg>
        <span class="label--pressed plyr__tooltip" role="tooltip">Disable captions</span>
        <span class="label--not-pressed plyr__tooltip" role="tooltip">Enable captions</span>
    </button>
    <button type="button" class="plyr__control" data-plyr="fullscreen">
        <svg class="icon--pressed" role="presentation"><use xlink:href="#plyr-exit-fullscreen"></use></svg>
        <svg class="icon--not-pressed" role="presentation"><use xlink:href="#plyr-enter-fullscreen"></use></svg>
        <span class="label--pressed plyr__tooltip" role="tooltip">Exit fullscreen</span>
        <span class="label--not-pressed plyr__tooltip" role="tooltip">Enter fullscreen</span>
    </button>
</div>
`;

        // Setup the player
        const player = new Plyr('#player', {
            controls
        });
    </script>

    <script src="js/jquery.nicescroll.js"></script>
    <script src="js/scripts.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.js"></script>
</body>

</html>