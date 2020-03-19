<?php

require '../routeros_api.class.php';
include '../includes/db_conf.php';

$API = new RouterosAPI();

$day = date('l');

if ($API->connect("192.166.29.1", "admin", "12345678A")) {
    $API->write('/ip/hotspot/user/getall', true);
    $READ = $API->read(false);
    $ARRAY = $API->parseResponse($READ);

    // get users in database
    $sql = "SELECT * FROM internetusage";
    $results = mysqli_query($conn, $sql);

    foreach ($ARRAY as $value) {
        if (!($value['name'] == "default-trial")) {
            $username = $value['name'];
            $kb = ($value['bytes-in'] / 1000);
            $upload = $kb / 1000;

            $kb = $value['bytes-out'] / 1000;
            $download = $kb / 1000;

            $totalusage = round($upload + $download);
            if ($totalusage > 999) {
                $totalusage = $totalusage / 1000;
                $size = "GB";
            } else {
                $size = "MB";
            }

            $sql = "UPDATE internetusage SET {$day} = '" . $totalusage . "' WHERE username='" . $username . "'";
            mysqli_query($conn, $sql);
        }
    }
}
