<?php
include_once('../includes/login_status.php');

include_once('../includes/db_conf.php');

$admin = $_SESSION['admin'];

// get user details from database
$username = $_SESSION['username'];

$sql = "SELECT * FROM issues";
$resultz = mysqli_query($conn, $sql);
$issuecount = mysqli_num_rows($resultz);

$sql = "SELECT * FROM issues WHERE solved=1";
$unsolved = mysqli_query($conn, $sql);
$solvedcount = mysqli_num_rows($unsolved);

$sql = "SELECT * FROM issues WHERE solved=0";
$solved = mysqli_query($conn, $sql);
$unsolvedcount = mysqli_num_rows($solved);

$sql = "SELECT * FROM users WHERE username='" . $username . "'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
$balance = $user['balance'];
$plan = $user['plan'];

$sql = "SELECT * FROM subscriptions WHERE username='" . $username . "'";
$result = mysqli_query($conn, $sql);

if ($plan == 1) {
    $color = "green";
} elseif ($plan == 2) {
    $color = "blue";
} elseif ($plan == 3) {
    $color = "purple";
} else {
    $color = "red";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="img/logo/favicon.ico" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Dscon | Marketing Dashboard</title>

    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
    <meta name="viewport" content="width=device-width" />

    <!-- Bootstrap core CSS     -->
    <link href="css/bootstrap.min.css" rel="stylesheet" />

    <!--  DSCON CSS    -->
    <link rel="stylesheet" href="../css/main.css">

    <link href="css/material-dashboard.css" rel="stylesheet" />

    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="css/demo.css" rel="stylesheet" />


    <link rel="shortcut icon" href="..\images\logo\favicon.ico" type="image/x-icon">

    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet" />
</head>

<body>
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
            padding: 20px 16px;
            text-decoration: none;
            font-size: 14px;
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
                margin-top: -60px;
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
        <a href="#home" class="navbar-brand mr-auto" style="margin-left: 7px!important; margin-top: 1px!important; margin-right: 550px"></a>
        <?php if ($admin == false) { ?>
            <a class="nav-link text-light" href="../dashboard/" style="color: #f8f9fa!important;">Profile</a></li>
        <?php } else {
            ?>
            <a class="nav-link text-light" href="../dashboard/" style="color: #f8f9fa!important;">Dashboard</a></li>
        <?php } ?>
        <a href="../internet/" class="nav-link" style="color: #f8f9fa!important;">Internet</a>
        <a href="../internet/packages.php" class="nav-link py-0" style="color: #f8f9fa!important;">Movie Packages</a>
        <a href="../movie/" class="nav-link text-light py-0" style="color: #f8f9fa!important;">Movies</a>
        <?php if ($admin == true) {
            ?>
            <a class="nav-link py-0 text-light" href="client-list.php" style="color: #f8f9fa!important;">Client List</a>
            <a class="nav-link py-0 text-light" href="marketrsignup.php" style="color: #f8f9fa!important;">Add Marketer</a>
            <a class="nav-link py-0 text-light" href="issues.php" style="color: #f8f9fa!important;">Issues</a>
        <?php } ?>
        <?php if ($admin == false) { ?>
            <a class="nav-link py-0 text-light" href="../dashboard/report_issue.php" style="color: #f8f9fa!important;">Report Issue</a>
        <?php } ?>

        <a href="#" class="dropdown-toggle notifications" data-toggle="dropdown">
            <i class="material-icons" style="color: #f8f9fa!important;"><svg fill="white" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z" /></svg></i>
            <?php
            $sql = "SELECT * FROM notifications WHERE username='" . $username . "'";
            $results = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($results);
            ?>
            <span class="notification"><?php echo $count; ?></span>
            <p class="hidden-lg hidden-sm notifications hidden-md">Notifications</p>
        </a>
        <ul class="dropdown-menu" style="margin-left: -50px;">
            <?php while ($notification = mysqli_fetch_assoc($results)) { ?>
                <li><a href="dismiss.php?id=<?php echo $notification['id']; ?>"><?php echo $notification['notification']; ?></a>
                <?php } ?>
        </ul>
        <a href="logout.php">Logout</a>

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


    <?php

    $sql = "SELECT * FROM marketer WHERE username ='" . $username . "'";
    $marketerResult = mysqli_query($conn, $sql);
    $marketer = mysqli_fetch_assoc($marketerResult);

    ?>

    <div class="main-panel" data-color="<?php echo $color; ?>" style="overflow: hidden;">
        <div class="content">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header" data-background-color="<?php echo $color; ?>">
                                        <i class="material-icons">
                                            <svg fill="white" xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24">
                                                <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
                                                <path d="M0 0h24v24H0z" fill="none" />
                                            </svg>
                                        </i>
                                    </div>
                                    <div class="card-content">
                                        <p class="category">Balance</p>
                                        <h3 class="title">Kshs <?php echo number_format($marketer['amount_made']); ?></h3>
                                    </div>
                                    <?php if ($marketer['amount_made'] < 50) {
                                        ?>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">
                                                    <svg fill="#DCDCDC" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24">
                                                        <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
                                                        <path d="M0 0h24v24H0z" fill="none" />
                                                    </svg>
                                                </i>Register users to earn
                                            </div>
                                        </div>
                                    <?php
                                    } else {
                                        ?>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <i class="material-icons">
                                                    <svg fill="#DCDCDC" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24">
                                                        <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
                                                        <path d="M0 0h24v24H0z" fill="none" />
                                                    </svg>
                                                </i>Amount made from your marketing campaign.
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php

                            $sql = "SELECT * FROM users WHERE referer='" . $username . "'";
                            $refererResult = mysqli_query($conn, $sql);
                            $referCount = mysqli_num_rows($refererResult);

                            ?>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header" data-background-color="<?php echo $color; ?>">
                                        <i class="material-icons">
                                            <svg fill="white" xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24">
                                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                                <path d="M0 0h24v24H0z" fill="none" />
                                            </svg>
                                        </i>
                                    </div>
                                    <div class="card-content">
                                        <p class="category">Users</p>
                                        <h3 class="title"><?php echo $referCount; ?></h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <i class="material-icons">
                                                <svg fill="#DCDCDC" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24">
                                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                                    <path d="M0 0h24v24H0z" fill="none" />
                                                </svg>
                                            </i>Users refered by you.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--                TODO: ajax forms-->
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="card">
                                    <div class="card-header card-chart" data-background-color="<?php echo $color; ?>">
                                        <div class="ct-chart" id="dailySalesChart"></div>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="title">Weekly Marketing Campaign Stats</h4>
                                        <p class="category">
                                            <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55%
                                            </span>
                                            Increase in refered users
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header" data-background-color="<?php echo $color; ?>">
                                    <h3 style="color: white">Refered Clients</h3>
                                </div>
                                <div class="card-content">
                                    <table class="table">
                                        <thead>
                                            <th style="padding-right: 40px;">
                                                ID
                                            </th>
                                            <th style="padding-right: 200px;">Name</th>
                                            <th style="padding-right: 40px;">Used Amount</th>
                                        </thead>
                                        <tbody class="table">
                                            <?php
                                            $i = 1;
                                            while ($user = mysqli_fetch_assoc($refererResult)) {
                                                ?>
                                                <tr>
                                                    <td style="padding-right: 40px"><?php echo $i; ?></td>
                                                    <td style="padding-right: 200px"><?php echo $user['username']; ?></td>
                                                    <td style="padding-right: 40px">Kshs <?php echo number_format($user['used']); ?></td>
                                                </tr>

                                            <?php
                                                $i++;
                                            }
                                            ?>
                                            <!--                                 TODO: integrate mpesa topups-->
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

<!--   Core JS Files   -->
<script src="js/jquery-3.1.0.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/material.min.js" type="text/javascript"></script>

<!--  Charts Plugin -->
<script src="js/chartist.min.js"></script>

<!--  Notifications Plugin    -->
<script src="js/bootstrap-notify.js"></script>

<!-- DSCON javascript methods -->
<script src="js/material-dashboard.js"></script>

<!-- DSCON DEMO methods, don't include it in your project! -->
<script src="js/demo.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        // Javascript method's body can be found in assets/js/demos.js
        demo.initDashboardPageCharts();
    });
</script>

<script>
    $(document).ready(function() {
        $('#delete').on('click', function(
            $(document).load('delete.php');
        ))
    })
</script>

</html>