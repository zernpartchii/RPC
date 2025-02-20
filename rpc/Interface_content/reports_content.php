<?php
// include('includes/dropdown.php') 
?>
<div class="card border-0 container-fluid py-3">
    <div class="card border-0 pt-0 pb-3">
        <div class="card-body ps-1 py-0">
            <p class="fs-2 font-monospace text-uppercase text-start border-bottom">Reports</p>
        </div>
        <div class="card-body py-0">
            <form method="POST">
                <div class="mb-3 row">
                    <label for="selectZone" class="col-md-3 form-label">Zone</label>
                    <div class="col-md-6">
                        <select class="form-select" id="selectZone" name="selectZone" onchange="my_fun(this.value)" required>
                            <option value="" selected hidden>-- Select Zone</option>
                            <?php
                            $sql = "SELECT * FROM `zone`";
                            $result1 = mysqli_query($con, $sql);
                            while ($row = $result1->fetch_assoc()) { ?>
                                <option value="<?php echo $row["id"]; ?>"><?php echo $row["Zone"]; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <script>
                    function my_fun(str) {
                        if (window.XMLHttpRequest) {
                            xmlhttp = new XMLHttpRequest();
                        } else {
                            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                        }

                        xmlhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                document.getElementById('program').innerHTML = this.responseText;
                            }
                        }
                        xmlhttp.open("GET", "includes/dropdown_reports.php?value=" + str, true);
                        xmlhttp.send();
                    }
                </script>
                <div id="program" class="mb-3 row">
                    <label for="selectProgram" class="col-md-3 form-label">Program</label>
                    <div class="col-md-6">
                        <select class="form-select" id="selectProgram" name="selectProgram" required>
                            <option value="" selected hidden>-- Select Program</option>
                            <?php include 'includes/dropdown_reports.php'; ?>
                            <option disabled>...</option>
                        </select>
                    </div>
                </div>
                <div id="SY" class="mb-3 row">
                    <label for="selectSY" class="col-md-3 form-label">School Year</label>
                    <div class="col-md-6">
                        <select class="form-select" id="selectSY" name="selectSY" required>
                            <option value="" selected hidden>-- Select School Year</option>
                            <?php
                            $sql = "SELECT DISTINCT(S_Y) FROM `research_information` ORDER BY S_Y DESC";
                            $result = mysqli_query($con, $sql);

                            while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                <option value="<?= $row['S_Y']; ?>"><?= $row['S_Y']; ?></option>
                            <?php
                            }
                            ?>
                            <option disabled>...</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="" class="col-md-3"></label>
                    <div class="col-md-6 d-flex justify-content-between">
                        <button type="submit" name="generateReport" class="btn btn-danger fw-semibold">
                            <i class="bi-cloud-download-fill"></i> Generate Reports</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="table-responsive">
        <table id="example1" class="table table-hover ">
            <!-- Start Table Head -->
            <thead>
                <tr class="align-middle">
                    <th>Group Number</th>
                    <th>Title</th>
                    <th>Proponents</th>
                    <th>Stat/DA</th>
                </tr>
            </thead>
            <!-- End Table Head -->

            <!-- Start Table Body -->
            <tbody class="align-middle">

                <!-- Start Php -->
                <?php

                if (isset($_POST['generateReport'])) {

                    $_SESSION["zone"] = $zone = $_POST['selectZone'];
                    $_SESSION["program"] = $program = $_POST['selectProgram'];
                    $_SESSION["sy"] = $schoolY = $_POST['selectSY'];
                    
                    $sql = "SELECT * FROM `research_information` WHERE zone='$zone' AND Program='$program' AND S_Y='$schoolY'";
                    $result = $con->query($sql);

                    if ($result->num_rows > 0) {

                        while ($row = $result->fetch_assoc()) {

                            $id = $row['id'];
                            $groupNumber = $row["Group_Number"];
                            $title = $row["Title"];
                            $stat_da = $row["Stat_DA"];


                            $sql = "SELECT * FROM `proponents` WHERE research_id = $id AND Proponents NOT IN('')";
                            $result1 = mysqli_query($con, $sql);

                            $proponents = array();
                            while ($row = $result1->fetch_assoc()) {
                                $proponents[] = $row['Proponents'];
                            }
                            $length = count($proponents);

                ?>

                            <tr>
                                <td><?php echo $groupNumber ?></td>
                                <td><?php echo $title ?></td>
                                <td>
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
                                <td><?php echo $stat_da ?></td>
                            </tr>

                        <?php

                        }
                        $_SESSION['status'] = "Showing reports from ( Zone - $zone | Program - $program | S.Y $schoolY )";

                        if (isset($_SESSION['status'])) { ?>

                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <strong>Hey!</strong> <?php echo $_SESSION['status']; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <a href="printReports.php?" name="printReport" class="btnprint btn btn-primary  fw-semibold">
                                <i class="bi-printer"></i> Print Reports</a>

                        <?php

                            unset($_SESSION['status']);
                        }
                    } else {
                        $_SESSION['status'] = "No data to show from ( Zone - $zone | Program - $program | S.Y $schoolY )";

                        if (isset($_SESSION['status'])) { ?>

                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Hey!</strong> <?php echo $_SESSION['status']; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>

                <?php

                            unset($_SESSION['status']);
                        }
                    }
                }


                ?>
                <!-- End Php  -->

            </tbody>
            <!-- End Table Body -->

        </table>
    </div>
</div>

<!-- include Java Script -->
<?php include('includes/jsFile.php') ?>