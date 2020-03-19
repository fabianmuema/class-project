<?php

session_start();

date_default_timezone_set('Africa/Nairobi');
$date = date('Y-m-d H:i:s', time());

require 'routeros_api.class.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password1 = $_POST['password'];
    $password = md5($password1);

    // configure database
    require "includes/db_conf.php";
    if ($conn) {
        $API = new RouterosAPI();

        $name = $username;

        $ip = $_SERVER["REMOTE_ADDR"];
        mysqli_query($conn, "INSERT INTO `ip` (`address` ,`timestamp`) VALUES ('$ip',CURRENT_TIMESTAMP)");
        $result = mysqli_query($conn, "SELECT COUNT(*) FROM `ip` WHERE `address` LIKE '$ip' AND `timestamp` > (now() - interval 2 minute)");
        $count = mysqli_fetch_array($result, MYSQLI_NUM);

        if($count[0] > 3){
          $_SESSION['error'] = "Your are allowed 3 attempts in 2 minutes";
          header("location: index.php");
        } else {
            $API->connect('192.166.29.1', 'admin', '12345678A');
            $API->write('/ip/hotspot/user/getall', false);
            $API->write('=.proplist=password', false);
            $API->write('?name=' . $name);
            $READ = $API->read(false);
            $ARRAY = $API->parseResponse($READ);
            $API->disconnect();

            if (count($ARRAY) > 0) {
                if (($ARRAY[0]['password']) == $password) {
                    $sql = "SELECT * FROM users WHERE username = '" . $name . "' AND password = '" . $password . "'";
                    if ($results = mysqli_query($conn, $sql)) {
                        $count = mysqli_num_rows($results);
                        if ($count == 1) {
                            $user = mysqli_fetch_assoc($results);
                            $active = $user['active'];
                            if ($active == 1) {
                                $API->connect('192.166.29.1', 'admin', '12345678A');
                                $ARRAY = $API->comm('/ip/hotspot/active/login', array(
                                    "user" => $username,
                                    "password" => $password,
                                    "ip" => $ip
                                ));
                                $API->disconnect();

                                $_SESSION['username'] = $username;
                                $_SESSION['loggedin'] = true;
                                $_SESSION['admin'] = $user['admin'];

                                $sql = "UPDATE users SET last_activity = '" . $date . "' WHERE username = '" . $username . "'";
                                mysqli_query($conn, $sql);
                                if(isset($_POST['remember'])){
                                    $length = 30;
                                    $token = bin2hex(random_bytes($length));
                                    setcookie('remember_me', $token, time()+(3600 * 24 * 3), "/");
                                    $sql = "UPDATE users SET cookie = '" . $token . "' WHERE username = '" . $username . "'";
                                    mysqli_query($conn, $sql);
                                }
                                header("Location: dashboard/");

                            } else {
                                $_SESSION['username'] = $username;
                                $_SESSION['loggedin'] = true;
                                $_SESSION['admin'] = $user['admin'];
                                $sql = "UPDATE users SET last_activity = '" . $date . "' WHERE username = '" . $username . "'";
                                mysqli_query($conn, $sql);
                                if (isset($_POST['remember'])) {
                                    $length = 30;
                                    $token = bin2hex(random_bytes($length));
                                    setcookie('remember_me', $token, time() + (3600 * 24 * 3), "/");
                                    $sql = "UPDATE users SET cookie = '" . $token . "' WHERE username = '" . $username . "'";
                                    mysqli_query($conn, $sql);
                                }
                                
                                header('Location: dashboard/');

                            }
                        } else {
                            $error = "An error occurred. Please try again!";
                            $_SESSION['error'] = $error;
                            header('Location: index.php');
                        }
                    } else {
                        $error = "An error occured";
                        $_SESSION['error'] = $error;
                        header('Location: index.php');

                    }
                } else {
                    $error = "No account is associated with this username and password";
                    $_SESSION['error'] = $error;
                    header('Location: index.php');

                }
            } else {
                $error = 'Invalid username or password';
                $_SESSION['error'] = $error;
                header('Location: index.php');
            }
        }
    }
}

$conn->close();
?>
