<?php

include_once('../includes/login_status.php');

include_once('../includes/db_conf.php');

$username = $_SESSION['username'];

require '../routeros_api.class.php';

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $name = $_GET['name'];
}

$API = new RouterosAPI();

if ($API->connect('192.166.29.1', 'admin', '12345678A')) {
    $API->write('/ip/hotspot/user/print', false);
    $API->write('=.proplist=.id', false);
    $API->write('?name=' . $name);
    $A = $API->read();
    $A = $A[0];
    $API->write('/ip/hotspot/user/set', false);
    $API->write('=.id=' . $A['.id'], false);
    $API->write('=disabled=yes');
    $READ = $API->read();
    $ARRAY = $API->parseResponse($READ);

    $API->write('/ip/hotspot/active/print', true);
    $A = $API->read(false);
    $ARRAY = $API->parseResponse($A);
    foreach ($ARRAY as $value) {
        if ($value['user'] == $name) {
            $API->write('/ip/hotspot/active/remove', false);
            $API->write('=.id=' . $value['.id']);
            $READ = $API->read();
            $A = $API->parseResponse($READ);
            $sql = "UPDATE users SET active=0 WHERE username='" . $name . "'";
            if (mysqli_query($conn, $sql)) {
                $notification = "Your account has been deactivated. Please contact your ISP for any queries.";
                $sql = "INSERT INTO notifications (username, notification) VALUES ('$username', '$notification')";
                if (mysqli_query($conn, $sql)) {
                    header("location: client-list.php");
                }
            }
        }
    }
}
