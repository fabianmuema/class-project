<?php

include_once('../includes/login_status.php');

$admin = $_SESSION['admin'];
if($admin != true) {
    header("location: index.php");
}

require "../routeros_api.class.php";

$API = new RouterosAPI();

if ($API->connect('192.166.29.1', 'admin', '12345678A')) {
    $API->write('/ip/hotspot/user/profile/print', true);
    $READ = $API->read(false);
    $ARRAY = $API->parseResponse($READ);

    $i = 1;
    foreach ($ARRAY as $value) {
        if ($value['name'] != 'default') {
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $value['name']; ?></td>
                <td><?php echo $value['address-pool']; ?></td>
                <td><?php echo $value['shared-users']; ?></td>
                <td><?php echo $value['rate-limit'] ?></td>
                <td><?php echo $value['queue-type']; ?></td>
            </tr>
            <?php
            $i = $i + 1;
        }
    }
}
