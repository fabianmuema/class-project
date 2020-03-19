<?php

include_once('../includes/login_status.php');

include_once('../includes/db_conf.php');

$username = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- bootstrap -->
    <link rel="stylesheet" href="..\bootstrap\css\bootstrap.min.css">

    <!-- css -->

    <link rel="stylesheet" href="../css/custom.css">
    <link rel="stylesheet" href="css/payment.css">


    <link rel="shortcut icon" href="../img/logo/favicon.ico" type="image/x-icon">

    <!-- material icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


    <title>Dscon | Internet payment.</title>
</head>

<body>
    <?php

    $sql = "SELECT * FROM users WHERE username='" . $username . "'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    $phone = 0 . $user['phone'];

    $currentplan = $user['plan'];



    $server = "";
    $dbuser = "";
    $dbpass = "";
    $db = "";

    $con = mysqli_connect($server, $dbuser, $dbpass, $db);
    if (!$con) {
        header("location: ../nonet.php");
    }


    $sql = "SELECT * FROM users where username = '" . $username . "'";
    $results_remote = mysqli_query($con, $sql);
    $results_remote_array = mysqli_fetch_assoc($results_remote);
    $balance = $results_remote_array['balance'];

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $package = $_GET['package'];
        $_SESSION['package'] = $package;
        $plannum = $_GET['plan'];
        $_SESSION['plan'] = $plannum;
        $plan = $plannum . "mbps";
        $freq = $_GET['freq'];

        // specify rate limit for each chosen plan
        if ($plan == "1mbps") {
            $rate = "1M/1M";
        } elseif ($plan == "2mbps") {
            $rate = "2M/2M";
        } elseif ($plan == "3mbps") {
            $rate = "3M/3M";
        } elseif ($plan == "5mbps") {
            $rate = "5M/5M";
        }

        if ($freq == "monthly" && $plan == "1mbps") {
            $price = 730;
            $fraizer = 100;


        } elseif ($freq == "monthly" && $plan == "2mbps") {
            $price = 1000;
            $fraizer = 100;


        } elseif ($freq == "monthly" && $plan == "3mbps") {
            $price = 1500;
            $fraizer = 100;


        } elseif ($freq == "monthly" && $plan == "5mbps") {
            $price = 2500;
            $fraizer = 100;

        }

        if ($plannum == $currentplan) {
            ?>
            <div class="already-subscribed container pricing-area d-row d-flex justify-content-center">
                <div class="single-plan plan-popular mb-4 mb-sm-5 mb-lg-0" style="width:300px;">
                    <h3 class="plan-type">Subscription Error!</h3>
                    <p>You are already subscribed to this plan.</p>
                    <br>
                    <a class="btn btn-secondary" href="../internet/single.php">Back</a>
                </div>
            </div>
        <?php
        } elseif ($plannum < $currentplan) { ?>
            <div class="already-subscribed container pricing-area d-row d-flex justify-content-center">
                <div class="single-plan plan-popular mb-4 mb-sm-5 mb-lg-0" style="width:300px;">
                    <h3 class="plan-type">Subscription Error!</h3>
                    <p>Wait till the end of your subscription to downgrade your plan.</p>
                    <br>
                    <a class="btn btn-secondary" href="../internet/single.php">Back</a>
                </div>
            </div>
        <?php
        } else {
            if ($balance >= $price) {
                $balance = $balance - $price;
                $sql = "UPDATE users set balance = '" . $balance . "' WHERE username = '" . $username . "'";
                if(mysqli_query($con, $sql)){
                    $sql = "UPDATE users set used = '" . $price . "' WHERE username = '" . $username . "'";
                    mysqli_query($conn, $sql);
                    $sql = "INSERT INTO fraizer (username, amount, fraizer) VALUES ('$username', '$price', '$fraizer')";
                    mysqli_query($conn, $sql);
                    require '../routeros_api.class.php';
                    $API = new RouterosAPI();
                    $API->connect("192.166.29.1", "admin", "12345678A");
                    $API->write('/ip/hotspot/user/profile/getall', true);
                    $READ = $API->read(false);
                    $ARRAY = $API->parseResponse($READ);
                    foreach ($ARRAY as $value) {
                        // change the rate-limit of user profile
                        if ($value['name'] == $username) {
                            $API->write('/ip/hotspot/user/profile/set', false);
                            $API->write("=rate-limit=" . $rate, false);
                            $API->write("=.id=" . $value['.id']);
                            $API->read();
                            $sql = "INSERT INTO payments (username, total) VALUES ('$username','$price')";
                            mysqli_query($conn, $sql);

                            $notification = "You are now susbscribed to the {$plan} package.";
                            $sql = "INSERT INTO notifications (username, notification) VALUES ('$username','$notification')";
                            mysqli_query($conn, $sql);
                            $sql = "UPDATE users SET plan = '" . $plannum . "' WHERE username = '" . $username . "'";
                            mysqli_query($conn, $sql);
                            if ($user['active'] == 1) {
                                $localip = $_SERVER['REMOTE_ADDR'];
                                if ($API->connect('192.166.29.1', 'admin', '12345678A')) {
                                    if ($freq == "monthly") {
                                        $ARRAY = $API->comm('/system/script/add', array(
                                            "name" => "deactivate-{$username}",
                                        "source" => "/ip hotspot user profile set [find name=\"{$username}\"] rate-limit=0M/0M; /ip hotspot active remove [find user=\"{$username}\"]; /ip hotspot cookie remove [find user=\"{$username}\"]; /system scheduler remove [find name=\"deactivate-{$username}\"]; /system script remove [find name=\"deactivate-{$username}\"]",
                                        ));
                                        include 'date.php';
                                        $ARRAY = $API->comm('/system/scheduler/add', array(
                                            "name" => "deactivate-{$username}",
                                            "start-date" => $date,
                                            "start-time" => $time,
                                            "interval" => "30d",
                                            "on-event" => "deactivate-{$username}"
                                        ));
                                    }
                                    $ARRAY = $API->comm('/ip/hotspot/active/login', array(
                                        "user" => $username,
                                        "password" => $password,
                                        "ip" => $localip
                                    ));

                                        header("location: ../dashboard/");

                                } else {
                                    echo "An error occured";
                                }
                            } else {
                                ?>
                                <div class="already-subscribed container pricing-area d-row d-flex justify-content-center">
                                    <div class="single-plan plan-popular mb-4 mb-sm-5 mb-lg-0" style="width:300px;">
                                        <h3 class="plan-type">Subscription successful!</h3>
                                        <p>You have successfully subscribed <br>to the <?php echo $plan; ?> plan. </p>
                                        <p>At Kshs <?php echo $price; ?>/ <?php echo $freq; ?></p>
                                        <p>You will be able to access the internet in a few seconds. Do not reload this page!</p>
                                    </div>
                                </div>
                                <?php
                                if ($API->connect('192.166.29.1', 'admin', '12345678A')) {
                                    if ($freq == "monthly") {
                                        $ARRAY = $API->comm('/system/script/add', array(
                                            "name" => "deactivate-{$username}",
                                            "source" => "/ip hotspot user profile set [find name=\"{$username}\"] rate-limit=0M/0M; /ip hotspot active remove [find user=\"{$username}\"]; /ip hotspot cookie remove [find user=\"{$username}\"]; /system scheduler remove [find name=\"deactivate-{$username}\"]; /system script remove [find name=\"deactivate-{$username}\"]",
                                        ));
                                        include 'date.php';
                                        $ARRAY = $API->comm('/system/scheduler/add', array(
                                            "name" => "deactivate-{$username}",
                                            "start-date" => $date,
                                            "start-time" => $time,
                                            "interval" => "30d",
                                            "on-event" => "deactivate-{$username}"
                                        ));
                                    }
                                } else {
                                    echo "An error occured";
                                }
                                header("refresh:2;url=activate.php?package={$package}&plan={$plannum}&freq={$freq}");
                            }
                        }
                    }
                }

            } else {
                ?>
                <div class="already-subscribed container pricing-area d-row d-flex justify-content-center">
                    <div class="single-plan plan-popular mb-4 mb-sm-5 mb-lg-0" style="width:300px;">
                        <h3 class="plan-type">Subscription Error!</h3>
                        <p>Your balance is too low to subscribe to this plan! Please top up and try again.</p>
                        <br>
                        <a class="btn btn-secondary" href="../internet/single.php">Back</a>
                    </div>
                </div>
            <?php
            }
        }
    }
    ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <script src="js/upload.js"></script>

</body>

</html>

</html>

</html>
