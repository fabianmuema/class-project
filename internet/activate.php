<?php
include_once('../includes/login_status.php');
include_once('../includes/db_conf.php');

require '../routeros_api.class.php';

$API = new RouterosAPI();

$username = $_SESSION['username'];

$package = $_GET['package'];

$plan = $_GET['plan'];

$freq = $_GET['freq'];

$sql = "SELECT * FROM users WHERE username='" . $username . "'";
$results = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($results);
$password = $user['password'];
$phone = 0 . $user['phone'];

$back = $_SERVER['HTTP_REFERER'];
    // activate the user
    $sql = "UPDATE users SET active=1 WHERE phone='" . $phone . "'";
    if (mysqli_query($conn, $sql)) {
        $localip = $_SERVER['REMOTE_ADDR'];
        if ($API->connect('192.166.29.1', 'admin', '12345678A')) {
            $ARRAY = $API->comm('/ip/hotspot/active/login', array(
                "user" => $username,
                "password" => $password,
                "ip" => $localip
            ));
            $subscription = "Internet";
            $sql = "INSERT INTO subscriptions (username, subscription) VALUES ('$username','$subscription')";
            if(mysqli_query($conn, $sql)){
                header("location: ../dashboard/");
            } else {
                echo "An error occured";
            }
        } else {
            echo "An error occured";
        }
    } else {
        echo " An error occured";
    }


mysqli_close($conn);
