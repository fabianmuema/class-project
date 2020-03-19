<?php

ini_set('display_errors', 1);

include 'db_conf.php';

$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
$users = mysqli_num_rows($result);

$dbname = "stats";
$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

if(!$conn) {
    die("Connection failed");
}

$sql = "SELECT * FROM new_users WHERE DATE(date) = CURDATE()";
$result = mysqli_query($conn, $sql);
$rows = mysqli_num_rows($result);

if($rows == 0) {
    $sql = "INSERT INTO new_users (users) VALUES ('$users')";
    mysqli_query($conn, $sql);
} else {
    $sql = "UPDATE new_users SET users = {$users}";
    mysqli_query($conn, $sql);
}

$conn->close();