<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php
    include('includes/header.php');
    session_start();
    ?>

    <!-- title -->
    <title>RESEARCH AND PUBLICATION CENTER</title>
</head>

<body>
    <style media="print">
        @media print {
            .printbtn {
                display: none;
            }
        }
    </style>
    <div class="container py-4">
        <div class="printbtn mb-5">
            <button onclick="window.print()" name="printReport" class="me-1 btn btn-primary  fw-semibold">
                <i class="bi-printer"></i> Print</button>
            <a href="reports.php" name="printReport" class="me-1 btn btn-danger  fw-semibold">
                <i class="bi-x-circle"></i> Cancel</a>
        </div>
        <div class="row">
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <img src="img/favicon.png" width="80">
                </div>
                <div class="text-end">
                    <h6 class="m-0">RESEARCH AND PUBLICATION CENTER</h6>
                    <p>UM Tagum College <br>
                        Mabini Street, Davao Del Norte Tagum City <br>
                        Telefax # (084) 655-9593
                    </p>
                </div>
            </div>
            <div class="text-center mb-3">
                <h6>INVENTORY OF HARDBOUND</h6>
                <p class="h6"><?php echo $_SESSION['program']; ?> - S.Y. <?= $_SESSION['sy']; ?> </p>
            </div>
            <div class="table-responsive">
                <table class="text-center table table-bordered border-black">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title of Thesis</th>
                            <th>Proponents</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-center align-middle">

                        <!-- Start Php -->
                        <?php
                        $zone = $_SESSION["zone"];
                        $program = $_SESSION['program'];
                        $sy = $_SESSION["sy"];

                        $sql = "SELECT * FROM `users_information` u join research_information r on u.zone=r.zone WHERE r.zone='$zone' AND r.Program='$program' AND r.S_Y='$sy'";
                        $result = $con->query($sql);

                        if ($result->num_rows > 0) {

                            $num = 0;
                            while ($row = $result->fetch_assoc()) {

                                $num += 1;
                                $id = $row['id'];
                                $zone = $row['Zone'];
                                $groupNumber = $row["Group_Number"];
                                $title = $row["Title"];
                                $adviser = $row['Adviser'];
                                $stat_da = $row["Stat_DA"];
                                $researchAssociate = $row['first_name'] . ' ' . $row['last_name'];

                                $sql = "SELECT * FROM `proponents` WHERE research_id = $id";
                                $result1 = mysqli_query($con, $sql);

                        ?>

                                <tr>
                                    <td class="col-1"><?php echo $num ?></td>
                                    <td class="col-3"><?php echo $title ?></td>
                                    <td class="col-3 p-0">
                                        <?php
                                        while ($row = $result1->fetch_assoc()) {
                                            if (!$row['Proponents'] == '') {
                                                echo '<p class="m-0 py-1 border-black border-bottom">' . $row['Proponents'] . '</p>';
                                            } else {
                                                echo '<p class="m-0 py-1 border-black 
                                                border-bottom empty text-white">?</p>';
                                            }
                                        }
                                        echo '<p class="m-0 py-1">' . $adviser . '</p>';
                                        ?>
                                    </td>
                                    <td class="col-3 p-0">
                                        <?php
                                        echo '<p class="m-0 py-1"> (1) Hardbound </p>';
                                        for ($i = 1; $i < 4; $i++) {
                                            if ($i == 2) {
                                                echo '<hr>';
                                            }
                                        }
                                        echo '<p class="m-0 py-1"> (2) CD </p>';
                                        ?>
                                    </td>
                                </tr>

                            <?php

                            }
                        } else {
                            ?>
                            <div class="alert alert-warning alert-dismissible fade show mt-4" role="alert">
                                <?php echo "No Reports to show because no Research Associator in Zone - $zone"; ?>
                            </div>
                        <?php
                            $researchAssociate = "N/A";
                        }
                        ?>
                        <!-- End Php  -->

                    </tbody>
                </table>
            </div>

            <?php
            $sql = "SELECT CONCAT(first_name,' ' , last_name) AS 'Full Name' FROM `users_information` WHERE type='Research Coordinator' LIMIT 1";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($result);

            if ($result->num_rows > 0) {
                $researchCoordinator = $row['Full Name'];
            } else {
                ?>
                    <div class="alert alert-warning alert-dismissible fade show mt-4" role="alert">
                        <?php echo "No Research Coordinator"; ?>
                    </div>
                <?php
                $researchCoordinator = "N/A";
            }
            ?>

            <div class="d-flex justify-content-between">
                <div class="">
                    <p>Prepared by:</p>
                    <h6><?php echo $researchAssociate ?></h6>
                    <p>RESEARCH ASSOCIATE - ZONE <?php echo $zone ?></>
                    <p></p>
                </div>
                <div class="">
                    <p>Reviewed by:</p>
                    <h6><?php echo $researchCoordinator ?></h6>
                    <p>RESEARCH COORDINATOR</p>
                </div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
</body>

</html>