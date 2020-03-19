<?php

ini_set('display_errors', 1);

if($_SERVER['REQUEST_METHOD'] == "GET") {
    $username = $_GET['username'];
    $show = $_GET['show'];
    $season = $_GET['season'];
    $episode = $_GET['episode'];

    include "../includes/db_conf.php";
    $episode = $episode + 1;
    $next = array();
    $sql = "SELECT * FROM episodes WHERE showname = '" . $show . "' AND season = '" . $season . "' AND epNum = '" . $episode . "'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if($num == 0) {
        $season = $season + 1;
        $episode = 1;
        $sql = "SELECT * FROM episodes WHERE showname = '" . $show . "' AND season = '" . $season . "' AND epNum = '" . $episode . "'";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if($num == 1) {
            $results = mysqli_fetch_assoc($result); 
            $episode = $results['epNum'];
            $show = $results['showname'];
            $season = $results['season'];
            $sql = "SELECT epLink FROM episodeslink WHERE showname = '" . $show . "' AND season = '" . $season . "' AND episodeNum = '" . $episode . "' LIMIT 1";
            $result = mysqli_query($conn, $sql);
            $episodelink = mysqli_fetch_assoc($result);
            $episodelink = $episodelink['epLink'];
            array_push($next, $show);
            array_push($next, $season);
            array_push($next, $episode);
            array_push($next, $episodelink);
        }
    } else {
        $results = mysqli_fetch_assoc($result);
        $episode = $results['epNum'];
        $show = $results['showname'];
        $season = $results['season'];
        $sql = "SELECT epLink FROM episodeslink WHERE showname = '" . $show . "' AND season = '" . $season . "' AND episodeNum = '" . $episode . "' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $episodelink = mysqli_fetch_assoc($result);
        $episodelink = $episodelink['epLink'];
        array_push($next, $show);
        array_push($next, $season);
        array_push($next, $episode);
        array_push($next, $episodelink);
        
    }

    $next = json_encode($next);
    echo $next;
}