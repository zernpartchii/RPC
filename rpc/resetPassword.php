<!DOCTYPE html>
<html lang="en">

<head>

    <!-- header -->
    <?php include('includes/header.php'); ?>

    <!-- title -->
    <title>Reset password - RESEARCH & PUBLICATION CENTER</title>

</head>

<body class="bg-light">

    <style>
        form {
            max-width: 450px;
            margin: auto;
        }
    </style>

    <?php

    $email = '';
    $sum = '';
    if (isset($_POST['submit_btn'])) {

        $sum = $_POST['sum'];
        $sum++;

        // Validate email
        if (empty($_POST['email'])) {
            $_SESSION['email'] = "Please enter your email address.";
            $validationEmail = "is-invalid";
        } else {
            $validationEmail = "is-valid";
            $email = $_POST['email'];
        }

        // execute if inputs not empty 
        if (!empty($email)) {

            // Prepare a select statement
            $sql = "SELECT id, email, user_password FROM `users_information` WHERE email = ?";
            if ($stmt = mysqli_prepare($con, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_email);

                // Set parameters
                $param_email = $email;

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    // Store result
                    mysqli_stmt_store_result($stmt);

                    // Check if email exists, if yes then verify password
                    if (mysqli_stmt_num_rows($stmt) == 1) {

                        mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);

                        if (mysqli_stmt_fetch($stmt)) {
                            
                            session_start();
                            $_SESSION["id"] = $id;
                            // Redirect user to verify_users page
                            header("location: verify_users.php");
                            
                        }
                    } else {
                        // email doesn't exist, display a generic error message
                        $_SESSION['email'] = "Email doesn't exist!";
                        $validationEmail = "is-invalid";
                        
                        //display a generic error message
                        if ($sum == 2) {
                            $_SESSION['email'] = "You have entered an invalid email! <br> Please try again.";
                            $validationEmail = "is-invalid";
                        }

                        //display a generic error message
                        if ($sum == 3) {
                            $_SESSION['email'] = "Please enter a correct email address.";
                        }
                        //display a generic error message
                        if ($sum > 4) {
                            $_SESSION['email'] = "Sorry, we can't reach your email.";
                            $email = '';
                            $sum = 0;
                        }
                    }
                } else {
                    $_SESSION['status'] = "Oops! Something went wrong. Please try again later.";
                }

                // Close statement
                mysqli_stmt_close($stmt);
            }
        }
    }

    ?>

    <!-- topbar for form -->
    <?php include('includes/topbarForm.php'); ?>

    <div class="container-fluid">
        <form class="p-4 my-3" method="POST">
            <img class="img-fluid" src="./img/logo-transparent.png" alt="logo-transparent">
            <p class="ps-3 fs-5">The first in leadership education</p>
            <?php
            if (isset($_SESSION['status'])) { ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['status']; ?>
                </div>
            <?php
                unset($_SESSION['status']);
            }
            ?>
            <h2 class="h3 font-weight-normal mt-5">Reset Password?</h2>
            <p>Enter your email to reset your password.</p>
            <input type="text" name="email" class="form-control <?php echo $validationEmail; ?>" value="<?php echo $email; ?>" placeholder="Email">
            <input type="hidden" name="sum" value="<?= $sum; ?>" class="form-control">
            <?php
            if (isset($_SESSION['email'])) { ?>
                <div class="text-danger alert-dismissible fade show h6" style="font-size: 13px;" role="alert">
                    <?php echo $_SESSION['email']; ?>
                </div>
            <?php
                unset($_SESSION['email']);
            }
            ?>
            <div class="mt-3">
                <button type="submit" name="submit_btn" class="btn btn-lg btn-primary shadow w-100 text-white text-decoration-none ">SUBMIT</button>
                <div class="mt-3 text-center">
                    <p class="d-inline align-middle">Do you want to Login?</p>
                    <a class="text-center btn btn-sm btn-danger text-decoration-none fw-semibold text-white" href="login.php">Login here!</a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>