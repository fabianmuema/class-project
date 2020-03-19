<?php

date_default_timezone_set("Africa/Nairobi");

include "db_conf.php";
include "routeros_api.class.php";

$sql = "SELECT * FROM subscriptions WHERE subscription = 'Entertainment' AND ends IS NOT null";
$result = mysqli_query($conn, $sql);
while($user = mysqli_fetch_assoc($result)) {
    $end = $user['ends'];
    $username = $user['username'];
    $today = date("Y-m-d H:i:s");

    if(strtotime($end) < strtotime($today)){
        $sql = "DELETE FROM subscriptions WHERE username = '$username' AND subscription ='Entertainment'";
        mysqli_query($conn, $sql);
        }
    }


header("refresh:5");
