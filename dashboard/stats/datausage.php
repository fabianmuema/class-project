<?php

include 'routerosapi.php';
include 'db_conf.php';

$API = new RouterosAPI();

$day  = date('l');

if($API->connect('192.166.29.1','admin','12345678A')){
    $API->write('/ip/hotspot/user/getall', true);
    $ARRAY = $API->read(false);
    $READ = $API->parseResponse($ARRAY);
    foreach ($READ as $array) {
        $name = $array['name'];
        $data = round(($array['packets-in'] / 1000 / 1000), 2);

        $dbname = "stats";
        $conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
        
        $sql = "SELECT * FROM internetusage WHERE username = '" . $name . "' AND DATE(date) = CURDATE()";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);
        if($count == 0) {
            $sql = "INSERT INTO internetusage (username, data) VALUES ('$name','$data')";
            mysqli_query($conn, $sql);
        } else {
            $sql = "UPDATE internetusage SET data = '{$data}' WHERE username = '" . $name . "'";
            mysqli_query($conn, $sql);
        }
    }
}