<?php


$user_id = $_SESSION["id"];

$user_firstname = $_SESSION["firstname"];
$user_lastnme = $_SESSION["lastname"];
$email = $_SESSION["email"];
$password = '';
$confirm_password = '';

if (isset($_POST['save_btn'])) {

    // Validate firstname
    if (empty($_POST['edit_firstname'])) {
        $_SESSION['edit_firstname'] = "Please enter you firstname.";
        $_firstnameValidation = "is-invalid";
        $user_firstname = '';
    } else {
        $_firstnameValidation = "is-valid";
        $_updatedFirstname = $_POST['edit_firstname'];
    }

    // Validate lastname
    if (empty($_POST['edit_lastname'])) {
        $_SESSION['edit_lastname'] = "Please enter you lastname.";
        $_lastnameValidation = "is-invalid";
        $user_lastnme = '';
    } else {
        $_lastnameValidation = "is-valid";
        $_updatedLastname = $_POST['edit_lastname'];
    }

    // Validate email
    if (empty($_POST['edit_email'])) {
        $_SESSION['edit_email'] = "Please enter you email.";
        $_emailValidation = "is-invalid";
        $email = '';
    } else {
        $_emailValidation = "is-valid";
        $_updatedEmail = $_POST['edit_email'];
    }

    // Validate new password
    if (empty(trim($_POST['edit_new_password']))) {
        $_SESSION['edit_new_password'] = "Please enter your new password.";
        $validationPassword = "is-invalid";
    } else {

        if (strlen(trim($_POST["edit_new_password"])) < 6) {
            $_SESSION['edit_new_password'] = "Password must have atleast 6 characters.";
            $validationPassword = "is-invalid";
            $password = $_POST['edit_new_password'];
        } else {
            $validationPassword = "is-valid";
            $password = $_POST['edit_new_password'];
        }
    }

    // Validate confirm password
    if (empty(trim($_POST['edit_confirm_password']))) {
        $_SESSION['edit_confirm_password'] = "Please confirm your password.";
        $validationConfirmPassword = "is-invalid";
    } else {

        $validationConfirmPassword = "is-valid";
        $confirm_password = $_POST['edit_confirm_password'];

        if ($password != $confirm_password) {
            $_SESSION['edit_confirm_password'] = "Password did not match.";
            $validationConfirmPassword = "is-invalid";
        } else {

            $validationConfirmPassword = "is-valid";
            $confirm_password = $_POST['edit_confirm_password'];

            $user_password = password_hash($confirm_password, PASSWORD_DEFAULT);
            $sql = "CALL update_users_sp('$_updatedFirstname','$_updatedLastname','$_updatedEmail','$user_password',$user_id);";
            $result = mysqli_query($con, $sql);

            if ($result) {
                $_SESSION['success'] = "Your account was updated successfully!";
                // header("location: profile.php");
            } else {
                $_SESSION['status'] = "Oops! Something went wrong. Please try again later.";
            }
        }
    }
};

?>

<div class="container-fluid row d-flex justify-content-center mt-3 pt-3">
    <div class="card border-0 pt-4 mb-3 shadow bg-body w-75">
        <?php
        if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
                <?php echo $_SESSION['success']; ?>
            </div>
        <?php
            unset($_SESSION['success']);
        }
        ?>
        <p class="fs-2 font-monospace ms-3 border-bottom">Edit Profile</p>
        <div class="card-body">
            <h4>User Information</h2>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3 row">
                    <label for="edit_firstname" class="col-md-3 form-label">Firstname</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control <?php echo $_firstnameValidation; ?>" id="edit_firstname" value="<?php echo $user_firstname; ?>" name="edit_firstname">
                        <?php
                        if (isset($_SESSION['edit_firstname'])) { ?>
                            <div class="text-danger alert-dismissible fade show h6" style="font-size: 13px;" role="alert">
                                <?php echo $_SESSION['edit_firstname']; ?>
                            </div>
                        <?php
                            unset($_SESSION['edit_firstname']);
                        }
                        ?>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="edit_lastname" class="col-md-3 form-label">Lastname</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control <?php echo $_lastnameValidation; ?>" id="edit_lastname" value="<?php echo $user_lastnme; ?>" name="edit_lastname">
                        <?php
                        if (isset($_SESSION['edit_lastname'])) { ?>
                            <div class="text-danger alert-dismissible fade show h6" style="font-size: 13px;" role="alert">
                                <?php echo $_SESSION['edit_lastname']; ?>
                            </div>
                        <?php
                            unset($_SESSION['edit_lastname']);
                        }
                        ?>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="edit_email" class="col-md-3 form-label">Email</label>
                    <div class="col-md-9">
                        <input type="email" class="form-control <?php echo $_emailValidation; ?>" id="edit_email" value="<?php echo $email; ?>" name="edit_email">
                        <?php
                        if (isset($_SESSION['edit_email'])) { ?>
                            <div class="text-danger alert-dismissible fade show h6" style="font-size: 13px;" role="alert">
                                <?php echo $_SESSION['edit_email']; ?>
                            </div>
                        <?php
                            unset($_SESSION['edit_email']);
                        }
                        ?>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="edit_new_password" class="col-md-3 form-label">New Password</label>
                    <div class="col-md-9">
                        <input type="password" class="form-control <?php echo $validationPassword; ?>" id="edit_new_password" value="<?php echo $password; ?>" name="edit_new_password">
                        <?php
                        if (isset($_SESSION['edit_new_password'])) { ?>
                            <div class="text-danger alert-dismissible fade show h6" style="font-size: 13px;" role="alert">
                                <?php echo $_SESSION['edit_new_password']; ?>
                            </div>
                        <?php
                            unset($_SESSION['edit_new_password']);
                        }
                        ?>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="edit_confirm_password" class="col-md-3 form-label">Confirm Password</label>
                    <div class="col-md-9">
                        <input type="password" class="form-control <?php echo $validationConfirmPassword; ?>" id="edit_confirm_password" value="<?php echo $confirm_password; ?>" name="edit_confirm_password">
                        <?php
                        if (isset($_SESSION['edit_confirm_password'])) { ?>
                            <div class="text-danger alert-dismissible fade show h6" style="font-size: 13px;" role="alert">
                                <?php echo $_SESSION['edit_confirm_password']; ?>
                            </div>
                        <?php
                            unset($_SESSION['edit_confirm_password']);
                        }
                        ?>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-3 form-label"></label>
                    <div class="col-md-4 mb-1">
                        <button type="submit" name="save_btn" class="form-control bg-primary text-white text-center fw-semibold text-decoration-none"><i class="bi-save"></i> Save</button>
                    </div>
                    <div class="col-md-4 mb-1">
                        <a href="profile.php" class="form-control bg-danger text-white text-center fw-semibold text-decoration-none"> <i class="bi bi-x-circle"></i> Close</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>