<?php
include_once('../includes/login_status.php');

include_once('../includes/db_conf.php');

$back = $_SERVER['HTTP_REFERER'];

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $id = $_GET['id'];

    $sql = "DELETE FROM notifications WHERE id='" . $id . "'";
    if (mysqli_query($conn, $sql)) {
        header("location: {$back}");
    }
}
