<?php

include_once('../includes/login_status.php');

require "../routeros_api.class.php";

require "../includes/db_conf.php";

$API = new RouterosAPI();

if ($API->connect('192.166.29.1', 'admin', '12345678A')) {
    $API->write('/ip/hotspot/active/print', true);
    $READ = $API->read(false);
    $ARRAY = $API->parseResponse($READ);

    $i = 1;
    foreach ($ARRAY as $value) {
        $name = $value['user'];
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
            <td><?php echo $value['user']; ?></td>
            <?php
            $sql = "SELECT * FROM users";
            $results = mysqli_query($conn, $sql);
            while ($users = mysqli_fetch_assoc($results)) {
                if ($users['username'] == $value['user']) { ?>
                    <td><?php echo $users['phone']; ?></td>
                <?php }
            } ?>
            <td><?php echo $value['mac-address']; ?></td>

            <?php
            $sql = "SELECT * FROM users";
            $results = mysqli_query($conn, $sql);
            while ($users = mysqli_fetch_assoc($results)) {
                if ($users['username'] == $value['user']) { ?>
                    <td><?php echo $users['plan']; ?>M/<?php echo $users['plan']; ?>M</td>
                <?php }
            } ?>
            <td><?php echo $totalusage; ?> <?php echo $size; ?></td>
            <td><?php echo $value['uptime']; ?></td>
            <td><a href="" style="color: red;" data-toggle="modal" data-target="#deactivate"><i class="material-icons">clear</i> Deactivate</td>
            <!-- Modal -->
            <div class="modal fade" id="deactivate" tabindex="-1" role="dialog" aria-labelledby="deactivate" aria-hidden="true" data-backdrop="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Deactivate user</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to deactivate <?php echo $name ?>?
                        </div>
                        <div class="modal-footer">
                            <a href="deactivate.php?name=<?php echo $name; ?>" type="button" class="btn btn-primary">Yes</a>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </tr>

        <?php
        $i = $i + 1;
    }
}
