<?php
session_start();

include '../includes/db_conf.php';

$username = $_SESSION['username'];

$sql = "SELECT * FROM users WHERE username='" . $username . "'";
$results = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($results);
$active = $user['active'];

if ($active == 1) {
    session_unset();
    session_destroy();

    $hour = time() - 3600;
    
    setcookie("xialosu", "", $hour);
    unset($_COOKIE['xialosu']);
    header("location: http://authenticate.net/logout");

} else {
    session_unset();
    session_destroy();

    $hour = time() - 3600;
    
    setcookie("xialosu", "", $hour);
    unset($_COOKIE['xialosu']);
    header("location: http://dsconlimited.net");
}
