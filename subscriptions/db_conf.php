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
