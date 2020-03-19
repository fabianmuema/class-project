<?php

$sql = "SELECT * FROM subscriptions WHERE username = '" . $username . "' AND subscription = 'Entertainment'";
$subscription_result = mysqli_query($conn, $sql);
$subscription_count = mysqli_num_rows($subscription_result);

if ($subscription_count == 0) {
    header("location: ../internet/single.php");
}
