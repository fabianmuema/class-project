<?php

include_once '../includes/login_status.php';

include_once '../includes/db_conf.php';

$id = $username = "";

if(isset($_SESSION['admin'])){
    $admin = $_SESSION['admin'];

    if ($admin == true) {
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            if(isset($_GET['id'])){
                $id = $_GET['id'];
            }
            if(isset($_GET['username'])){
                $username = $_GET['username'];
            }

            $sql = "UPDATE issues SET solved=1 WHERE id='" . $id . "'";
            mysqli_query($conn, $sql);
            $notification = "Your issue has been solved.";
            $sql = "INSERT INTO notifications (username, notification) VALUES ('$username', '$notification')";
            mysqli_query($conn, $sql);
            header("location: issues.php");
        }
    } else {
        echo "Niaje bruv, You shouldnt be here!";
    }
}

