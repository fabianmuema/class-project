<?php
session_start();

if (isset($_SESSION['phone'])) {
    $phone = $_SESSION['phone'];

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        require 'includes/db_conf.php';

        $sql = "SELECT * FROM users where phone = '" . $phone . "'";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);
        $verification_code = $user['verification_code'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $verification = $_POST['verification'];
            if ($verification_code == $verification) {
                $_SESSION['verified'] = true;
                header("location: passwordreset.php");
            } else {
                $error = "Verification code is incorrect.";
            }
        }
    } 
} else {
    header("location: phone.php");
}

?>

<!doctype html>
<html lang="en">

<head>
    <title>Dscon | Account Verification</title>
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
                <br>
                <div class="col-md-12 form-group">
                    <small>Enter the 6 digit verification code sent to <strong><?php echo $phone; ?></strong>.
                        <br>
                        <input type="verification" class="form-control" id="verification" name="verification"
                               placeholder="6 digit code" required>
                </div>
                <div class="col-md-12 form-group d-row d-flex justify-content-center">
                    <button type="submit" value="submit" class="btn btn-outline-secondary mr-4">Verify Account</button>
                    <a href="resend.php?phone=<?php echo $phone; ?>"
                       style="color: black; text-decoration: underline; padding-top: 30px;">Resend verification
                        code.</a>

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