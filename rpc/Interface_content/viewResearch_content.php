<?php

$viewid = $_GET['viewid'];

$sql = "SELECT * FROM `research_information` WHERE id= $viewid";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

$group_number = $row['Group_Number'];
$zone = $row['Zone'];
$program = $row['Program'];
$title = $row['Title'];
$adviser = $row['Adviser'];
$stat = $row['Stat_DA'];
$sy = $row['S_Y'];

$sql = "SELECT * FROM `proponents` WHERE research_id = $viewid";
$result1 = mysqli_query($con, $sql);

$proponents = array();
while ($row = $result1->fetch_assoc()) {
    $proponents[] = $row['Proponents'];
}
$length = count($proponents);

?>

<div class="card p-3 border-0">
    <div class="">
        <p class="fs-2 font-monospace border-bottom">RESEARCH DETAILS</p>
    </div>
    <div class="card-body">
        <form class="">
            <div class="mb-3 row">
                <label for="view_group_no" class="col-md-3 form-label">Group Number</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="view_group_no" value="<?php echo $group_number; ?>" disabled>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="view_zone" class="col-md-3 form-label">Zone</label>
                <div class="col-md-9">
                    <select class="form-select" id="view_zone" name="view_zone" disabled>
                        <option disabled selected hidden><?php echo $zone; ?></option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="view_program" class="col-md-3 form-label">Program</label>
                <div class="col-md-9">
                    <select class="form-select" id="view_program" name="view_program" disabled>
                        <option disabled selected hidden><?php echo $program; ?></option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="view_title" class="col-md-3 form-label">Title</label>
                <div class="col-md-9">
                    <textarea id="view_title" cols="30" rows="3" class="form-control fw-normal" disabled><?php echo $title; ?>
                </textarea>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="view_proponent_1" class="col-md-3 form-label">Proponent/s</label>
                <div class="mb-3 col-md-9">
                    <input type="text" class="form-control" value="<?php echo $proponents[0]; ?>" name="view_proponent_1" disabled>
                </div>
                <label for="view_proponent_2" class="col-md-3 form-label"></label>
                <div class="mb-3 col-md-9">
                    <input type="text" class="form-control" value="<?php if ($length > 1) {
                                                                        echo $proponents[1];
                                                                    } ?>" name="view_proponent_2" disabled>
                </div>
                <label for="view_proponent_3" class="col-md-3 form-label"></label>
                <div class="col-md-9">
                    <input type="text" class="form-control" value="<?php if ($length > 2) {
                                                                        echo $proponents[2];
                                                                    } ?>" name="view_proponent_3" disabled>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="view_adviser" class="col-md-3 form-label">Adviser</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" value="<?php echo $adviser; ?>" name="view_adviser" disabled>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="view_stat" class="col-md-3 form-label">Stat/DA</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" value="<?php echo $stat; ?>" name="view_stat" disabled>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="view_SY" class="col-md-3 form-label">School Year</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" value="<?php echo $sy; ?>" name="view_SY" disabled>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <label for="" class="hidden-label"></label>
                <a href="updateResearch.php? updateid=<?php echo $viewid; ?>" class="w-25 btn btn-md btn-primary">
                    <i class="bi bi-pencil-square"></i> Edit</a>
                <a href="research.php" class="w-25 btn btn-md btn-danger">
                    <i class="bi-x-circle"></i> Cancel</a>
            </div>
        </form>
    </div>
</div>