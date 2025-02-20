<?php

$updateid = $_GET['updateid'];

$sql = "SELECT * FROM research_information r JOIN Zone z ON r.Zone = z.id WHERE r.id= $updateid";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

$group_number = $row['Group_Number'];
$zone = $row['Zone'];
$program = $row['Program'];
$title = $row['Title'];
$adviser = $row['Adviser'];
$stat = $row['Stat_DA'];
$sy =  $row['S_Y'];

$sql = "SELECT * FROM `proponents` WHERE research_id = $updateid";
$result = mysqli_query($con, $sql);

$proponents = array();
$proponentsID = array();
while ($row = $result->fetch_assoc()) {
    $proponents[] = $row['Proponents'];
    $proponentsID[] = $row['id'];
}

$length = count($proponents);

$proponent1 =  $proponents[0];

if ($length > 1) {
    $proponent2 =  $proponents[1];
}

if ($length > 2) {
    $proponent3 =  $proponents[2];
}

?>


<?php

if (isset($_POST['updateResearch'])) {

    $group_number = $_POST['update_group_no'];
    $zone = $_POST['update_zone'];
    $program = $_POST['update_program'];
    $title = $_POST['update_title'];
    $adviser = $_POST['update_adviser'];
    $stat = $_POST['update_stat'];

    $str =  $_POST['update_SY'];
    $SY = str_replace(' ', '', $str);

    $proponent1 = $_POST['update_proponent_1'];
    $proponent2 = $_POST['update_proponent_2'];
    $proponent3 = $_POST['update_proponent_3'];

    $proponent1_id = $proponentsID[0];
    $sql = "CALL update_proponents_sp('$proponent1',$proponent1_id);";
    mysqli_query($con, $sql);

    $proponent2_id = $proponentsID[1];
    $sql = "CALL update_proponents_sp('$proponent2',$proponent2_id);";
    mysqli_query($con, $sql);

    $proponent3_id = $proponentsID[2];
    $sql = "CALL update_proponents_sp('$proponent3',$proponent3_id);";
    mysqli_query($con, $sql);

    $sql = "CALL update_research_sp('$group_number','$zone','$program','$title','$adviser','$stat', '$SY', $updateid);";
    $result = mysqli_query($con, $sql);

    if ($result) {
        $_SESSION['status'] = "The data was updated successfully!";
        header("location:research.php");
        exit;
    } else {
        $_SESSION['error'] = "Opss! Something went wrong.";
        header("location:research.php");
        exit;
    }
}

?>

<div class="card p-3 border-0">
    <form method="POST">
        <div class="">
            <p class="fs-2 font-monospace border-bottom">UPDATE RESEARCH</p>
        </div>
        <div class="card-body">
            <div class="mb-3 row">
                <label for="update_group_no" class="col-md-3 form-label">Group Number</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="update_group_no" value="<?php echo $group_number; ?>" required placeholder="-- Enter group number" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="update_zone" class="col-md-3 form-label">Zone</label>
                <div class="col-md-9">
                    <select class="form-select" id="update_zone" name="update_zone" onchange="my_fun(this.value)" required>
                        <?php
                        $sql = "SELECT * FROM `zone` WHERE Zone = '$zone'";
                        $result1 = mysqli_query($con, $sql);
                        while ($row = $result1->fetch_assoc()) { ?>
                            <option selected hidden value="<?php echo $row["id"]; ?>">
                                <?php echo $row["Zone"]; ?></option>
                        <?php } ?>
                        <?php
                        $sql = "SELECT * FROM `zone`";
                        $result1 = mysqli_query($con, $sql);
                        while ($row = $result1->fetch_assoc()) { ?>
                            <option value="<?php echo $row["id"]; ?>">
                                <?php echo $row["Zone"]; ?></option>
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
                    xmlhttp.open("GET", "includes/dropdown_updateResearch.php?value=" + str, true);
                    xmlhttp.send();
                }
            </script>
            <div id="program" class="mb-3 row">
                <label for="update_program" class="col-md-3 form-label">Program</label>
                <div class="col-md-9">
                    <select class="form-select" id="update_program" name="update_program">
                        <option value="<?php echo $program; ?>" selected hidden><?php echo $program; ?></option>
                        <?php
                        $sql = "SELECT * FROM program p JOIN zone z ON p.Zone_id = z.id WHERE z.Zone = '$zone'";
                        $result = mysqli_query($con, $sql);
                        while ($row = $result->fetch_assoc()) { ?>
                            <option value="<?php echo $row["Course_Program"]; ?>"><?php echo $row["Course_Program"]; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="update_title" class="col-md-3 form-label">Title</label>
                <div class="col-md-9">
                    <textarea name="update_title" cols="30" rows="3" required placeholder="-- Enter research title" class="form-control fw-normal"><?php echo $title; ?></textarea>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="update_proponent_1" class="col-md-3 form-label">Proponent/s</label>
                <div class="mb-3 col-md-9">
                    <input type="text" class="form-control" placeholder="-- Enter proponent" required value="<?php echo $proponent1; ?>" name="update_proponent_1">
                </div>
                <label for="update_proponent_2" class="col-md-3 form-label"></label>
                <div class="mb-3 col-md-9">
                    <input type="text" class="form-control" placeholder="-- Enter proponent" value="<?php echo $proponent2; ?>" name="update_proponent_2">
                </div>
                <label for="update_proponent_3" class="col-md-3 form-label"></label>
                <div class="col-md-9">
                    <input type="text" class="form-control" placeholder="-- Enter proponent" value="<?php echo $proponent3; ?>" name="update_proponent_3">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="update_adviser" class="col-md-3 form-label">Adviser</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" placeholder="-- Enter adviser" value="<?php echo $adviser; ?>" name="update_adviser" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="update_stat" class="col-md-3 form-label">Stat/DA</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" placeholder="-- Enter stat/da" value="<?php echo $stat; ?>" name="update_stat" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="update_SY" class="col-md-3 form-label">School Year</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" value="<?php echo $sy; ?>" name="update_SY">
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <label for="" class="hidden-label"></label>
                <button type="submit" name="updateResearch" class="w-25 btn btn-md btn-primary"><i class="bi-pencil-fill"></i> Update</button>
                <a href="research.php" class="w-25 btn btn-md btn-danger">
                    <i class="bi-x-circle"></i> Cancel</a>
            </div>
    </form>
</div>
</div>