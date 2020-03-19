<?php
session_start();

$username = $_SESSION['username'];

if (!(isset($_SESSION['loggedin']))) {
    header("Location: ../index.php");
}
