<?php
session_start();

if (isset($_SESSION['admin'])) {
    $admin = $_SESSION['admin'];
} else {
    header("location: index.php");
}

require '../routeros_api.class.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password1 = $_POST['password'];
    $phone = $_POST['phone'];
    $password = md5($password1);
    $email = $_POST['email'];

    $dbname = 'network';
    $dbusername = 'root';
    $dbpassword = '12345';
    $host = 'localhost';

    $conn = mysqli_connect($host, $dbusername, $dbpassword, $dbname);

    if ($conn) {
        $sql = "SELECT * FROM users WHERE phone='" . $phone . "'";
        $results = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($results);
        if ($count > 0) {
            $error = "Phone no. already exists!";
        } else {
            $sql = "SELECT * FROM users WHERE username ='" . $username . "'";
            $results = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($results);
            if ($count > 0) {
                $error = "Username already exists!";
            } else {
                $API = new RouterosAPI();

                $hpassword = md5($password1);
                $time = "00:00:00";

                if ($API->connect('192.166.29.1', 'admin', '12345678A')) {
                    $ARRAY = $API->comm('/ip/hotspot/user/profile/add', array(
                        "name" => $username,
                        "address-pool" => "dhcp",
                        "rate-limit" => "1M/1M",
                        "queue-type" => "pcq-download-default",
                        "shared-users" => 1
                    ));

                    $ARRAY = $API->comm("/ip/hotspot/user/add", array(
                        "server" => "server1",
                        "name" => $username,
                        "password" => $hpassword,
                        "limit-uptime" => $time,
                        "profile" => $username
                    ));

                    $verification_code = mt_rand(100000, 999999);
                    $ARRAY = $API->comm("/tool/sms/send", array(
                        "port" => "usb1",
                        "channel" => "1",
                        "phone-number" => "{$phone}",
                        "message" => "Verification code: {$verification_code}"
                    ));

                    $sql = "INSERT INTO users (username, phone, password, admin, plan, email, verified, verification_code, marketer) VALUES ('$username','$phone','$hpassword', 0, 0, '$email',0, '$verification_code', 1)";
                    if (mysqli_query($conn, $sql)) {

                        $_SESSION['admin'] = 1;
                        $_SESSION['phone'] = $phone;

                        $sql = "INSERT INTO marketer (username, amount_made) VALUES ('$username', 0)";
                        if(mysqli_query($conn, $sql)){
                            header('location: verify.php');
                        }

                    } 
                }
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>Dscon | Marketer Signup</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/logo/favicon.ico" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <script src="../js/jquery-3.1.1.js"></script>
    <link rel="stylesheet" href="../bootstrap\css\bootstrap.min.css">
    <link rel="stylesheet" href="../css/password.min.css">
    <link rel="stylesheet" href="../css/login.css">
    <script src="../js/password.min.js"></script>

    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            // Showing the progress bar since the first moment.
            $('#password').password({
                animate: false
                // Check out the readme or directly jquery.password.js
                // for a detailed list of properties.
            });

            // Default behavior
            $('#default').password();

            // Linked to field input
            $('#linked').password({
                field: '#username',
                showPercent: true
            });

            // Custom events (enables button on certain score)
            // Check the readme for a detailed list of events
            $('#submit').attr('disabled', true);
            $('#events').password().on('password.score', function (e, score) {
                if (score > 75) {
                    $('#submit').removeAttr('disabled');
                } else {
                    $('#submit').attr('disabled', true);
                }
            });
        });
    </script>


</head>

<body>
<style type="text/css">

    /* better progress bar styles for the bootstrap demo */
    .pass-strength-visible input.form-control,
    input.form-control:focus {
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }

    .pass-strength-visible .pass-graybar,
    .pass-strength-visible .pass-colorbar,
    .form-control:focus + .pass-wrapper .pass-graybar,
    .form-control:focus + .pass-wrapper .pass-colorbar {
        border-bottom-right-radius: 4px;
        border-bottom-left-radius: 4px;
    }
</style>
<!--================Login Box Area =================-->
<section class="login_box_area section_gap">
    <div class="row">

        <div class="login_form_inner">
            <form class="row login_form" action="" method="post" id="loginForm">
                <div class="logo"
                     style="background: url(img/logo/d_logo_white.png); width:100px; height: 50px; background-size: cover; background-position: 50% 50%;">

                </div>

                <div class="text-center mx-auto" style="width: 100%;">
                    <?php if (!(empty($error))) {
                        ?>
                        <span class="text-danger"><?php echo $error; ?></span>
                    <?php } ?>
                </div>

                <div class="col-md-12 form-group">
                    <label for="username" class="font-weight-bold">Username</label>
                    <input type="username" class="form-control" id="username" name="username" placeholder="Jane Doe"
                           required>
                </div>
                <div class="col-md-12 form-group">
                    <label for="phone" class="font-weight-bold">Phone no.</label>
                    <input type="tel" class="form-control" id="Phone no." name="phone" placeholder="07********" required
                           min-length="10" max-length="10">
                </div>
                <div class="col-md-12 form-group">
                    <label for="email" class="font-weight-bold">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="example@gmail.com"
                           required min-length="10" max-length="10" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                </div>
                <div class="col-md-12 form-group">
                    <label for="password" class="font-weight-bold">Password</label>
                    <input type="password" class="form-control" id="events" name="password" placeholder="*******"
                           required>
                </div>
                <div class="col-md-12 form-group">
                    <button type="submit" id="submit" value="submit" class="btn btn-outline-secondary mr-4">Sign up
                    </button>
                </div>
                <br>
            </form>
        </div>
    </div>

</section>
<!--================End Login Box Area =================-->

</body>

</html>