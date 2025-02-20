<!DOCTYPE html>
<html lang="en">

<head>

    <!-- header -->
    <?php include('includes/header.php'); ?>

    <!-- title -->
    <title>New password - RESEARCH & PUBLICATION CENTER</title>

</head>

<body class="bg-light">

    <style>
        form {
            max-width: 450px;
            margin: auto;
        }
    </style>

    <?php

    // Initialize the session
    session_start();

    $password = '';
    $confirm_password = '';

    if (isset($_POST['confirm_btn'])) {

        // Validate password
        if (empty(trim($_POST['new_password']))) {
            $_SESSION['new_password'] = "Please enter your new password.";
            $validationPassword = "is-invalid";
        } else {

            if (strlen(trim($_POST["new_password"])) < 6) {
                $_SESSION['new_password'] = "Password must have atleast 6 characters.";
                $validationPassword = "is-invalid";
                $password = $_POST['new_password'];
            } else {
                $validationPassword = "is-valid";
                $password = $_POST['new_password'];
            }
        }

        // Validate confirm password
        if (empty(trim($_POST['confirm_password']))) {
            $_SESSION['confirm_password'] = "Please confirm your password.";
            $validationConfirmPassword = "is-invalid";
        } else {

            $validationConfirmPassword = "is-valid";
            $confirm_password = $_POST['confirm_password'];

            if ($password != $confirm_password) {
                $_SESSION['confirm_password'] = "Password did not match.";
                $validationConfirmPassword = "is-invalid";
            } else {

                $validationConfirmPassword = "is-valid";
                $confirm_password = $_POST['confirm_password'];

                $user_password = password_hash($confirm_password, PASSWORD_DEFAULT);

                $id = $_SESSION["id"];
                $sql = "CALL newPassword_sp('$user_password',$id);";
                $result = mysqli_query($con, $sql);

                if ($result) {
                    // Store data in session variables

                    $sql = "SELECT * FROM `users_information` WHERE id = $id";
                    $result = mysqli_query($con, $sql);
                    if ($result->num_rows > 0) {

                        while ($row = $result->fetch_assoc()) {

                            $firstname = $row['first_name'];
                            $lastname = $row['last_name'];
                            $email = $row['email'];
                        }
                    };

                    $_SESSION["loggedin"] = true;
                    $_SESSION["first_name"] = $firstname;
                    $_SESSION["last_name"] = $lastname;
                    $_SESSION["email"] = $email;
                    $_SESSION["user_password"] = $password;
                    // Redirect user to dashboard page
                    header("location: dashboard.php");
                } else {
                    $_SESSION['status'] = "Oops! Something went wrong. Please try again later.";
                }
            }
        }
    }


    ?>

    <!-- topbar for form -->
    <?php include('includes/topbarForm.php'); ?>

    <div class="wrapper">
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
                <h2 class="h3 font-weight-normal mt-5">New Password</h2>
                <p>Create your new password.</p>
                <div class="form-group mb-2">
                    <input type="password" class="form-control <?php echo $validationPassword; ?>" name="new_password" value="<?php echo $password; ?>" placeholder="New Password">
                </div>
                <?php
                if (isset($_SESSION['new_password'])) { ?>
                    <div class="text-danger alert-dismissible fade show h6" style="font-size: 13px;" role="alert">
                        <?php echo $_SESSION['new_password']; ?>
                    </div>
                <?php
                    unset($_SESSION['new_password']);
                }
                ?>
                <div class="form-group mb-2">
                    <input type="password" class="form-control <?php echo $validationConfirmPassword; ?>" name="confirm_password" value="<?php echo $confirm_password; ?>" placeholder="Confirm Password">
                </div>
                <?php
                if (isset($_SESSION['confirm_password'])) { ?>
                    <div class="text-danger alert-dismissible fade show h6" style="font-size: 13px;" role="alert">
                        <?php echo $_SESSION['confirm_password']; ?>
                    </div>
                <?php
                    unset($_SESSION['confirm_password']);
                }
                ?>
                <div class="mt-3">
                    <button type="submit" name="confirm_btn" class="btn btn-lg btn-primary shadow w-100 text-white text-decoration-none">CONFIRM</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>