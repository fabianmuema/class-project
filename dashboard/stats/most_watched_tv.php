<?php

include 'db_conf.php';

$sql = "SELECT seriesname FROM series";
$result = mysqli_query($conn, $sql);
while($show = mysqli_fetch_assoc($result)) {
    $name = $show['seriesname'];

    include 'db_conf.php';
    $sql = "SELECT id FROM watchedseries WHERE series = '" . $name . "'";
    $resultx = mysqli_query($conn, $sql);
    $number = mysqli_num_rows($resultx);

    include "stats_db.php";
    $sql = "INSERT INTO no_shows_watched (series, number) VALUES ('$name', '$number')";
    mysqli_query($conn, $sql);    
}