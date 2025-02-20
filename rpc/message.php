<!DOCTYPE html>
<html lang="en">

<head>

    <!-- header -->
    <?php include('includes/header.php'); ?>

    <!-- title -->
    <title>Message Info - RESEARCH & PUBLICATION CENTER</title>

</head>

<body class="bg-light">
    <style>
        .content {
            max-width: 450px;
            margin: auto;
        }
    </style>
    <!-- topbar for form -->
    <?php include('includes/topbarForm.php'); ?>
    <div class="container-fluid">
        <div class="content my-5" method="POST">
            <img class="img-fluid" src="./img/logo-transparent.png" alt="logo-transparent">
            <p class="ps-3 fs-5">The first in leadership education</p>
            <div class="text-center">
                <?php
                $value = $_GET['message'];
                if ($value == 1) {
                    $class = "alert alert-danger";
                    $mess = "The Maximum number of Associate accounts (3) 
                        has been reached. Please ask your coordinator.";
                } else if ($value == 2) {
                    $class = "alert alert-danger";
                    $mess = "You cannot create another Coordinator account because (1 only per Branch)";
                } else if ($value == 3){
                    $class = "alert alert-danger";
                    $mess = "You cannot create another Associate account because (1 only per Zone). Please ask your coordinator.";
                } else {
                    $class = "bg-success rounded-3 p-3 fs-5 my-3 text-white";
                    $mess = "You have successfully create an account!";
                }
                ?>
                <div class="<?php echo $class; ?> alert-dismissible fade show mt-4" role="alert">
                    <?php echo $mess ; ?>
                </div>
                <div class="mb-3 d-flex justify-content-evenly align-items-center">
                    <a href="login.php" name="login_btn" class="btn btn-lg shadow w-50 text-white text-decoration-none" style="background-color: #B22222;">
                        <i class="bi-arrow-right"></i> Log In</a>
                    <p class="mt-3 mx-3 fs-6">OR</p>
                    <a href="register.php" name="register_btn" class="btn btn-lg bg-primary shadow w-50 text-white text-decoration-none">
                        <i class="bi-person-fill"></i> Sign Up</a>
                </div>
            </div>
        </div>
</body>

</html>