<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    include_once '../includes/db_conf.php';
        $time = $_GET['duration'];
        $show = $_GET['show'];
        $season = $_GET['season'];
        $episode = $_GET['episode'];
        $username = $_GET['username'];
        $sql = "UPDATE watchedseries SET duration = '$time' WHERE username = '$username' AND series = '$show' AND season = '$season' AND episode = '$episode'";
        mysqli_query($conn, $sql);
}
?>
