<?php 

    include 'config.php';

    $val = $_GET["value"];

    $val_M = mysqli_real_escape_string($con, $val);

    $sql = "SELECT * FROM program p JOIN zone z ON p.Zone_id=z.id WHERE p.Zone_id = '$val_M'";
    $result = mysqli_query($con, $sql);

    if(mysqli_num_rows($result) > 0){

        echo '
            <label for="addProgram" class="col-md-3 form-label">Program</label>
            <div class="col-md-9">
                <select class="form-select" id="addProgram" name="addProgram" >';

        while($rows = mysqli_fetch_assoc($result)){
            echo '<option value="'.$rows["Course_Program"].'">'.$rows['Course_Program']."</option>";
        }

        echo '  </select>
            </div>';
    }

?>