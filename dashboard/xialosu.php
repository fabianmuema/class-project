<?php

include_once('../includes/login_status.php');
include_once('../includes/db_conf.php');

$admin = $_SESSION['admin'];
if($admin != true) {
    header("location: index.php");
}
    $sql = "SELECT * FROM payments ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);
    $x = 1;
    while ($user = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
        <td><?php echo $x; ?></td>
        <td><?php echo $user['username']; ?></td>
        <td><?php echo $user['total']; ?></td>
        <td><?php echo $user['time']; ?></td>
        </tr>
    <?php
        $x = $x + 1;
} 

?>