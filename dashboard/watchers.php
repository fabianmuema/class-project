<?php

include_once('../includes/login_status.php');

include_once('../includes/db_conf.php');

$admin = $_SESSION['admin'];
$sql = "SELECT * FROM users WHERE username='" . $username . "'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
$balance = $user['balance'];
$plan = $user['plan'];

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

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="img/logo/favicon.ico" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>DSCON | Client List</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Bootstrap core CSS     -->
    <link href="css/bootstrap.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="../css/main.css">


    <!--  Material Dashboard CSS    -->
    <link href="css/material-dashboard.css" rel="stylesheet" />

    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="css/demo.css" rel="stylesheet" />

    <link rel="stylesheet" href="css/icon.css">
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet" />
    <link href="http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons" rel="stylesheet" type="text/css" />

</head>

<body>
    <header>
        <nav class="navbar fixed-top navbar-expand-lg " style="background: black;">
            <a class="navbar-brand my-auto ml-3" href="">

            </a>
            <div class="collapse navbar-collapse py-0" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto my-auto pt-3 pb-3">
                    <?php if ($admin == false) { ?>
                        <li class=" nav-item py-0"><a class="nav-link text-light py-0" href="../dashboard/" style="color: #f8f9fa!important;">Profile</a></li>
                    <?php } else {
                        ?>
                        <li class=" nav-item py-0"><a class="nav-link text-light py-0" href="../dashboard/" style="color: #f8f9fa!important;">Dashboard</a></li>
                    <?php } ?>
                    <li class="nav-item py-0">
                        <a href="../internet/" class="nav-link py-0" style="color: #f8f9fa!important;">Internet</a>
                    </li>
                    <li class="nav-item py-0">
                        <a href="../movie/" class="nav-link text-light py-0" style="color: #f8f9fa!important;">Entertainment</a>
                    </li>
                    <?php if ($admin == true) {
                        ?>
                        <li class="nav-item py-0">
                            <a class="nav-link py-0 text-light" href="client-list.php" style="color: #f8f9fa!important;">Client List</a>
                        </li>
                        <li class="nav-item py-0">
                            <a class="nav-link py-0 text-light" href="issues.php" style="color: #f8f9fa!important;">Issues</a>
                        </li>
                    <?php } ?>
                    <?php if ($admin == false) { ?>
                        <li class="nav-item py-0">
                            <a class="nav-link py-0 text-light" href="../dashboard/report_issue.php" style="color: #f8f9fa!important;">Report Issue</a>
                        </li>


                        <li class="dropdown ml-auto" style="padding-left: 20px;">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="material-icons" style="color: #f8f9fa!important;">notifications</i>
                                <?php
                                    $sql = "SELECT * FROM notifications WHERE username='" . $username . "'";
                                    $results = mysqli_query($conn, $sql);
                                    $count = mysqli_num_rows($results);
                                    ?>
                                <span class="notification"><?php echo $count; ?></span>
                                <p class="hidden-lg hidden-md">Notifications</p>
                            </a>
                            <ul class="dropdown-menu" style="margin-left: -250px;">
                                <?php while ($notification = mysqli_fetch_assoc($results)) { ?>
                                    <li><a href="dismiss.php?id=<?php echo $notification['id']; ?>"><?php echo $notification['notification']; ?></a>
                                    <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <li class="dropdown" style="padding-left: 20px; padding-right: 20px;">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: #f8f9fa!important;">
                            <i class="material-icons">person</i>
                            <p class="hidden-lg hidden-md">Profile</p>
                        </a>
                        <ul class="dropdown-menu" style="margin-left: -70px;">
                            <li><a href="#"><?php echo $username; ?></a></li>
                    </li>
                    <li> <a href="../internet/">Change plan</a>
                    </li>
                    <li> <a href="logout.php">Logout</a>
                    </li>
                </ul> <!-- end #nav -->
            </div>
        </nav> <!-- end #nav-wrap -->
    </header>

    <div class="main-panel">
        <div class="content">
            <div class="container-fluid">

                <div class="row">

                    <div class="col-md-12">
                        <?php $date = date("Y-m-d"); 
                        ?>

                        <div class="card">
                            <div class="card-header" data-background-color="<?php echo $color; ?>">
                                <h4 class="title">Movies Watched</h4>
                            </div>
                            <div class="card-content table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Movie</th>
                                        <th>Time</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM watchedmovies ORDER BY time DESC";
                                        $result = mysqli_query($conn, $sql);
                                        $x = 1;
                                        while ($user = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $x; ?></td>
                                                <td><?php echo $user['username']; ?></td>
                                                <td><?php echo $user['movie']; ?></td>
                                                <td><?php echo $user['time']; ?></td>
                                            </tr>
                                        <?php
                                            $x = $x + 1;
                                        } ?>
                                    </tbody>
                                </table>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

<script src="js/material.min.js" type="text/javascript"></script>

<!--  Charts Plugin -->
<script src="js/chartist.min.js"></script>

<!--  Notifications Plugin    -->
<script src="js/bootstrap-notify.js"></script>

<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

<!-- Material Dashboard javascript methods -->
<script src="js/material-dashboard.js"></script>

<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="js/demo.js"></script>

</html>