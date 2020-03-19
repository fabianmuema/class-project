<?php

require "../includes/db_conf.php";

require "../routeros_api.class.php";

$API = new RouterOSAPI();

if ($API->connect('192.166.29.1', 'admin', '12345678A')) {
    $API->write('/ip/hotspot/user/print', true);
    $READ = $API->read(false);
    $ARRAY = $API->parseResponse($READ);

    $i = 1;
    foreach ($ARRAY as $value) {
        if ($value['name'] != 'admin' && $value['name'] != 'default-trial') {
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
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $value['name']; ?></td>
                <?php
                $sql = "SELECT * FROM users";
                $results = mysqli_query($conn, $sql);
                while ($users = mysqli_fetch_assoc($results)) {
                    if ($users['username'] == $value['name']) { ?>
                        <td><?php echo $users['phone']; ?></td>
                    <?php }
                } ?>

                <?php
                $sql = "SELECT * FROM users";
                $results = mysqli_query($conn, $sql);
                while ($users = mysqli_fetch_assoc($results)) {
                    if ($users['username'] == $value['name']) { ?>
                        <td><?php echo $users['plan']; ?>M/<?php echo $users['plan']; ?>M</td>
                    <?php }
                } ?>
                <td><?php echo $totalusage; ?> <?php echo $size; ?></td>
                <td><?php echo $value['uptime']; ?></td>
            </tr>
            <?php
            $i = $i + 1;
        }
    }
}
