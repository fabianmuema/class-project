<?php

include 'db_conf.php';

$sql = "SELECT * FROM movies";
$result = mysqli_query($conn, $sql);
while($movie = mysqli_fetch_assoc($result)) {
    include 'db_conf.php';

    $name = $movie['name'];
    $sql = "SELECT * FROM watchedmovies WHERE movie = '" . $name . "'";
    $resultx = mysqli_query($conn, $sql);
    $number = mysqli_num_rows($resultx);

    include 'stats_db.php';

    $sql = "INSERT INTO no_movies_watched (movie, number) VALUES ('$name','$number')";
    mysqli_query($conn, $sql);
}

?>