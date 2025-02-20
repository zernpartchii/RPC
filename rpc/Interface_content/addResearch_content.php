<!-- Add Research function -->
<?php

if (isset($_POST['addResearch'])) {

    $addGroupNo = $_POST['addGroupNo'];
    $addZone = $_POST['addZone'];
    $addProgram = $_POST['addProgram'];
    $addTitle = $_POST['addTitle'];
    $proponent1 = $_POST['proponent1'];
    $proponent2 = $_POST['proponent2'];
    $proponent3 = $_POST['proponent3'];
    $addAdviser = $_POST['addAdviser'];
    $addStat = $_POST['addStat'];

    $str =  $_POST['AddSY'];
    $sy = str_replace(' ', '', $str);

    $sql = "CALL insert_research_sp('$addGroupNo', '$addZone',
    '$addProgram', '$addTitle','$addAdviser', '$addStat', '$sy')";

    $result = mysqli_query($con, $sql);

    $sql = "CALL insert_proponents_sp('$proponent1')";
    mysqli_query($con, $sql);


    $sql = "CALL insert_proponents_sp('$proponent2')";
    mysqli_query($con, $sql);


    $sql = "CALL insert_proponents_sp('$proponent3')";
    mysqli_query($con, $sql);

    if ($result) {
        $_SESSION['status'] = "The data was inserted successfully!";
        header("location:research.php");
        exit;
    } else {
        $_SESSION['error'] = "Opss!! Something went wrong.";
        header("Location:research.php");
        exit;
    }
}

?>

<div class="card p-3 border-0">
    <form method="POST">
        <div class="">
            <p class="fs-2 font-monospace border-bottom">ADD RESEARCH</p>
        </div>
        <div class="card-body">
            <div class="mb-3 row">
                <label for="addGroupNo" class="col-md-3 form-label">Group Number</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="addGroupNo" required placeholder="-- Enter group number" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="addZone" class="col-md-3 form-label">Zone</label>
                <div class="col-md-9">
                    <select class="form-select" id="addZone" name="addZone" onchange="my_fun(this.value)" required>
                        <option value="" disabled selected hidden>-- Select Zone</option>
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
                    xmlhttp.open("GET", "includes/dropdown_addResearch.php?value=" + str, true);
                    xmlhttp.send();
                }
            </script>
            <div id="program" class="mb-3 row">
                <label for="addProgram" class="col-md-3 form-label">Program</label>
                <div class="col-md-9">
                    <select class="form-select" id="addProgram" name="addProgram" required>
                        <option value="" disabled selected hidden>-- Select Program</option>
                        <option disabled>...</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="addTitle" class="col-md-3 form-label">Title</label>
                <div class="col-md-9">
                    <textarea name="addTitle" id="addTitle" cols="30" rows="3" required placeholder="-- Enter research title" class="form-control fw-normal"></textarea>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="proponent1" class="col-md-3 form-label">Proponent/s</label>
                <div class="mb-3 col-md-9">
                    <input type="text" class="form-control" placeholder="-- Enter proponent" required id="proponent1" name="proponent1">
                </div>
                <label for="proponent2" class="col-md-3 form-label"></label>
                <div class="mb-3 col-md-9">
                    <input type="text" class="form-control" placeholder="-- Enter proponent" name="proponent2">
                </div>
                <label for="proponent3" class="col-md-3 form-label"></label>
                <div class="col-md-9">
                    <input type="text" class="form-control" placeholder="-- Enter proponent" name="proponent3">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="addAdviser" class="col-md-3 form-label">Adviser</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" placeholder="-- Enter adviser" name="addAdviser" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="addStat" class="col-md-3 form-label">Stat/DA</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" placeholder="-- Enter stat/da" name="addStat" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="A" class="col-md-3 form-label">School Year</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" placeholder="-- Enter School Year" name="AddSY" required>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <label for="" class="hidden-label"></label>
                <button type="submit" name="addResearch" class="w-25 btn btn-md btn-primary"><i class="bi-plus-circle"></i> Add</button>
                <a href="research.php" class="w-25 btn btn-md btn-danger">
                    <i class="bi-x-circle"></i> Cancel</a>
            </div>
    </form>
</div>
</div>