<?php

require '../includes/login_status.php';

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $eplink = $_GET['eplink'];
    $thumbnail = $_GET['thumbnail'];
    $show = $_GET['show'];
    $episode = $_GET['episode'];
    $season = $_GET['season'];
    $username = $_SESSION['username'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dscon | <?php echo $show ?> Season <?php echo $season; ?> Episode <?php echo $episode; ?></title>

    <link rel="shortcut icon" href="images/logo/favicon.ico" type="image/x-icon">

    <!-- CSS files -->
    <link rel="stylesheet" href="css/style.css">

    <script src="js/jquery-3.1.0.min.js"></script>

    <link href="../node_modules/video.js/dist/video-js.min.css" rel="stylesheet">
    <script src="../node_modules/video.js/dist/video.min.js"></script>
    <script src="../node_modules/videojs-contrib-hls/dist/videojs-contrib-hls.min.js"></script>
    <link rel="stylesheet" href="css/moo.css">
    <script src="../node_modules/videojs-upnext-card/dist/upnext.js"></script>
    <link rel="stylesheet" href="../node_modules/videojs-upnext-card/dist/upnext.css">

    <script src="../node_modules/videojs-titleoverlay/videojs-titleoverlay.js"></script>
    <script src="../node_modules/videojs-seek-buttons/dist/videojs-seek-buttons.min.js"></script>
    <link rel="stylesheet" href="../node_modules/videojs-seek-buttons/dist/videojs-seek-buttons.css">

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
    <style>
        .vjs-volume-control.vjs-control.vjs-volume-horizontal {
            top: 40% !important;
        }
    </style>

    <video style="width: 99vw; height: 100vh" id="my_video_1" class="video-js vjs-default-skin" controls preload="auto" autoplay data-setup='{}'>
    </video>

    <script>
        const player = videojs('my_video_1');
        player.src({
            src: 'http://dsconlimited.net/dsconlimitedseries/<?php echo $eplink; ?>',
            type: 'application/x-mpegURL'
        });
        player.ready(function() {
            var promise = player.play();

            if (promise !== undefined) {
                promise.then(function() {

                }).catch(function(error) {

                });
            }
        });
    </script>

    <script>
        var options = {
            title: "<?php echo $show . " Season " . $season . " Episode " . $episode; ?>", //Title for movie
            floatPosition: 'left', //Float left or right (to prevent big play button overlap) (default left)
            margin: '50px', //Margin from top/left/right (default 10px)
            fontSize: '1.5em', //font size (default 1em)
            debug: false, //true or false. Will output debug messages for title status
        };
        player.titleoverlay(options);
        player.titleoverlay.showOverlay();
    </script>

    <script>
        $(function() {
            var $refreshButton = $('#refresh');
            var $results = $('#css_result');

            function refresh() {
                var css = $('style.cp-pen-styles').text();
                $results.html(css);
            }

            refresh();
            $refreshButton.click(refresh);

            // Select all the contents when clicked
            $results.click(function() {
                $(this).select();
            });
        });
    </script>
    <script>
        function performActionAfterTimeout() {
            function getData() {
                return $.ajax({
                    type: "GET",
                    url: "getnext.php?username=<?php echo $username; ?>&show=<?php echo $show; ?>&season=<?php echo $season; ?>&episode=<?php echo $episode; ?>",
                    async: false,
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        alert("Request: " + JSON.stringify(XMLHttpRequest) + "\n\nStatus: " + textStatus + "\n\nError: " + errorThrown);
                    },
                    success: function(result) {
                        next = JSON.parse(result);
                    }
                }).responseText;
            }

            var next = getData();

            next = JSON.parse(next)
            var show = next[0]
            var season = next[1]
            var episode = next[2]
            var link = next[3]
            window.location.replace("http://dsconlimited.net/movie/players.php?series=" + show + "&season=" + season + "&episode=" + episode + "")
        }

        player.upnext({
            timeout: 5000,
            headText: 'Up Next',
            cancelText: 'Cancel',
            getTitle: function() {
                function getData() {
                    return $.ajax({
                        type: "GET",
                        url: "getnext.php?username=<?php echo $username; ?>&show=<?php echo $show; ?>&season=<?php echo $season; ?>&episode=<?php echo $episode; ?>",
                        async: false,
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            alert("Request: " + JSON.stringify(XMLHttpRequest) + "\n\nStatus: " + textStatus + "\n\nError: " + errorThrown);
                        },
                        success: function(result) {
                            next = JSON.parse(result);
                        }
                    }).responseText;
                }

                var next = getData();
                
                next = JSON.parse(next)
                var show = next[0]
                var season = next[1]
                var episode = next[2]
                return show + " S" + season + "E" + episode
            },
            next: function() {
                performActionAfterTimeout()
            }
        });
    </script>

</body>

</html>