<?php
ini_set('display_errors', 1);
include '../routeros_api.class.php';

$servername = "192.166.29.198";
$dbusername = "fabian";
$dbpassword = "12345";
$dbname = "network";

// Create connection
$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
// Check connection
$API = new RouterosAPI();

$message = "We are currently undergoing maintenance and may experience outage in some areas. We apologize for any inconvenience.";

$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
while ($user = mysqli_fetch_assoc($result)) {
    $API->connect('192.166.29.1', 'admin', '12345678A');
    $phone = 0 . $user['phone'];
    $ARRAY = $API->comm("/tool/sms/send", array(
        "port" => 'usb1',
        'channel' => 1,
        'phone-number' => $phone,
        'message' => "{$message}"
    ));
    $API->disconnect();
}