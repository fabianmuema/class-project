<?php

session_start();

if (isset($_SESSION['phone'])) {
    $phone = $_SESSION['phone'];
    $str = ltrim($phone, '0');
    $phone = $str;
} else {
    header('location: phone.php');
}

if($_SERVER['REQUEST_METHOD'] == "POST"){

    require 'includes/db_conf.php';
    $sql = "SELECT * FROM users WHERE phone = '" . $phone . "'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    $username = $user['username'];

    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if ($password == $password2) {
        $password = md5($password);
        require 'routeros_api.class.php';

        $API = new RouterosAPI();

        if ($API->connect("192.166.29.1", "admin", "12345678A")) {
                $API->write('/ip/hotspot/user/getall', false);
                $API->write('=.proplist=.id', false);
                $API->write('?name=' . $username);
                $ARRAY = $API->read(true);
                $id = $ARRAY[0]['.id'];
                $API->write('/ip/hotspot/user/set', false);
                $API->write('=.id=' . $id, false);
                $API->write('=password=' . $password);
                $ARRAY = $API->read(true);
            $sql = "UPDATE users SET password = '" . $password . "' WHERE username = '" . $username . "'";
            mysqli_query($conn, $sql);

            $_SESSION['error'] = "<span style='color:green'>Password was changed succesfully. You can now login.</span>";
            header("location: index.php");

        } else {
            $error = "Cannot connect to the server! Please try again.";
        }

    } else {
        $error = "Passwords do not match.";
    }

}
?>
<!doctype html>
<html lang="en">

<head>
    <title>Dscon | Password Reset</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/logo/favicon.ico" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap\css\bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
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
                    <label for="password" class="font-weight-bold">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="*******"
                           required>
                </div>
                <div class="col-md-12 form-group">
                    <label for="password2" class="font-weight-bold">Confirm Password</label>
                    <input type="password" class="form-control" id="password2" name="password2" placeholder="*******"
                           required>
                </div>
                <div class="col-md-12 form-group">
                    <button type="submit" value="submit" class="btn btn-outline-secondary mr-4">Confirm</button>
                    or <a href="index.php" class="text-underline text-dark pl-4">Login </a>

                </div>
                <br>
            </form>
        </div>
    </div>
    </div>

</section>
<!--================End Login Box Area =================-->


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>
</body>

</html>