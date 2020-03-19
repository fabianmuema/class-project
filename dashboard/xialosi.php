<?php

include_once('../includes/login_status.php');
include_once('../includes/db_conf.php');

$admin = $_SESSION['admin'];
if ($admin != true) {
    header("location: index.php");
}
$sql = "SELECT * FROM mine WHERE time >= '2020-03-01 00:00:00' ORDER BY time DESC";
$result = mysqli_query($conn, $sql);
$x = 1;
while ($user = mysqli_fetch_assoc($result)) {
    ?>
    <tr>
        <td><?php echo $x; ?></td>
        <td><?php echo $user['username']; ?></td>
        <td><?php echo $user['amount']; ?></td>
        <td><?php echo $user['mine']; ?></td>
        <td><?php echo $user['time']; ?></td>
    </tr>
    <?php
        $x = $x + 1;
} 

?>