<!-- include dropdown  -->
<?php include('includes/dropdown_Settings.php') ?>

<?php

// Add Zone
if (isset($_POST['addZone_btn'])) {

    $zoneDepartment = $_POST['addZoneDepartment'];
    $sql = "INSERT INTO zone(Zone) VALUES('$zoneDepartment')";
    $result = mysqli_query($con, $sql);

    if ($result) {
        $_SESSION['status'] = "The $zoneDepartment was inserted successfully!";
        header('location: settings.php');
        exit;
    } else {
        $_SESSION['error'] = 'Something went wrong';
        header('location: settings.php');
        exit;
    }
}

// Update Zone
if (isset($_POST['UpdateZone_btn'])) {

    $id = $_POST['update_Zone_id'];
    $zoneDepartment = $_POST['UpdateDepartment'];

    $sql = "UPDATE zone SET Zone='$zoneDepartment' WHERE id = $id";
    $result = mysqli_query($con, $sql);

    if ($result) {
        $_SESSION['status'] = "The $zoneDepartment was updated successfully!";
        header('location: settings.php');
        exit;
    } else {
        $_SESSION['error'] = 'Something went wrong';
        header('location: settings.php');
        exit;
    }
}

// Add Program
if (isset($_POST['addProgram_btn'])) {

    $zone_id = $_POST['addZone'];
    $program = $_POST['addProgram'];

    for ($i = 0; $i < strlen($program); $i++) {
        if (ctype_upper($program[$i])) {
            $initials .= $program[$i];
        }
    }

    $sql = "INSERT INTO program(Zone_id, Initials, Course_Program) VALUES($zone_id,'$initials','$program')";
    $result = mysqli_query($con, $sql);

    if ($result) {
        $_SESSION['status'] = "The Program $program was inserted successfully!";
        header('location: settings.php');
        exit;
    } else {
        $_SESSION['error'] = 'Something went wrong';
        header('location: settings.php');
        exit;
    }
}

// Update Program
if (isset($_POST['UpdateProgram_btn'])) {

    $id = $_POST['update_Program_id'];
    $zone_id = $_POST['updateZone'];
    $program = $_POST['UpdateProgram'];

    $sql = "UPDATE program SET Zone_id= $zone_id, Course_Program='$program' WHERE id = $id";
    $result = mysqli_query($con, $sql);

    if ($result) {
        $_SESSION['status'] = "The Program $program was updated successfully!";
        header('location: settings.php');
        exit;
    } else {
        $_SESSION['error'] = 'Something went wrong';
        header('location: settings.php');
        exit;
    }
}

// <!-- Delete Zone  -->
if (isset($_POST['deleteZone'])) {

    $id = $_POST['delete_Zone_id'];
    $deleteZone = $_POST['delete_Zone'];

    $sql = "CALL deleteZone_sp($id)";
    $result = mysqli_query($con, $sql);

    if ($result) {
        $_SESSION['status'] = "The $deleteZone was deleted successfully!";
        header('location: settings.php');
        exit;
    } else {
        $_SESSION['error'] = "The record was not deleted!";
        header('location: settings.php');
        exit;
    }
}

// <!-- Delete Program  -->
if (isset($_POST['deleteProgram'])) {

    $id = $_POST['delete_Program_id'];
    $deleteprogram = $_POST['delete_Program'];

    $sql = "CALL deleteProgram_sp($id)";
    $result = mysqli_query($con, $sql);

    if ($result) {
        $_SESSION['status'] = "The Program: $deleteprogram was deleted successfully!";
        header("location:settings.php");
        exit;
    } else {
        $_SESSION['error'] = "The record was not deleted!";
        header('location: settings.php');
        exit;
    }
}

?>

<div class="container-fluid m-0 py-3">
    <div class="d-flex align-items-center border-bottom mb-3">
        <p class="fs-2 font-monospace my-0 text-uppercase text-start">Settings</p>
    </div>
    <?php
    if (isset($_SESSION['status'])) { ?>

    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong>Hey!</strong> <?php echo $_SESSION['status']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <?php

        unset($_SESSION['status']);
    }
    ?>
    <?php
    if (isset($_SESSION['error'])) { ?>

    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Hey!</strong> <?php echo $_SESSION['error']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <?php

        unset($_SESSION['error']);
    }
    ?>

    <div class="container-fluid pb-3">
        <div class="col-md-12 row">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                        aria-selected="true">ALL USERS</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                        aria-selected="false">MANAGE ZONE</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact"
                        aria-selected="false">MANAGE PROGRAM</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                    tabindex="0">
                    <div class="col-md-12 mb-4">
                        <p class="fs-4 font-monospace text-center bg-secondary-subtle rounded text-black">ALL USERS</p>
                        <!-- <a class="btn btn-md bg-primary addZone_btn text-white mx-1">
                    <i class="bi-plus-circle"></i> Add USer</a> -->
                        <div class="table-responsive">
                            <table id="example2" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Fullname</th>
                                        <th scope="col">User Type</th>
                                        <th scope="col">Zone</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    <?php
                                    $sql = "SELECT id, CONCAT(first_name,' ',last_name) AS 'Fullname', type, zone FROM `users_information`;";
                                    $result = mysqli_query($con, $sql);
                                    while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $row["id"]; ?></td>
                                        <td><?php echo $row["Fullname"]; ?></td>
                                        <td><?php echo $row["type"]; ?></td>
                                        <td><?php echo $row["zone"]; ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <!-- <tfoot>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Fullname</th>
                                <th scope="col">User Type</th>
                            </tr>
                        </tfoot> -->
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
                    tabindex="0">
                    <div class="col-md-12 mb-4">
                        <p class="fs-4 font-monospace text-center bg-secondary-subtle rounded text-black">MANAGE ZONE
                        </p>
                        <a class="btn btn-md bg-primary addZone_btn text-white mx-1">
                            <i class="bi-plus-circle"></i> Add Zone</a>
                        <div class="table-responsive">
                            <table id="example2" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Zone</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    <?php
                                    while ($row = $result1->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $row["id"]; ?></td>
                                        <td><?php echo $row["Zone"]; ?></td>
                                        <td>
                                            <a class="btn btn-md text-primary btn-link updateZone_btn mx-1"><i
                                                    class="bi-pencil-fill"></i></a>
                                            <a class="btn btn-md text-danger btn-link deleteZone_btn mx-1"><i
                                                    class="bi-trash-fill"></i></a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <!-- <tfoot>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Zone</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </tfoot> -->
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab"
                    tabindex="0">
                    <div class="col-md-12">
                        <p class="fs-4 font-monospace text-center bg-secondary-subtle rounded text-black">MANAGE PROGRAM
                        </p>
                        <a class="btn btn-md bg-primary addProgram_btn text-white add_btn mx-1">
                            <i class="bi-plus-circle"></i> Add Program</a>
                        <div class="table-responsive">
                            <table id="example3" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Zone_ID</th>
                                        <th scope="col">Initials</th>
                                        <th scope="col">Program</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    <?php
                                    $sql = "SELECT p.id, p.Zone_id, p.Initials, p.Course_Program 
                            FROM program p JOIN zone z ON z.id=p.Zone_id";
                                    $result = mysqli_query($con, $sql);
                                    while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $row["id"]; ?></td>
                                        <td><?php echo $row["Zone_id"]; ?></td>
                                        <td><?php echo $row["Initials"]; ?></td>
                                        <td><?php echo $row["Course_Program"]; ?></td>
                                        <td>
                                            <a class="btn btn-md text-primary btn-link updateProgram_btn mx-1"><i
                                                    class="bi-pencil-fill"></i></a>
                                            <a class="btn btn-md text-danger btn-link deleteProgram_btn mx-1"><i
                                                    class="bi-trash-fill"></i></a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Zone_ID</th>
                                        <th scope="col">Initials</th>
                                        <th scope="col">Program</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Start Add Zone Modal -->
<div class="modal fade" id="AddZoneModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-center">
        <div class="modal-content text-dark">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Zone - Department</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="card border-0">
                        <div class="card-body">
                            <h3 style="font-size: 20px;">Zone - Department</h3>
                            <input type="text" class="form-control" id="addZoneDepartment" name="addZoneDepartment"
                                required placeholder="-- Enter zone - department">
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button type="submit" name="addZone_btn" class="btn btn-primary w-25">Add</button>
                    <button type="button" class="btn btn-danger w-25" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<!-- End Add Zone Modal -->

<!-- Start Update Zone Modal -->
<div class="modal fade" id="UpdateZoneModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-center">
        <div class="modal-content text-dark">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Update Zone - Department</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="card border-0">
                        <div class="card-body">
                            <h3 style="font-size: 20px;">Zone - Department</h3>
                            <input type="hidden" class="border-0" name="update_Zone_id" id="update_Zone_id">
                            <input type="text" class="form-control" id="UpdateDepartment" name="UpdateDepartment"
                                required placeholder="-- Enter Zone Department">
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button type="submit" name="UpdateZone_btn" class="btn btn-primary w-25">Update</button>
                    <button type="button" class="btn btn-danger w-25" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<!-- End Update Zone Modal -->

<!-- Start Delete Zone Modal -->
<div class="modal fade" id="deleteZoneModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-dark">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Zone - Department</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <p class="fs-5">Are you sure you want to delete this record?</p>
                    <input type="hidden" class="border-0" name="delete_Zone_id" id="delete_Zone_id">
                    <input type="hidden" class="form-control" id="delete_Zone" name="delete_Zone">
                    <input type="text" class="form-control border-warning" id="delete_Zone1" name="delete_Zone1"
                        disabled>
                    <!-- <h4><input type="text" class="border-0 w-100" name="delete_Zone" id="delete_Zone"></h4> -->
                </div>
                <div class="modal-footer">
                    <button type="submit" name="deleteZone" class="btn btn-primary w-25">Yes</button>
                    <button type="button" class="btn btn-danger w-25" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Delete Zone Modal -->

<!-- Start Add Program Modal -->
<div class="modal fade" id="AddProgramModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-center">
        <div class="modal-content text-dark">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Program</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="mb-3 row">
                                <label for="addZone" class="col-md-3 form-label">Zone</label>
                                <div class="col-md-9">
                                    <select class="form-select" id="addZone" name="addZone" required>
                                        <option value="" disabled selected hidden>-- Select Zone</option>
                                        <?php
                                        $sql = "SELECT * FROM `zone` ORDER BY Zone ASC";
                                        $result1 = mysqli_query($con, $sql);
                                        while ($row = $result1->fetch_assoc()) { ?>
                                        <option value="<?php echo $row["id"]; ?>"><?php echo $row["Zone"]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <h3 style="font-size: 20px;">Program</h3>
                            <textarea type="text" class="rounded ps-2 border-0 bg-light w-100" name="addProgram"
                                required placeholder="-- Enter Program" id="addProgram"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button type="submit" name="addProgram_btn" class="btn btn-primary w-25">Add</button>
                    <button type="button" class="btn btn-danger w-25" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<!-- End Add Program Modal -->

<!-- Start Update Program Modal -->
<div class="modal fade" id="UpdateProgramModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-center">
        <div class="modal-content text-dark">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Update Program</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="mb-3 row">
                                <label for="updateZone" class="col-md-3 form-label">Zone</label>
                                <div class="col-md-9">
                                    <select class="form-select" id="updateZone" name="updateZone" required>
                                        <?php
                                        $sql = "SELECT * FROM `zone` z JOIN program p ON z.id=p.Zone_id ORDER BY Zone ASC";
                                        $result1 = mysqli_query($con, $sql);
                                        while ($row = $result1->fetch_assoc()) { ?>
                                        <option selected hidden value="<?php echo $row["id"]; ?>">
                                            <?php echo $row["Zone"]; ?></option>
                                        <?php } ?>
                                        <?php
                                        $sql = "SELECT * FROM `zone` ORDER BY Zone ASC";
                                        $result1 = mysqli_query($con, $sql);
                                        while ($row = $result1->fetch_assoc()) { ?>
                                        <option value="<?php echo $row["id"]; ?>"><?php echo $row["Zone"]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <h3 style="font-size: 20px;">Program</h3>
                            <input type="hidden" class="border-0" name="update_Program_id" id="update_Program_id">
                            <textarea type="text" class="rounded ps-2 border-0 bg-light w-100" name="UpdateProgram"
                                placeholder="-- Enter Program" id="UpdateProgram"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button type="submit" name="UpdateProgram_btn" class="btn btn-primary w-25">Update</button>
                    <button type="button" class="btn btn-danger w-25" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<!-- End Update Program Modal -->

<!-- Start Delete Program Modal -->
<div class="modal fade" id="deleteProgramModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-dark">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Program</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <p class="fs-5">Are you sure you want to delete this Program?</p>
                    <input type="hidden" class="border-0" name="delete_Program_id" id="delete_Program_id">
                    <input type="hidden" class="rounded ps-2 border-0 bg-light w-100" name="delete_Program"
                        id="delete_Program"></input>
                    <textarea type="text" class="rounded ps-2 bg-light w-100 h6 border-warning" name="delete_Program1"
                        id="delete_Program1" disabled></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="deleteProgram" class="btn btn-primary w-25">Yes</button>
                    <button type="button" class="btn btn-danger w-25" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Delete Program Modal -->


<!-- include Java Script -->
<?php include('includes/jsFile.php') ?>