<?php
session_start();
include "connection.php";
if (isset($_SESSION['email'])) {
?>
    <script>
        alert("Already logged in.!")
        window.location = "index.php";
    </script>
<?php
}
if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($con, $_REQUEST['email']);
    $password = mysqli_real_escape_string($con, $_REQUEST['password']);
    $pass = password_hash($password, PASSWORD_BCRYPT);

    $emailSearch = "SELECT * FROM `users` WHERE email = '".$email."'";
    $query = mysqli_query($con, $emailSearch);
    $email_count = mysqli_num_rows($query);

    if ($email_count) {
        $email_pass = mysqli_fetch_assoc($query);
        $db_pass = $email_pass['password'];
        $pass_decode = password_verify($password, $db_pass);

        if ($pass_decode) {
            $_SESSION['email'] = $email_pass['email'];
            header("location: ./");
        }
        else{
            echo "Don't be over smart I'm watching you.!";
        }
    }
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card Genrator</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <!-- popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <!-- Bootstrap js -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/fonts/font.css">
    <style>
        body {
            background: linear-gradient(80deg, rgba(255, 255, 255, 1), rgba(211, 100, 80, 1), rgba(247, 153, 127, 1), rgba(211, 100, 80, 1), rgba(255, 255, 255, 1));
            background-size: 400% 400%;
            animation: gradient 8s ease infinite;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .shadow {
            box-shadow: 0 10px 16px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19) !important;
        }

        .border-rounded {
            border-radius: 35px;
        }

        .railway {
            font-family: 'Raleway', sans-serif;
        }
    </style>
</head>

<body>
    <div class="container h-100">
        <div class="w-100 d-flex mt-5">
            <img src="http://www.akankshaaradhyafoundation.com/assets/images/aaf-logo.png" class="ml-auto d-none d-md-block">
            <h2 class="mr-auto my-auto"><strong>AKANKSHA ARADHYA FOUNDATION (AAF)</strong></h2>
        </div>
        <form method="post" class="border bg-light p-5 border-rounded mt-5" style="box-shadow:0 10px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19) !important;">
            <legend><strong>Log in</strong></legend>
            <small>(Fields with <span class="text-danger"><strong>*</strong></span> are mandatory)</small>
            <hr>
            <div class="form-group">
                <label>Login E-mail ID<span class="text-danger"><strong>*</strong></span></label>
                <input type="email" class="form-control" placeholder="Enter E-mail ID" name="email" required>
            </div>
            <div class="form-group">
                <label>Password<span class="text-danger"><strong>*</strong></span></label>
                <input type="password" class="form-control" placeholder="Enter Password" name="password" required>
            </div>
            <div class="d-flex">
                <div class="mx-auto">
                    <button name="button" type="reset" class="btn btn-outline-secondary m-1">Reset</button>
                    <button name="submit" type="submit" class="btn btn-primary m-1">Login</button>
                </div>
            </div>
        </form>
        <div class="sticky-top">
            <p class="text-center my-3"><strong>Visit our site <span><a href="http://www.akankshaaradhyafoundation.com/index.php" target="_blank">AAF</a></span></strong></p>
        </div>
    </div>
</body>

</html>