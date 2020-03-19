<?php

// database connection
$server = "db4free.net";
$dbuser = "dsconlimited";
$dbpass = "1LoveDscon!";
$db = "dsconlimited";

$con = mysqli_connect($server, $dbuser, $dbpass, $db);

$sql = "SELECT SUM(amount) AS total FROM xialosu WHERE YEAR(TransTime) = YEAR(CURRENT_DATE())";
$result = mysqli_query($con, $sql);
$money = mysqli_fetch_assoc($result);
$sum = $money['total'];

$server = "localhost";
$dbuser = "root";
$dbpass = "12345";
$db = "stats";

$conn = mysqli_connect($server, $dbuser, $dbpass, $db);

$sql = "SELECT * FROM yearly_income WHERE YEAR(date) = YEAR(CURDATE())";
$result = mysqli_query($conn, $sql);
$rows = mysqli_num_rows($result);

if($rows == 0) {
    $sql = "INSERT INTO yearly_income (amount) VALUES ('$sum')";
    mysqli_query($conn, $sql);
} else {
    $sql = "UPDATE yearly_income SET amount = {$sum} WHERE YEAR(date) = YEAR(CURDATE())";
    mysqli_query($conn, $sql);
}

$conn->close();
?>