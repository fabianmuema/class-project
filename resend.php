<?php

session_start();

$username = $_SESSION['username'];

if($_SERVER['REQUEST_METHOD'] == "GET") {
    $phone = $_GET['phone'];

    include "routeros_api.class.php";
    include "includes/db_conf.php";

    $API = new RouterosAPI();

    if($API->connect('192.166.29.1','admin','12345678A')) {
        $verification_code = mt_rand(100000, 999999);
        
        $sql = "UPDATE users SET verification_code ='" . $verification_code . "' WHERE phone='" . $phone . "'";
        if(mysqli_query($conn, $sql)) {
            $ARRAY = $API->comm("/tool/sms/send", array(
                "port" => "usb1",
                "channel" => "1",
                "phone-number" => "{$phone}",
                "message" => "Verification code: {$verification_code}"
            ));
        }
    }
}

header("location: verification.php");