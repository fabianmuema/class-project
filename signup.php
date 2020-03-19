<?php
session_start();

require 'routeros_api.class.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password1 = $_POST['password'];
    $phone = $_POST['phone'];
    $firstname = $_POST['firstname'];
    $secondname = $_POST['secondname'];
    $apartment = $_POST['apartment'];
    $gender = $_POST['gender'];
    $password = md5($password1);
    $email = $_POST['email'];

    require 'includes/db_conf.php';

    $conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

    if ($conn) {
        $sql = "SELECT * FROM users WHERE phone='" . $phone . "'";
        $results = mysqli_query($conn, $sql);
        $count  = mysqli_num_rows($results);
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
                        "rate-limit" => "0M/0M",
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
                    $sql = "INSERT INTO users (username, phone, password, admin, plan, email, verified, verification_code, firstname, secondname, apartment, gender, new) VALUES ('$username','$phone','$hpassword', 0, 0, '$email',0, '$verification_code', '$firstname', '$secondname', '$apartment', '$gender', '1')";
                    if (mysqli_query($conn, $sql)) {
                        $_SESSION['loggedin'] = true;
                        $_SESSION['username'] = $username;
                        $_SESSION['phone'] = $phone;
                        $_SESSION['admin'] = 0;

                        $server = "db4free.net";
                        $dbuser = "dsconlimited";
                        $dbpass = "1LoveDscon!";
                        $db = "dsconlimited";

                        $con = mysqli_connect($server, $dbuser, $dbpass, $db);

                        $sql = "INSERT INTO users (username, phone, balance) VALUES ('$username', '$phone', 0)";
                        if(mysqli_query($con, $sql)){
                            
                            header('location: dashboard/');
                        } else {
                            $error = "An error occured please try again later";
                        }
                    } else {
                        $error = "An error occured please try again later!";
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
    <title>Dscon | Signup</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/logo/favicon.ico" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <script src="js/jquery-3.1.1.js"></script>
    <link rel="stylesheet" href="bootstrap\css\bootstrap.min.css">
    <link rel="stylesheet" href="css/password.min.css">
    <link rel="stylesheet" href="css/login.css">
    <script src="js/password.min.js"></script>

     <script type="text/javascript">
        jQuery(document).ready(function($) {
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
                <form class="row login_form" action="signup.php" method="post" id="loginForm">
                    <div class="logo" style="background: url(img/logo/d_logo_white.png); width:100px; height: 50px; background-size: cover; background-position: 50% 50%;">

                    </div>

                    <div class="text-center mx-auto" style="width: 100%;">
                        <?php if (!(empty($error))) {
                            ?>
                            <span class="text-danger"><?php echo $error; ?></span>
                        <?php } ?>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="firstname" class="font-weight-bold">First Name</label>
                        <input type=text class="form-control" id="firstname" name="firstname" placeholder="Jane" required>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="secondname" class="font-weight-bold">Second Name</label>
                        <input type=text class="form-control" id="secondname" name="secondname" placeholder="Doe" required>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="username" class="font-weight-bold">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Jane.Doe" required>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="gender" class="font-weight-bold">Gender</label>
                        <select name="gender" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="apartment" class="font-weight-bold">Apartment Name</label>
                        <input type=text class="form-control" id="apartment" name="apartment" placeholder="Eg. Executive" required>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="phone" class="font-weight-bold">Phone no.</label>
                        <input type="tel" class="form-control" id="Phone no." name="phone" placeholder="07********" required min-length="10" max-length="10">
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="email" class="font-weight-bold">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="example@gmail.com" required min-length="10" max-length="10" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="password" class="font-weight-bold">Password</label> <span id="svg" onclick="text()" style="font-size: 0.7em;position: absolute;right: 20px"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg></span>
                            <input type="password" class="form-control" id="events" name="password" placeholder="*******" required>
                    </div>

                    <div class="col-md-12 form-group">
                        <button type="submit" id="submit" value="submit" class="btn btn-outline-secondary mr-4">Sign up</button>
                        <a href="http://dsconlimited.net" class="text-center text-dark">Login</a>
                    </div>
                    <br>
                </form>
            </div>
        </div>

    </section>
    <!--================End Login Box Area =================-->

    <!-- Optional JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js";
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1";
    crossorigin="anonymous" >
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script>
		function text() {
			var type = document.getElementById('events').type;
			if(type == "password") {
				document.getElementById('events').type = "text";
				document.getElementById("svg").innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M0 0h24v24H0zm0 0h24v24H0zm0 0h24v24H0zm0 0h24v24H0z" fill="none"/><path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/></svg>';
			} else {
				document.getElementById('events').type = "password";
				document.getElementById("svg").innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>';
			}
		}
	</script>
</body>

</html>