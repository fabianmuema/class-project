<?php

require '../routeros_api.class.php';

$username = $_SESSION['username'];

$API = new RouterosAPI();

if ($API->connect('192.166.29.1', 'admin', '12345678A')) {
    $API->write('/ip/hotspot/user/print', true);
    $READ = $API->read(false);
    $ARRAY = $API->parseResponse($READ);

    $API->write('/ip/hotspot/active/print', true);
    $READ = $API->read(false);
    $ARRAY2 = $API->parseResponse($READ);
    $i = 0;
    foreach ($ARRAY2 as $value) {
        $i = $i + 1;
    }

    $x = 0;
    foreach ($ARRAY as $value) {
        # code...
        if ($value['name'] == $username) {
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

            $uptime = $value['uptime'];
        }
        $x = $x + 1;
    }
}
