<?php

include 'routeros_api.class.php';

$API = new RouterosAPI();

$servername = "localhost";
$dbusername = "root";
$dbpassword = "12345";
$dbname = "network";

// Create connection
$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$API->connect('192.166.29.1', 'admin', '12345678A');
$API->write('/ip/hotspot/user/profile/print', true);
$READ = $API->read(false);
$ARRAY = $API->parseResponse($READ);
$API->disconnect();
foreach ($ARRAY as $user) {
    $micUser = $user['name'];
    $plan = $user['rate-limit'];
    if ($plan == '0M/0M') {
        $sql = "UPDATE users SET plan = 0 WHERE username = '" . $micUser . "'";
        mysqli_query($conn, $sql);
        $sql = "UPDATE users SET active = 0 WHERE username = '" . $micUser . "'";
        mysqli_query($conn, $sql);
        $sql = "DELETE FROM subscriptions WHERE username = '" . $micUser . "' AND subscription = 'Internet'";
        mysqli_query($conn, $sql);
        $sql = "DELETE FROM subscriptions WHERE username = '" . $micUser . "' AND subscription = 'Entertainment' AND ends IS null";
        mysqli_query($conn, $sql);
        $active = 0;
    } elseif ($plan == '1M/1M') {
        $sql = "UPDATE users SET plan = 1 WHERE username = '" . $micUser . "'";
        mysqli_query($conn, $sql);
        $sql = "UPDATE users SET active = 1 WHERE username = '" . $micUser . "'";
        mysqli_query($conn, $sql);
        $active = 1;
    } elseif ($plan == "2M/2M") {
        $sql = "UPDATE users SET plan = 2 WHERE username = '" . $micUser . "'";
        mysqli_query($conn, $sql);
        $sql = "UPDATE users SET active = 1 WHERE username = '" . $micUser . "'";
        mysqli_query($conn, $sql);
        $active = 1;
    } elseif ($plan == "3M/3M") {
        $sql = "UPDATE users SET plan = 3 WHERE username = '" . $micUser . "'";
        mysqli_query($conn, $sql);
        $sql = "UPDATE users SET active = 1 WHERE username = '" . $micUser . "'";
        mysqli_query($conn, $sql);
        $active = 1;
    } elseif ($plan == "5M/5M") {
        $sql = "UPDATE users SET plan = 5 WHERE username = '" . $micUser . "'";
        mysqli_query($conn, $sql);
        $sql = "UPDATE users SET active = 1 WHERE username = '" . $micUser . "'";
        mysqli_query($conn, $sql);
        $active = 1;
    }

    if($active == 1) {
        $sql = "SELECT * FROM subscriptions WHERE username = '" . $micUser . "' AND subscription = 'Internet'";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
        if($count == 0) {
            $sql = "INSERT INTO subscriptions (username, subscription) VALUES ('$micUser', 'Internet')";
            mysqli_query($conn, $sql);
        }
        $sql = "SELECT * FROM subscriptions WHERE username = '" . $micUser . "' AND subscription = 'Entertainment'";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if ($num == 0) {
            $sql = "INSERT INTO subscriptions (username, subscription) VALUES ('$micUser', 'Entertainment')";
            mysqli_query($conn, $sql);
        }
    }
}


$conn->close();
?>