<?php
ini_set('display_errors',1);

include '../../includes/db_conf.php';

$sql = "SELECT hour(time) as Hour
from payments
where time between SUBDATE(CURDATE(),7) and CURDATE()
group by hour(time)";
$result = mysqli_query($conn, $sql);
$date = mysqli_fetch_assoc($result);
print_r($date);

 ?>
