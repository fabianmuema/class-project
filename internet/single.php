<?php

include_once('../includes/login_status.php');

include_once('../includes/db_conf.php');

$sql = "SELECT * FROM users WHERE username='" . $username . "'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
$package = $user['package'];
$apartment = $user['apartment'];

if (strpos($apartment, 'plaza') !== false) {
    header('location: plazasingle.php');
}

$phone = $user['phone'];

$phone = 0 . $phone;

$admin = $_SESSION['admin'];

$server = "";
$dbuser = "";
$dbpass = "";
$db = "";

$con = mysqli_connect($server, $dbuser, $dbpass, $db);
if (!$con) {
    header("location: ../nonet.php");
}



$sql = "SELECT * FROM users WHERE phone = '" . $phone . "'";
$balance_result = mysqli_query($con, $sql);
$balance_array = mysqli_fetch_assoc($balance_result);
$balance = $balance_array['balance'];

?>
<!DOCTYPE html>
<!--[if IE 8 ]><html class="no-js oldie ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="no-js oldie ie9" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js" lang="en-us">
<!--<![endif]-->

<head>

    <!--- basic page needs
   ================================================== -->
    <meta charset="utf-8">
    <title>DSCON | Single Packages</title>
    <meta name="description" content="Get connected to the cheapest, most reliable and fasted internet.">
    <meta name="author" content="DSCON">
    <meta name="copyright" content="DSCON" />
    <meta name="keywords" content="juja internet, internet service provider in thika, wifi juja, fast internet nairobi, internet in nairobi ">

    <!-- mobile specific metas
   ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS
   ================================================== -->
    <!-- bootstrap -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/custom.css">

    <link rel="shortcut icon" href="..\images\logo\favicon.ico" type="image/x-icon">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script defer src="../dashboard/js/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />


    <style>
        .single-plan {
            margin-left: 0 !important;
            width: 200px !important;
            border-radius: 10px;
        }
    </style>
</head>

<body style="background: white;">

    <!-- header
================================================== -->
    <header>
        <style>
            .topnav {
                overflow: hidden;
                background-color: #333;
            }

            .topnav a {
                float: left;
                display: block;
                color: #f2f2f2;
                text-align: right;
                padding: 20px 7px;
                text-decoration: none;
                font-size: 17px;
                transition: 0.5s all;
            }

            .topnav a:hover {
                background-color: #ddd;
                color: black;
            }

            .topnav a.active {
                background-color: #4CAF50;
                color: white;
            }

            .topnav .icon {
                display: none;
            }

            @media screen and (max-width: 600px) {
                .topnav a:not(:first-child) {
                    display: none;
                }

                .topnav a.icon {
                    float: right;
                    display: block;
                }

            }

            @media screen and (max-width: 600px) {
                .topnav.responsive {
                    position: relative;
                }

                .topnav.responsive .icon {
                    margin-top: 0;
                    position: absolute;
                    right: 0;
                    top: 0;
                }

                .topnav.responsive a {
                    float: none;
                    display: block;
                    text-align: left;
                }

                .notifications {
                    display: none !important;
                }
            }
        </style>

        <div class="topnav" id="myTopnav">
            <a href="#home" class="navbar-brand mr-auto" style="margin-left: -10px!important; margin-top: 1px!important; margin-right: 32%!important"></a>
            <?php if ($admin == false) { ?>
                <a class="nav-link" href="../dashboard/">Profile</a>
                <a href="../internet/" class="nav-link">Combined Packages</a>
                <a href="../internet/single.php" class="nav-link">Single Packages</a>

            <?php } else {
            ?>
                <a class="nav-link" href="../dashboard/">Dashboard</a></li>
            <?php } ?>

            <!-- <a href="../internet/packages.php" class="nav-link py-0" style="color: #f8f9fa!important;">Movie Packages</a> -->
            <a href="../movie/" class="nav-link">Entertainment</a>
            <?php if ($admin == true) {
            ?>
                <a class="nav-link py-0 text-light" href="dashboard/active.php" style="color: #f8f9fa!important;">Active</a>
                <a class="nav-link py-0 text-light" href="dashboard/allclients.php" style="color: #f8f9fa!important;">Clients</a>
                <a class="nav-link py-0 text-light" href="dashboard/profiles.php" style="color: #f8f9fa!important;">Profiles</a>
                <a class="nav-link py-0 text-light" href="dashboard/payments.php" style="color: #f8f9fa!important;">Payments</a>
                <a class="nav-link py-0 text-light" href="dashboard/mine.php" style="color: #f8f9fa!important;">Fabian's</a>
                <a class="nav-link py-0 text-light" href="dashboard/issues.php" style="color: #f8f9fa!important;">Issues</a>
            <?php } ?>
            <?php if ($admin == true or $username == 'fraizer') {
            ?>
                <a class="nav-link text-light" href="dashboard/fraizer.php" style="color: #f8f9fa!important;">Fraizer's</a>

            <?php
            }
            ?>
            <?php if ($admin == false) { ?>
                <a class="nav-link" href="../dashboard/report_issue.php">Report Issue</a>
                <a href="../dashboard/notifications.php" class="notifications">
                    notifications
                    <?php
                    $sql = "SELECT * FROM notifications WHERE username='" . $username . "'";
                    $results = mysqli_query($conn, $sql);
                    $count = mysqli_num_rows($results);
                    ?>
                    <span class="notification" style="background: red; border-radius: 50%; padding: 5px;"><?php echo $count; ?></span>
                </a>
            <?php } ?>
            <a href="../dashboard/logout.php">Logout</a>

            <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                <i class="fa fa-bars"><svg fill="white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z" /></svg></i>
            </a>
        </div>

        <script>
            function myFunction() {
                var x = document.getElementById("myTopnav");
                if (x.className === "topnav") {
                    x.className += " responsive";
                } else {
                    x.className = "topnav";
                }
            }
        </script>
    </header>
    <!-- <div class="wrapper"> -->
    <!-- Pricing-->
    <section class="single-section alt-bg pricing-area home">
        <div class="container">

            <div class="row">
                <div class="col-12">
                    <div class="section-head mt-4">
                        <h1 class="text-dark" style="font-weight: 600"></h1>
                        <h1>Entertainment Only Package</h1>
                        <hr>
                    </div>
                </div>
            </div>

            <div class="row d-row justify-content-center">
                <!-- Single plan-->
                <div class="">
                    <div class="single-plan mb-4 mb-sm-5 mb-lg-0">
                        <h4 class="plan-price">kshs 6 <br> for 6 hours</h4>

                        <ul class="list-unstyled plan-list text-dark">

                            <li style=" color: black;">Unlimited Movies</li>
                            <li style=" color: black;">Unlimited Series</li>
                            <li style=" color: black;">Request Movies and Series</li>
                            <br>
                            <?php if ($balance < 6) {
                            ?>
                                <a href="lowbalance.html" rel="modal:open">
                                    <button type="button" class="btn single-plan-button" style=" color: white;">
                                        Order Now
                                    </button>
                                </a>
                            <?php } else {
                            ?>
                        </ul>
                        <a class="btn single-plan-button" href="entertainmentpay.php?package=6" role="button">Order
                            Now</a>
                    <?php } ?>
                    </div>
                </div>
                <!-- Single plan-->
                <div class="">
                    <div class="single-plan mb-4 mb-sm-5 mb-lg-0">
                        <h4 class="plan-price">kshs 17 <br> for 12 hrs</h4>
                        <ul class="list-unstyled plan-list">
                            <li style=" color: black;">Unlimited Movies</li>
                            <li style=" color: black;">Unlimited Series</li>
                            <li style=" color: black;">Request Movies and Series</li>
                            <br>
                            <?php if ($balance < 17) {
                            ?>
                                <a href="lowbalance.html" rel="modal:open">
                                    <button type="button" class="btn single-plan-button" style=" color: white;">
                                        Order Now
                                    </button>
                                </a>
                            <?php } else {
                            ?>
                        </ul>
                        <a class="btn plan-popular-button" href="entertainmentpay.php?package=17" role="button">Order
                            Now</a>
                    <?php } ?>
                    </div>
                </div>
                <!-- Single plan-->
                <div class="">
                    <div class="single-plan  mb-4 mb-sm-5 mb-lg-0">
                        <h4 class="plan-price">kshs 22 <br> for 24 hrs</h4>
                        <ul class="list-unstyled plan-list">
                            <li style=" color: black;">Unlimited Movies</li>
                            <li style=" color: black;">Unlimited Series</li>
                            <li style=" color: black;">Request Movies and Series</li>
                            <br>
                            <?php if ($balance < 22) {
                            ?>
                                <a href="lowbalance.html" rel="modal:open">
                                    <button type="button" class="btn single-plan-button" style=" color: white;">
                                        Order Now
                                    </button>
                                </a>
                            <?php } else {
                            ?>
                        </ul>
                        <a class="btn single-plan-button" href="entertainmentpay.php?package=22" role="button">Order
                            Now</a>
                    <?php } ?>
                    </div>
                </div>
                <!-- Single plan-->
                <div class="">
                    <div class="single-plan mb-4 mb-sm-5 mb-lg-0">
                        <h4 class="plan-price">kshs 100 <br> for 1 week</h4>

                        <ul class="list-unstyled plan-list text-dark">

                            <li style=" color: black;">Unlimited Movies</li>
                            <li style=" color: black;">Unlimited Series</li>
                            <li style=" color: black;">Request Movies and Series</li>
                            <br>
                            <?php if ($balance < 100) {
                            ?>
                                <a href="lowbalance.html" rel="modal:open">
                                    <button type="button" class="btn single-plan-button" style=" color: white;">
                                        Order Now
                                    </button>
                                </a>
                            <?php } else {
                            ?>
                        </ul>
                        <a class="btn single-plan-button" href="entertainmentpay.php?package=100" role="button">Order
                            Now</a>
                    <?php } ?>
                    </div>
                </div>
                <div class="">
                    <div class="single-plan mb-4 mb-sm-5 mb-lg-0">
                        <h4 class="plan-price">kshs 250 <br> for 1 month</h4>

                        <ul class="list-unstyled plan-list text-dark">

                            <li style=" color: black;">Unlimited Movies</li>
                            <li style=" color: black;">Unlimited Series</li>
                            <li style=" color: black;">Request Movies and Series</li>
                            <br>
                            <?php if ($balance < 250) {
                            ?>
                                <a href="lowbalance.html" rel="modal:open">
                                    <button type="button" class="btn single-plan-button" style=" color: white;">
                                        Order Now
                                    </button>
                                </a>
                            <?php } else {
                            ?>
                        </ul>
                        <a class="btn single-plan-button" href="entertainmentpay.php?package=250" role="button">Order
                            Now</a>
                    <?php } ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="section-head mt-4">
                        <h1 class="text-dark" style="font-weight: 600"></h1>
                        <h1>Monthly Internet Only Package</h1>
                        <hr>
                    </div>
                </div>
            </div>

            <div class="row d-row justify-content-center">
                <!-- Single plan-->
                <div class="">
                    <div class="single-plan mb-4 mb-sm-5 mb-lg-0 green" style="  background-image:linear-gradient(to right, #11998e, #38ef7d);">
                        <h3 class="plan-type" style=" color: white;"> 200GB</h3>
                        <h4 class="plan-price" style=" color: white;">kshs 630 <br> per month</h4>

                        <ul class="list-unstyled plan-list text-dark">

                            <li style=" color: white;">1 mbps downloads</li>
                            <li style=" color: white;">1 mbps uploads</li>
                            <li style=" color: white;">Fast mobile payment</li>
                            <br>
                            <?php if ($balance < 630) {
                            ?>
                                <a href="lowbalance.html" rel="modal:open">
                                    <button type="button" class="btn single-plan-button" style=" color: white;">
                                        Order Now
                                    </button>
                                </a>
                            <?php } else {
                            ?>
                        </ul>
                        <a class="btn single-plan-button" href="singlepayment.php?package=home&plan=1&freq=monthly&offer=yes" role="button">Order
                            Now</a>
                    <?php } ?>
                    </div>
                </div>
                <!-- Single plan-->
                <div class="">
                    <div class="single-plan plan-popular mb-4 mb-sm-5 mb-lg-0" style="  background-image:linear-gradient(to right, #2193b0, #6dd5ed);">
                        <h3 class="plan-type">300GB</h3>
                        <h4 class="plan-price">kshs 900 <br> per month</h4>
                        <ul class="list-unstyled plan-list">
                            <li>2 mbps downloads</li>
                            <li>2 mbps uploads</li>
                            <li>fast mobile payment</li>
                            <br>
                            <?php if ($balance < 900) {
                            ?>
                                <a href="lowbalance.html" rel="modal:open">
                                    <button type="button" class="btn single-plan-button" style=" color: white;">
                                        Order Now
                                    </button>
                                </a>
                            <?php } else {
                            ?>
                        </ul>
                        <a class="btn plan-popular-button" href="singlepayment.php?package=home&plan=2&freq=monthly&offer=yes" role="button">Order
                            Now</a>
                    <?php } ?>
                    </div>
                </div>
                <!-- Single plan-->
                <div class="">
                    <div class="single-plan  mb-4 mb-sm-5 mb-lg-0" style="  background-image: linear-gradient(to right, #4e54c8, #8f94fb);">
                        <h3 class="plan-type" style=" color: white;">400GB</h3>
                        <h4 class="plan-price" style=" color: white;">kshs 1,300 <br> per month</h4>
                        <ul class="list-unstyled plan-list">
                            <li style=" color: white;">3 mbps downloads</li>
                            <li style=" color: white;">3 mbps uploads</li>
                            <li style=" color: white;">Fast mobile payment</li>
                            <br>
                            <?php if ($balance < 1300) {
                            ?>
                                <a href="lowbalance.html" rel="modal:open">
                                    <button type="button" class="btn single-plan-button" style=" color: white;">
                                        Order Now
                                    </button>
                                </a>
                            <?php } else {
                            ?>
                        </ul>
                        <a class="btn single-plan-button" href="singlepayment.php?package=home&plan=3&freq=monthly&offer=yes" role="button">Order
                            Now</a>
                    <?php } ?>
                    </div>
                </div>
                <!-- Single plan-->
                <div class="">
                    <div class="single-plan mb-4 mb-sm-5 mb-lg-0 green" style="  background-image: linear-gradient(to right, #CAC531, #F3F9A7);">
                        <h3 class="plan-type" style=" color: white;"> 1000GB</h3>
                        <h4 class="plan-price" style=" color: white;">kshs 2500 <br> per Month</h4>

                        <ul class="list-unstyled plan-list text-dark">

                            <li style=" color: white;">5 mbps downloads</li>
                            <li style=" color: white;">5 mbps uploads</li>
                            <li style=" color: white;">mobile payment</li>
                            <br>
                            <?php if ($balance < 2500) {
                            ?>
                                <a href="lowbalance.html" rel="modal:open">
                                    <button type="button" class="btn single-plan-button" style=" color: white;">
                                        Order Now
                                    </button>
                                </a>
                            <?php } else {
                            ?>
                        </ul>
                        <a class="btn single-plan-button" href="singlepayment.php?package=home&plan=5&freq=monthly" role="button">Order
                            Now</a>
                    <?php } ?>
                    </div>
                </div>
            </div>


        </div>
    </section>
    <!-- end Pricing -->

    <!-- TODO: add modal -->

    <!-- Back to top button -->
    <script src="../js/jquery-3.1.1.js"></script>
    <a id="scrolltop"><svg xmlns="http://www.w3.org/2000/svg" fill="white" width="44" height="44" viewBox="0 0 24 24">
            <path fill="none" d="M0 0h24v24H0V0z" />
            <path d="M7.41 15.41L12 10.83l4.59 4.58L18 14l-6-6-6 6 1.41 1.41z" /></svg></a>
    <style>
        #scrolltop {
            display: inline-block;
            background-image: linear-gradient(to right, #f12711, #f5af19);
            width: 50px;
            height: 50px;
            text-align: center;
            border-radius: 4px;
            position: fixed;
            bottom: 20px;
            right: 30px;
            transition: background-color .3s,
                opacity .5s, visibility .5s;
            opacity: 0;
            visibility: hidden;
            z-index: 1000;
        }

        #scrolltop::after {
            content: "\f077";
            font-family: FontAwesome;
            font-weight: normal;
            font-style: normal;
            font-size: 2em;
            line-height: 50px;
            color: #fff;
        }

        #scrolltop:hover {
            cursor: pointer;
            background-color: #333;
        }

        #scrolltop:active {
            background-color: #555;
        }

        #scrolltop.show {
            opacity: 1;
            visibility: visible;
        }

        /* Styles for the content section */

        @media (min-width: 500px) {
            #scrolltop {
                margin: 30px;
            }
        }
    </style>

    <script>
        var btn = $('#scrolltop');

        $(window).scroll(function() {
            if ($(window).scrollTop() > 300) {
                btn.addClass('show');
            } else {
                btn.removeClass('show');
            }
        });

        btn.on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: 0
            }, '300');
        });
    </script>


</body>

</html>