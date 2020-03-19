<?php
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    include '../includes/login_status.php';
    include '../includes/db_conf.php';

    $series = $_GET['series'];
    $season = $_GET['season'];
    $episode = $_GET['episode'];

    header("location: players.php?series={$series}&season={$season}&episode={$episode}#video");


//     $sql = "SELECT * FROM subscriptions WHERE username = '" . $username . "' AND subscription = 'Entertainment'";
//     $subscription_result = mysqli_query($conn, $sql);
//     $subscription_count = mysqli_num_rows($subscription_result);

// //    check if user has subscribed to entertainment
//     if ($subscription_count == 0) {
//         header("location: ../internet/packages.php");
//     } elseif ($subscription_count == 1) {
//         header("location: players.php?series={$series}&season={$season}&episode={$episode}");
//     } elseif ($subscription_count > 1) {
//         header("location: ../403.html");
//     } elseif ($subscription_count < 1) {
//         header("location: ../403.html");
//     } else {
//         header("location: ../403.html");
//     }

// }
}