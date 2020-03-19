<?php

$servername = "localhost";
$dbusername = "root";
$dbpassword = "12345";
$dbname = "network";

// Create connection
$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
// Check connection
$conn->set_charset("utf8");
if (!$conn) {
    die("Connection failed.");
}

$sql = "SELECT * FROM users WHERE DATE(last_activity) = CURDATE()";
$result = mysqli_query($conn, $sql);
$number = mysqli_num_rows($result);

$dbname = "stats";

$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

// check connection
$conn->set_charset('utf8');
if (!$conn) {
    die("Connection failed.");
}

$sql = "SELECT * FROM daily_total_active_users WHERE DATE(date) = CURDATE()";
$results = mysqli_query($conn, $sql);
$rows = mysqli_num_rows($results);
if($rows == 0) {
    $sql = "INSERT INTO daily_total_active_users (number) VALUES ('$number')";
    mysqli_query($conn, $sql);
} else {
    $sql = "UPDATE daily_total_active_users SET number = {$number} WHERE DATE(date) = CURDATE()";
    mysqli_query($conn, $sql);
}

$conn->close();


?>