<!DOCTYPE html>
<html lang="en">

<head>

    <!-- header -->
    <?php include('includes/header.php'); ?>

    <!-- title -->
    <title>Sign Up - RESEARCH & PUBLICATION CENTER</title>

</head>

<body class="bg-light">

    <style>
        form {
            max-width: 450px;
            margin: auto;
        }
    </style>

    <!-- topbar for form -->
    <?php

    include('includes/topbarForm.php');

    // Initialize the session
    session_start();

    $firstname = '';
    $lastname = '';
    $email = '';
    $password = '';
    $confirm_password = '';
    $vip = '';
    $zone = '';

    if (isset($_POST['submit_btn'])) {


        // Validate firstname
        if (empty(trim($_POST['firstname']))) {
            $_SESSION['firstname'] = "Please enter your firstname.";
            $validationFirstname = "is-invalid border-danger";
        } else {
            $validationFirstname = "is-valid border-success";
            $firstname = $_POST['firstname'];
        }

        // Validate lastname
        if (empty(trim($_POST['lastname']))) {
            $_SESSION['lastname'] = "Please enter your lastname.";
            $validationLastname = "is-invalid border-danger";
        } else {
            $validationLastname = "is-valid border-success";
            $lastname = $_POST['lastname'];
        }

        // Validate email
        if (empty(trim($_POST['email']))) {
            $_SESSION['email'] = "Please enter your email.";
            $validationEmail = "is-invalid border-danger";
        } else {
            $validationEmail = "is-valid border-success";
            $email = $_POST['email'];
        }

        // Validate Account type
        if ($_POST['vip'] == 'none') {
            $_SESSION['vip'] = "Please choose a user type.";
            $validationVIP = "is-invalid border-danger";
        } else {
            $validationVIP = "is-valid border-success ";
            $vip = $_POST['vip'];

            if ($vip == "Research Associate") {
                $zoneValidate = "d-inline";
            }else{
                $zoneValidate = "d-none";
            }
        }

        // Validate zone
        if ($_POST['addZone'] == 'none') {
            $_SESSION['addZone'] = "Please choose a zone.";
            $validationZone = "is-invalid border-danger ";
        } else {
            $validationZone = "is-valid border-success ";
            $zone = $_POST['addZone'];
        }

        // Validate password
        if (empty(trim($_POST['password']))) {
            $_SESSION['password'] = "Please enter your password.";
            $validationPassword = "is-invalid border-danger";
        } else {

            if (strlen(trim($_POST["password"])) < 6) {
                $_SESSION['password'] = "Password must have atleast 6 characters.";
                $validationPassword = "is-invalid border-danger";
                $password = $_POST['password'];
            } else {
                $validationPassword = "is-valid border-success";
                $password = $_POST['password'];
            }
        }

        // Validate confirm password
        if (empty(trim($_POST['confirm_password']))) {
            $_SESSION['confirm_password'] = "Please confirm your password.";
            $validationConfirmPassword = "is-invalid border-danger";
        } else {
            $validationConfirmPassword = "is-valid border-success";
            $confirm_password = $_POST['confirm_password'];

            if ($password != $confirm_password) {
                $_SESSION['confirm_password'] = "Password did not match.";
                $validationConfirmPassword = "is-invalid border-danger";
            } else {
                $validationConfirmPassword = "is-valid border-success";
                $confirm_password = $_POST['confirm_password'];

                if ($vip == 'Research Coordinator') {
                    $zone = '?';
                }

                if (!empty($firstname) && !empty($lastname) && !empty($email) && !empty($password) && !empty($zone) && !empty($confirm_password) && !empty($vip)) {

                    $sql = "SELECT `zone` FROM `users_information` WHERE `zone`='$zone'";
                    $result = mysqli_query($con, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $zoneCheck = $row['zone'];

                    $sql = "SELECT Count(id) AS 'Associator' FROM `users_information` WHERE type='Research Associate'";
                    $result = mysqli_query($con, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $total =  $row['Associator'];

                    $sql = "SELECT Count(id) AS 'Coordinator' FROM `users_information` WHERE type='Research Coordinator'";
                    $result = mysqli_query($con, $sql);
                    $row = mysqli_fetch_assoc($result);

                    if (!empty($zoneCheck)) {

                        if ($zoneCheck == "?") {
                            $mess = "2";
                        } else {
                            $mess = "3";
                        }
                        header("location: message.php? message=$mess");
                        
                    } else if ($total == 3 && $row['Coordinator'] == 1) {
                        header("location: message.php? message=1");
                    } else {

                        if ($vip == 'Research Associate') {
                            $viptype = $vip;
                        } else {
                            $viptype = $vip;
                        }

                        $user_password = password_hash($confirm_password, PASSWORD_DEFAULT);
                        $sql = "CALL insert_users_sp('$firstname','$lastname','$email','$user_password', '$viptype', '$zone')";
                        $result = mysqli_query($con, $sql);

                        if ($result) {
                            header("location: message.php? message=4");
                        } else {
                            $_SESSION['success'] = "Account was not created.";
                        }
                    }
                    // Close connection
                    mysqli_close($con);
                } else {
                    // echo 'something went wrong';
                }
            }
        }
    }
    ?>
    <div class="container-fluid d-flex justify-content-center align-items-center">
        <div class="container-fluid row mt-3">
            <div class="col-md-5 order-md-2 order-sm-1 d-flex justify-content-center align-items-center">
                <div class="card border-0 bg-light">
                    <div class="card-body">
                        <form method="POST">
                            <?php
                            if (isset($_SESSION['status'])) { ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php echo $_SESSION['status']; ?>
                                </div>
                            <?php
                                unset($_SESSION['status']);
                            }
                            ?>
                            <?php
                            if (isset($_SESSION['success'])) { ?>
                                <div class="bg-success rounded-3 p-3 my-3 text-white alert-dismissible fade show" role="alert">
                                    <strong>Hey!</strong> <?php echo $_SESSION['success']; ?>
                                </div>
                            <?php
                                unset($_SESSION['success']);
                            }
                            ?>
                            <h2 class="h3 font-weight-normal my-4">Sign Up</h2>
                            <p>Create your account it's free only take a minute.</p>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control mt-2 border-secondary <?php echo $validationFirstname; ?>" name="firstname" value="<?php echo $firstname; ?>" placeholder="First Name">
                                        <?php
                                        if (isset($_SESSION['firstname'])) { ?>
                                            <div class="text-danger alert-dismissible fade show h6" style="font-size: 13px;" role="alert">
                                                <?php echo $_SESSION['firstname']; ?>
                                            </div>
                                        <?php
                                            unset($_SESSION['firstname']);
                                        }
                                        ?>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control mt-2 border-secondary <?php echo $validationLastname; ?>" name="lastname" value="<?php echo $lastname; ?>" placeholder="Last Name">
                                        <?php
                                        if (isset($_SESSION['lastname'])) { ?>
                                            <div class="text-danger alert-dismissible fade show h6" style="font-size: 13px;" role="alert">
                                                <?php echo $_SESSION['lastname']; ?>
                                            </div>
                                        <?php
                                            unset($_SESSION['lastname']);
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <input type="email" class="form-control border-secondary <?php echo $validationEmail; ?>" name="email" value="<?php echo $email; ?>" placeholder="Email Address">
                                <?php
                                if (isset($_SESSION['email'])) { ?>
                                    <div class="text-danger alert-dismissible fade show h6" style="font-size: 13px;" role="alert">
                                        <?php echo $_SESSION['email']; ?>
                                    </div>
                                <?php
                                    unset($_SESSION['email']);
                                }
                                ?>
                            </div>

                            <div class="form-group my-2">
                                <select class="form-control text-muted border-secondary <?php echo $validationVIP; ?>" onchange="my_fun(this.value)" name="vip" id="vip">
                                    <?php
                                    if (!empty($vip)) {
                                    ?>
                                        <option value="<?= $vip; ?>" selected hidden><?= $vip; ?></option>
                                    <?php
                                    } else {
                                    ?>
                                        <option value="none" selected hidden>Account Type </option>
                                    <?php
                                    }
                                    ?>
                                    <option value="Research Associate">Research Associate</option>
                                    <option value="Research Coordinator">Research Coordinator</option>
                                </select>
                                <?php
                                if (isset($_SESSION['vip'])) { ?>
                                    <div class="text-danger alert-dismissible fade show h6" style="font-size: 13px;" role="alert">
                                        <?php echo $_SESSION['vip']; ?>
                                    </div>
                                <?php
                                    unset($_SESSION['vip']);
                                }
                                ?>
                            </div>
                            <script>
                                function my_fun(str) {
                                    if (str == 'Research Associate') {
                                        document.getElementById('zone').style.display = 'inline';
                                    } else {
                                        document.getElementById('zone').style.display = 'none';
                                    }
                                }
                            </script>
                            <style>
                                .zone{
                                    display: none;
                                }
                            </style>
                            <div id="zone" class="form-group zone mb-2 <?php echo $zoneValidate; ?>">
                                <select class="form-control text-muted border-secondary mb-2 <?php echo $validationZone; ?>" id="addZone" name="addZone">
                                    <?php
                                    if (!empty($zone)) {
                                    ?>
                                        <option value="<?= $zone; ?>" selected hidden><?= $zone; ?></option>
                                    <?php
                                    } else {
                                    ?>
                                        <option value="none" selected hidden>Choose Zone </option>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    $sql = "SELECT * FROM `zone`";
                                    $result1 = mysqli_query($con, $sql);
                                    while ($row = $result1->fetch_assoc()) { ?>
                                        <option value="<?php echo $row["id"]; ?>"><?php echo $row["Zone"]; ?></option>
                                    <?php }
                                    ?>
                                </select>
                                <?php
                                if (isset($_SESSION['addZone'])) { ?>
                                    <div class="text-danger alert-dismissible fade show h6" style="font-size: 13px;" role="alert">
                                        <?php echo $_SESSION['addZone']; ?>
                                    </div>
                                <?php
                                    unset($_SESSION['addZone']);
                                }
                                ?>
                            </div>
                            <div class="form-group mt-2">
                                <input type="password" class="form-control border-secondary <?php echo $validationPassword; ?>" name="password" value="<?php echo $password; ?>" placeholder="Password">
                            </div>
                            <?php
                            if (isset($_SESSION['password'])) { ?>
                                <div class="text-danger alert-dismissible fade show h6" style="font-size: 13px;" role="alert">
                                    <?php echo $_SESSION['password']; ?>
                                </div>
                            <?php
                                unset($_SESSION['password']);
                            }
                            ?>
                            <div class="form-group mt-2">
                                <input type="password" class="form-control border-secondary <?php echo $validationConfirmPassword; ?>" name="confirm_password" value="<?php echo $confirm_password; ?>" placeholder="Confirm Password">
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
                                <button type="submit" name="submit_btn" class="btn btn-lg btn-primary shadow w-100 text-white text-decoration-none ">SUBMIT</button>
                                <div class="mt-3 text-center">
                                    <p class="d-inline align-middle">Already have an account?</p>
                                    <a class="text-center btn btn-sm btn-danger text-decoration-none fw-semibold text-white" href="login.php">Login here!</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- include welcome page -->
            <?php include('includes/WelcomePage.php'); ?>
        </div>
    </div>

</body>

</html>