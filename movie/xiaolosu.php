<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $movie = $_GET['movie'];

    include '../includes/db_conf.php';
    include '../includes/login_status.php';

    header("location: player.php?movie={$movie}");


    // $sql = "SELECT * FROM subscriptions WHERE username = '" . $username . "' AND subscription = 'Entertainment'";
    // $subscriptions_result = mysqli_query($conn, $sql);
    // $subscription_count = mysqli_num_rows($subscriptions_result);

    // if ($subscription_count == 0) {
    //     header("location: ../internet/packages.php");
    // } elseif ($subscription_count == 1) {
    //     header("location: player.php?movie={$movie}");
    // }
}



