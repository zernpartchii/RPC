<!-- Start Table Data -->
<?php
if (isset($_POST['deleteResearch'])) {

    $id = $_POST['delete_id'];

    $sql = "CALL delete_research_sp($id)";
    $result = mysqli_query($con, $sql);

    if ($result) {
        $_SESSION['status'] = "The data was deleted successfully!";
    } else {
        $_SESSION['error'] = "The data was not deleted!";
        die(mysqli_error($con));
    }
}
?>
<div class="card border-0">
    <div class="card-body">
        <form action="deleteResearch.php" method="POST">
            <div class="mb-3">
                <p class="fs-2 font-monospace border-bottom">MANAGE RESEARCH</p>
                <a href="addResearch.php" class="mt-1 btn btn-md btn-primary" style="width: 120px;">
                    <i class="bi bi-plus-circle"></i> New</a>
                <button type="submit" id="btn" name="deleteAll_btn" style="width: 120px;" class="mt-1 btn btn-md btn-danger"><i class="bi-trash"></i> Delete</button>
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
            <div class="table-responsive">
                <table id="example" class="table table-hover">
                    <!-- Start Table Head -->
                    <thead>
                        <tr class="align-middle">
                            <th></th>
                            <th>ID</th>
                            <th>Group Number</th>
                            <th>Zone</th>
                            <th>Program</th>
                            <th>Title</th>
                            <th>Proponents</th>
                            <th>Adviser</th>
                            <th>Stat/DA</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <!-- End Table Head -->

                    <!-- Start Table Body -->
                    <tbody class="align-middle">

                        <!-- Start Php -->
                        <?php

                        // include 'config.php';
                        $sql = "SELECT * FROM `research_information` ORDER BY id DESC";
                        $result = mysqli_query($con, $sql);

                        if ($result->num_rows > 0) {

                            while ($row = $result->fetch_assoc()) {

                                $id = $row["id"];
                                $groupNumber = $row["Group_Number"];
                                $zone = $row["Zone"];
                                $program = $row["Program"];
                                $title = $row["Title"];
                                $adviser = $row["Adviser"];
                                $stat_da = $row["Stat_DA"];

                                $sql = "SELECT * FROM `proponents` WHERE research_id = $id AND Proponents NOT IN('');";
                                $result1 = mysqli_query($con, $sql);

                                $proponents = array();
                                while ($row = $result1->fetch_assoc()) {
                                    $proponents[] = $row['Proponents'];
                                }
                                $length = count($proponents);
                        ?>

                                <tr>
                                    <td>
                                        <input type="checkbox" name="deleteAll_id[]" class="check_all_id" value="<?php echo $id; ?>">
                                    </td>
        </form>
        <td><?php echo $id; ?></td>
        <td class=" text-truncate" style="max-width: 100px;"><?php echo $groupNumber; ?></td>
        <td class=" text-truncate" style="max-width: 100px;"><?php echo $zone; ?></td>
        <td class=" text-truncate" style="max-width: 100px;"><?php echo $program; ?></td>
        <td class=" text-truncate" style="max-width: 100px;"><?php echo $title; ?></td>
        <td class=" text-truncate" style="max-width: 100px;">
            <?php
                                if ($length == 1) {
                                    echo $proponents[0];
                                } else if ($length == 2) {
                                    echo $proponents[0] . ', ' . $proponents[1];
                                } else {
                                    echo $proponents[0] . ', ' . $proponents[1] . ', ' . $proponents[2];
                                }
            ?>
        </td>
        <td class=" text-truncate" style="max-width: 100px;"><?php echo $adviser; ?></td>
        <td class=" text-truncate" style="max-width: 100px;"><?php echo $stat_da; ?></td>
        <td>
            <div class="d-flex">

                <a href="viewResearch.php? viewid='<?php echo $id; ?>'" class="btn btn-md text-success btn-link mx-1">
                    <i class="bi-eye-fill"></i></a>

                <a href="updateResearch.php? updateid='<?php echo $id; ?>'" class="btn btn-md text-primary btn-link mx-1">
                    <i class="bi-pencil-fill"></i></a>

                <a class="btn btn-md text-danger btn-link delete_btn mx-1"><i class="bi-trash-fill"></i></a>

            </div>
        </td>
        </tr>

    <?php

                            }
                        } else {
                            $_SESSION['status'] = "No data available in table.";

                            if (isset($_SESSION['status'])) { ?>

        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Hey!</strong> <?php echo $_SESSION['status']; ?>
        </div>

<?php
                                unset($_SESSION['status']);
                            }
                        }


?>
<!-- End Php  -->

</tbody>
<!-- End Table Body -->
<tfoot>
    <tr class="align-middle">
        <th></th>
        <th>ID</th>
        <th>Group Number</th>
        <th>Zone</th>
        <th>Program</th>
        <th>Title</th>
        <th>Proponents</th>
        <th>Adviser</th>
        <th>Stat/DA</th>
        <th>Actions</th>
    </tr>
</tfoot>

</table>
    </div>
</div>
</div>
<!-- End Table Data -->

<!-- Start Delete Modal -->
<div class="modal fade" id="deleteResearchModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-dark">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Research</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="research.php" method="POST">
                <div class="modal-body">
                    <p class="fs-5">Are you sure you want to delete this record?</p>
                    <div class="d-flex align-items-center fs-5 h6">
                        <input type="hidden" class="border-0" name="delete_id" id="delete_id">
                        Record ID: <input type="text" class="form-control w-25 ms-3" name="delete_id1" id="delete_id1" disabled>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="deleteResearch" class="btn btn-primary w-25">Yes</button>
                    <button type="button" class="btn btn-danger w-25" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Delete Modal -->


<!-- include Java Script -->
<?php include('includes/jsFile.php') ?>