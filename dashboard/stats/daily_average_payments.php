<?php

ini_set('display_errors', 1);

include '../includes/db_conf.php';

$dbname = "stats";

$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
$conn->set_charset('utf8');
if (!$conn) {
    die('Connection refused');
}

