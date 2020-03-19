<?php
ini_set('display_errors', 1);

include '../includes/login_status.php';
include '../includes/db_conf.php';

$username = $_SESSION['username'];

$firstname = $secondname = $apartment = $gender = "";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = ucwords($data);
    return $data;
  }

  $firstname = test_input($_POST['firstname']);
  $secondname = test_input($_POST['secondname']);
  $apartment = test_input($_POST['apartment']);
  $gender = test_input($_POST['gender']);

  $sql = "UPDATE users SET firstname = '" . $firstname . "', secondname = '" . $secondname . "', apartment = '" . $apartment . "', gender = '" . $gender . "' where username = '" . $username . "'";
  if(mysqli_query($conn, $sql)) {
    header("location: ../dashboard/");
  }

} else {
  header('location: index.php');
}
 ?>
