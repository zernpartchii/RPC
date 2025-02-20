<!DOCTYPE html>
<html lang="en">

<head>

    <!-- header -->
    <?php include('includes/header.php'); ?>

    <!-- title -->
    <title>Verify Account - RESEARCH & PUBLICATION CENTER</title>

</head>

<body class="bg-light">

    <style>
        form {
            max-width: 450px;
            margin: auto;
        }
    </style>


    <?php

    session_start();
    $firstname = '';
    $lastname = '';
    $sum = '';
    if (isset($_POST['submit_btn'])) {

        $sum = $_POST['sum'];
        $sum++;

        // Validate firstname
        if (empty($_POST['firstname'])) {
            $_SESSION['firstname'] = "Please enter your firstname.";
            $validationFirstname = "is-invalid";
        } else {
            $validationFirstname = "is-valid";
            $firstname = $_POST['firstname'];
        }

        // Validate firstname
        if (empty($_POST['lastname'])) {
            $_SESSION['lastname'] = "Please enter your lastname.";
            $validationLastname = "is-invalid";
        } else {
            $validationLastname = "is-valid";
            $lastname = $_POST['lastname'];
        }

        // execute if inputs not empty 
        if (!empty($firstname) && !empty($lastname)) {

            // Prepare a select statement
            $sql = "SELECT id, first_name, last_name FROM `users_information` WHERE first_name = ? AND last_name = ? AND id= ?";
            if ($stmt = mysqli_prepare($con, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sss", $param_firstname, $param_lastname,$param_user_id);

                // Set parameters
                $param_firstname = $firstname;
                $param_lastname = $lastname;
                $param_user_id = $_SESSION["id"];

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    // Store result
                    mysqli_stmt_store_result($stmt);

                    // Check if firstname or lastname exists, if yes then execute
                    if (mysqli_stmt_num_rows($stmt) == 1) {

                        mysqli_stmt_bind_result($stmt, $id, $firstname, $lastname);

                        if (mysqli_stmt_fetch($stmt)) {
                            $_SESSION["id"] = $id;
                            // Redirect user to newPassword page
                            header("location: newPassword.php");
                        }
                    } else {

                        // firstname or lastname doesn't exist, display a generic error message
                        $_SESSION['lastname'] = "You have entered invalid firstname or lastname!";
                        $validationFirstname = "is-invalid";
                        $validationLastname = "is-invalid";

                        //display a generic error message
                        if ($sum == 2) {
                            $_SESSION['lastname'] = "Make sure your spelling is correct!";
                            $validationFirstname = "is-invalid";
                            $validationLastname = "is-invalid";
                        }
                        //display a generic error message
                        if ($sum == 3) {
                            $_SESSION['lastname'] = "Incorrect spelling to your firstname or lastname";
                            $validationFirstname = "is-invalid";
                            $validationLastname = "is-invalid";
                        }
                        //display a generic error message
                        if ($sum == 4) {
                            $_SESSION['lastname'] = "Sorry, we can't verify its you.";
                            $validationFirstname = "is-invalid";
                            $validationLastname = "is-invalid";

                            $firstname = '';
                            $lastname = '';
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
            <h2 class="h3 font-weight-normal mt-5">Verify Account</h2>
            <p>Enter your firstname and lastname to verify its you.</p>
            <input type="text" id="firstname" name="firstname" class="form-control mb-2 <?php echo $validationFirstname; ?>" value="<?php echo $firstname; ?>" placeholder="Firstname">
            <?php
            if (isset($_SESSION['firstname'])) { ?>
                <div class="text-danger alert-dismissible fade show h6" style="font-size: 13px;" role="alert">
                    <?php echo $_SESSION['firstname']; ?>
                </div>
            <?php
                unset($_SESSION['firstname']);
            }
            ?>
            <input type="text" id="lastname" name="lastname" class="form-control <?php echo $validationLastname; ?>" value="<?php echo $lastname; ?>" placeholder="Lastname">
            <?php
            if (isset($_SESSION['lastname'])) { ?>
                <div class="text-danger alert-dismissible fade show h6" style="font-size: 13px;" role="alert">
                    <?php echo $_SESSION['lastname']; ?>
                </div>
            <?php
                unset($_SESSION['lastname']);
            }
            ?>
            <input type="hidden" name="sum" value="<?= $sum; ?>" class="form-control">
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