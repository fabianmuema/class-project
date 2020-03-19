<?php

ini_set('display_errors', 1);

date_default_timezone_set("Africa/Nairobi");

include_once('../includes/login_status.php');

include '../includes/db_conf.php';

$server = "";
$dbuser = "";
$dbpass = "";
$db = "";

$con = mysqli_connect($server, $dbuser, $dbpass, $db);
if(!$con) {
    header("location: ../nonet.php");
}

if($_SERVER['REQUEST_METHOD'] == "GET") {
    $package = $_GET['package'];

    if($package == 6) {
        $price = 6;
        $mine = 6 * 0.25;
        $time = date("Y-m-d H:i:s", strtotime("+6 hours"));
    } elseif ($package == 17) {
        $price = 17;
        $mine = 17 * 0.25;
        $time = date("Y-m-d H:i:s", strtotime("+12 hours"));
    } elseif ($package == 22) {
        $price = 22;
        $mine = 22 * 0.25;
        $time = date("Y-m-d H:i:s", strtotime("+1 day"));
    } elseif ($package == 100) {
        $price = 100;
        $mine = 100 * 0.25;
        $time = date("Y-m-d H:i:s", strtotime("+1 week"));
    } elseif($package == 250) {
        $price = 250;
        $mine = 250 * 0.25;
        $time = date("Y-m-d H:i:s", strtotime("+4 weeks"));
    }

    $sql = "SELECT phone FROM users WHERE username='" . $username . "'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    $phone = $user['phone'];
    $phone = 0 . $phone;

    $sql = "SELECT balance FROM users WHERE phone = '" . $phone . "'";
    $result = mysqli_query($con, $sql);
    $user = mysqli_fetch_assoc($result);
    $balance = $user['balance'];

    if ($price > $balance) {
        $notification = "Insufficient balance to subscribe to this package";
        $sql = "INSERT INTO notifications (username, notification) VALUES ('$username', '$notification')";
        if(mysqli_query($conn, $sql)) {
            header("location: http://dsconlimited.net/dashboard/notifications.php");
        } else {
            echo "Error";
        }
    } else {
        $sql = "SELECT * FROM subscriptions WHERE username = '" . $username . "' AND subscription = 'Entertainment'";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);
        if($count == 0) {
            $balance = $balance - $price;
            $sql = "UPDATE users SET balance = '" . $balance . "' WHERE phone = '" . $phone . "'";
            if (mysqli_query($con, $sql)) {
               $sql = "INSERT INTO subscriptions (username, subscription, ends) VALUES ('$username', 'Entertainment', '$time')";
               if(mysqli_query($conn, $sql)) {
                   $sql = "INSERT INTO mine (username, amount, mine) VALUES ('$username','$price', '$mine')";
                   mysqli_query($conn, $sql);
                   $notification = "Successfully subscribed to the entertainment package";
                   $sql = "INSERT INTO notifications (username, notification) VALUES ('$username', '$notification')";
                   if(mysqli_query($conn, $sql)) {
                       header("location: http://dsconlimited.net/dashboard/");
                   } else {
                       $notification = "An error occured. Please try again.";
                       $sql = "INSERT INTO notifications (username, notification) VALUES ('$username', '$notification')";
                       if(mysqli_query($conn, $sql)) {
                           header("location: http://dsconlimited.net/dashboard/notifications.php");
                       }
                   }
               }
           } 
        } else {
            $notification = "You are already subscribed to an Entertainment package";
            $sql = "INSERT INTO notifications (username, notification) VALUES ('$username', '$notification')";
             if(mysqli_query($conn, $sql)) {
                 header("location: http://dsconlimited.net/dashboard/notifications.php");
             } else {
                 $notification = "An error occured. Please try again.";
                 $sql = "INSERT INTO notifications (username, notification) VALUES ('$username', '$notification')";
                 if(mysqli_query($conn, $sql)) {
                     header("location: http://dsconlimited.net/dashboard/notifications.php");
                 }
             }
            
        }
    }
}

?>