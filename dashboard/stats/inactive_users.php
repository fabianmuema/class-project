<?php

ini_set('display_errors', 1);

$servername = "192.166.29.198";
$username = "fabian";
$password = "12345";
$database = "network";

$conn = mysqli_connect($servername, $username, $password, $database);

if(!$conn) {
    die("Connection refused");
}

$effectiveDate = Date('Y-m-d');

include 'routerosapi.php';

$API = new RouterosAPI();

// calculate three months ago
$deleteDate = date('Y-m-d', strtotime("-3 months", strtotime($effectiveDate)));

$sql = "SELECT * FROM users WHERE last_activity < Date('$deleteDate')";
$result = mysqli_query($conn, $sql);
while($user = mysqli_fetch_assoc($result)) {
    $username = $user['username'];

    $sql = "DELETE FROM users WHERE username = '$username'";
    mysqli_query($conn, $sql);

    if ($API->connect('192.166.29.1', 'admin', '12345678A')) {
        $API->write('/ip/hotspot/user/print', false);
        $API->write('?name=' . $username, false);
        $API->write('=.proplist=.id');
        $ARRAYS = $API->read();

        $API->write('/ip/hotspot/user/remove', false);
        $API->write('=.id=' . $ARRAYS[0]['.id']);
        $READ = $API->read();

        $API->write('/ip/hotspot/user/profile/print', false);
        $API->write('?name=' . $username, false);
        $API->write('=.proplist=.id');
        $ARRAYS = $API->read();


        $API->write('/ip/hotspot/user/profile/remove', false);
        $API->write('=.id=' . $ARRAYS[0]['.id']);
        $READ = $API->read();
    }

    $API -> disconnect();

}
