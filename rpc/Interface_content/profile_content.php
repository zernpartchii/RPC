<?php

$user_id = $_SESSION["id"];
$user_pass = $_SESSION["user_password"];
$sql = "SELECT * FROM `users_information` WHERE id = $user_id";

$result = mysqli_query($con, $sql);
if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {

        $_SESSION["firstname"] =  $firstname = $row['first_name'];
        $_SESSION['lastname'] = $lastname = $row['last_name'];
        $_SESSION['email'] = $email = $row['email'];

    }
}; ?>

<div class="container-fluid row d-flex justify-content-center mt-3 pt-3">
    <div class="card border-0 mb-3 shadow bg-body w-75">
        <?php
        if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
                <?php echo $_SESSION['success']; ?>
            </div>
        <?php
            unset($_SESSION['success']);
        }
        ?>
        <p class="fs-2 font-monospace mt-4 ms-3 border-bottom">Profile</p>
        <div class="card-body">
            <h4>User Information</h2>
        </div>
        <div class="card-body">
            <form action="">
                <div class="mb-3 row">
                    <label for="firstname" class="col-md-3 form-label">Firstname</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="firstname" value="<?php echo $firstname; ?>" name="firstname" disabled>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="lastname" class="col-md-3 form-label">Lastname</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="lastname" value="<?php echo $lastname; ?>" name="lastname" disabled>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="email" class="col-md-3 form-label">Email</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="email" value="<?php echo $email; ?>" name="email" disabled>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="password" class="col-md-3 form-label">Password</label>
                    <div class="col-md-9">
                        <input type="password" class="form-control" id="password" value="<?php echo $user_pass; ?>" name="password" disabled>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="password" class="col-md-3 orm-label"></label>
                    <div class="col-md-4 mb-1">
                        <a href="editProfile.php" class="form-control bg-primary text-white text-center fw-semibold text-decoration-none"><i class="bi bi-pencil-square"></i> Edit</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>