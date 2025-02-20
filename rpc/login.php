<!DOCTYPE html>
<html lang="en">

<head>

    <!-- header -->
    <?php include('includes/header.php'); ?>

    <!-- title -->
    <title>Login - RESEARCH & PUBLICATION CENTER</title>

</head>

<body class="bg-light">

    <style>
        input[type="text"] {
            border-bottom-left-radius: 0px;
            border-bottom-right-radius: 0px;
        }

        input[type="password"] {
            border-top-left-radius: 0px;
            border-top-right-radius: 0px;
        }

        form{
            width: 380px;
        }
    </style>

    <!-- topbar for form -->
    <?php

    // Initialize the session
    session_start();

    include('includes/topbarForm.php');

    // Check if the user is already logged in, if yes then redirect him to welcome page
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        header("location: dashboard.php");
        exit;
    }

    $email = '';
    $password = '';
    $sum = '';

    if (isset($_POST['login_btn'])) {

        // number of attemp
        $sum = $_POST['sum'];
        $sum++;

        // Validate email
        if (empty($_POST['email'])) {
            $_SESSION['email'] = "Please enter your Email.";
            $validationEmail = "is-invalid";
        } else {
            $validationEmail = "is-valid";
            $email = $_POST['email'];
        }

        // Validate password
        if (empty($_POST['password'])) {
            $_SESSION['password'] = "Please enter your Password.";
            $validationPassword = "is-invalid";
        } else {
            $validationPassword = "is-valid";
            $password = $_POST['password'];
        }

        // execute if inputs not empty 
        if (!empty($email) && !empty($password)) {

            // Prepare a select statement
            $sql = "SELECT id, first_name, last_name, email, user_password FROM `users_information` WHERE email = ?";
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
                        // Bind result variables
                        mysqli_stmt_bind_result($stmt, $id, $firstname, $lastname, $email, $hashed_password);

                        if (mysqli_stmt_fetch($stmt)) {

                            if (password_verify($password, $hashed_password)) {
                                // Password is correct, so start a new session

                                if (isset($_POST['keep_me_login'])) {
                                    // Store data in session variables
                                    $_SESSION["loggedin"] = true;
                                    $_SESSION["id"] = $id;
                                    $_SESSION["first_name"] = $firstname;
                                    $_SESSION["last_name"] = $lastname;
                                    $_SESSION["email"] = $email;
                                    $_SESSION["user_password"] = $password;
                                    // Redirect user to dashboard page
                                    header("location: dashboard.php");
                                } else {
                                    // Store data in session variables
                                    $_SESSION["loggedin"] = false;
                                    $_SESSION["id"] = $id;
                                    $_SESSION["first_name"] = $firstname;
                                    $_SESSION["last_name"] = $lastname;
                                    $_SESSION["email"] = $email;
                                    $_SESSION["user_password"] = $password;
                                    // Redirect user to dashboard page
                                    header("location: dashboard.php");
                                }
                            } else {
                                // Password is not valid, display a generic error message
                                $_SESSION['password'] = "Inccorect password! <br> Please try again.";
                                $validationPassword = "is-invalid";

                                //display a generic error message
                                if ($sum == 2) {
                                    $_SESSION['password'] = "Please enter a correct password.";
                                }
                                //display a generic error message
                                if ($sum > 3) {
                                    $_SESSION['password'] = "Invalid Password! <br> To reset password, click Forgot password.";
                                }
                                //display a generic error message
                                if ($sum > 5) {
                                    $_SESSION['password'] = "You have entered an invalid password.<br>Please reset your password.";
                                    $password = '';
                                    $sum = 0;
                                }
                            }
                        }
                    } else {
                        // Email doesn't exist, display a generic error message
                        $_SESSION['email'] = "Email doesn't exist!";
                        $validationEmail = "is-invalid";
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

    <div class="container-fluid d-flex justify-content-center align-items-center">
        <div class="container-fluid row mt-5">
            <div class="col-md-5 order-md-2 order-sm-1 d-flex justify-content-center align-items-center">
                <div class="card border-0 bg-light">
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-2">
                                <?php
                                if (isset($_SESSION['status'])) { ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <?php echo $_SESSION['status']; ?>
                                    </div>
                                <?php
                                    unset($_SESSION['status']);
                                }
                                ?>
                                <h2 class="h2 font-weight-normal mb-4">Log In</h2>
                                <P>Please fill in your credentials to login.</P>
                                <input type="text" name="email" class="form-control <?php echo $validationEmail; ?>" value="<?php echo $email; ?>" placeholder="Email">
                                <?php
                                if (isset($_SESSION['email'])) { ?>
                                    <div class="text-danger alert-dismissible fade show h6" style="font-size: 13px;" role="alert">
                                        <?php echo $_SESSION['email']; ?>
                                    </div>
                                <?php
                                    unset($_SESSION['email']);
                                }
                                ?>
                                <input type="password" name="password" class="form-control <?php echo $validationPassword; ?>" value="<?php echo $password; ?>" placeholder="Password">
                                <?php
                                if (isset($_SESSION['password'])) { ?>
                                    <div class="text-danger alert-dismissible fade show h6" style="font-size: 13px;" role="alert">
                                        <?php echo $_SESSION['password']; ?>
                                    </div>
                                <?php
                                    unset($_SESSION['password']);
                                }
                                ?>
                            </div>
                            <div class="mb-3">
                                <a href="resetPassword.php" class="text-primary">Forgot password?</a>
                                <input type="hidden" name="sum" value="<?= $sum; ?>" class="form-control">
                            </div>
                            <div class="mb-3">
                                <input type="checkbox" id="check" name="keep_me_login">
                                <label for="check"> Keep me Logged in </label>
                            </div>
                            <div class="mb-3">
                                <button type="submit" name="login_btn" class="btn btn-lg shadow w-100 text-white text-decoration-none" style="background-color: #B22222;">
                                <i class="bi-arrow-right"></i> Log In</button>
                                <div class="m-3 mt-4 text-center">
                                    <p class="d-inline align-middle">Don't have an account?</p>
                                    <a class="text-center btn btn-sm btn-primary text-decoration-none fw-semibold text-white" href="register.php">Create an account.</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- include welcome page -->
            <?php 
            include('includes/WelcomePage.php'); ?>

        </div>
    </div>
</body>

</html>