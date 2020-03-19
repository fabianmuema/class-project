<?php
ini_set('display_errors', 1);
include 'db_conf.php';

date_default_timezone_set('Africa/Nairobi');
$date = date('Y-m-d', time());

$sql = "SELECT * FROM payments WHERE DATE(time) = CURDATE()";
$result = mysqli_query($conn, $sql);
$plaza = $varsity = $ibis = $phemsi = $victon = $joymwa = 0;
while($payments = mysqli_fetch_assoc($result)) {
	$username = $payments['username'];
	$sql = "SELECT * FROM users WHERE username = '" . $username . "'";
	$userresult = mysqli_query($conn, $sql);
	$user = mysqli_fetch_assoc($userresult);
	$house = $user['apartment'];
	if ((strpos($house, 'plaza') !== false) || (strpos($house, 'Plaza') !== false) || (strpos($house, 'PLAZA') !== false)) {
		$plaza = $plaza + 1;
	} elseif ((strpos($house, 'varsity') !== false) || (strpos($house, 'Varsity') !== false) || (strpos($house, 'VARSITY') !== false)) {
		$varsity = $varsity + 1;
	} elseif ((strpos($house, 'ibis') !== false) || (strpos($house, 'Ibis') !== false) || (strpos($house, 'IBIS') !== false)) {
		$ibis = $ibis + 1;
	} elseif ((strpos($house, 'phemsi') !== false) || (strpos($house, 'Phemsi') !== false) || (strpos($house, 'PHEMSI') !== false)) {
		$phemsi = $phemsi + 1;
	} elseif ((strpos($house, 'victon') !== false) || (strpos($house, 'Victon') !== false) || (strpos($house, 'VICTON') !== false)) {
		$victon = $victon + 1;
	} elseif ((strpos($house, 'Joymwa') !== false) || (strpos($house, 'joymwa') !== false) || (strpos($house, 'JOYMWA') !== false)) {
		$joymwa = $joymwa + 1;
	}
}

$sql = "SELECT * FROM no_payments_house WHERE DATE(date) = CURDATE()";
$results = mysqli_query($conn, $sql);
$rows = mysqli_num_rows($results);
if ($rows == 0) {
	$sql = "INSERT INTO no_payments_house (house, payments) VALUES ('CK Plaza','$plaza')";
	mysqli_query($conn, $sql);
	$sql = "INSERT INTO no_payments_house (house, payments) VALUES ('Varsity','$varsity')";
	mysqli_query($conn, $sql);
	$sql = "INSERT INTO no_payments_house (house, payments) VALUES ('Ibis','$ibis')";
	mysqli_query($conn, $sql);
	$sql = "INSERT INTO no_payments_house (house, payments) VALUES ('Phemsi','$phemsi')";
	mysqli_query($conn, $sql);
	$sql = "INSERT INTO no_payments_house (house, payments) VALUES ('Victon','$victon')";
	mysqli_query($conn, $sql);
	$sql = "INSERT INTO no_payments_house (house, payments) VALUES ('Joymwa', '$joymwa')";
	mysqli_query($conn, $sql);
} else {
	$sql = "UPDATE no_payments_house SET payments = {$plaza} WHERE house = 'CK Plaza' AND Date(date) = CURDATE()";
	mysqli_query($conn, $sql);
	$sql = "UPDATE no_payments_house SET payments = {$varsity} WHERE house = 'Varsity' AND Date(date) = CURDATE()";
	mysqli_query($conn, $sql);
	$sql = "UPDATE no_payments_house SET payments = {$ibis} WHERE house = 'Ibis' AND Date(date) = CURDATE()";
	mysqli_query($conn, $sql);
	$sql = "UPDATE no_payments_house SET payments = {$phemsi} WHERE house = 'Phemsi' AND Date(date) = CURDATE()";
	mysqli_query($conn, $sql);
	$sql = "UPDATE no_payments_house SET payments = {$victon} WHERE house = 'Victon' AND Date(date) = CURDATE()";
	mysqli_query($conn, $sql);
	$sql = "UPDATE no_payments_house SET payments = {$joymwa} WHERE house = 'Joymwa' AND Date(date) = CURDATE()";
	mysqli_query($conn, $sql);

}
$conn->close();

 ?>
