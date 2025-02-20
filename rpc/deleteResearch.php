<?php

include 'includes/config.php';
session_start();


if (isset($_POST['deleteAll_btn'])) {

  if (isset($_POST['deleteAll_id'])) {
    $all_id = $_POST['deleteAll_id'];

    $extract_id = implode(',', $all_id);
    $lenght = count($all_id);

    $sql = "DELETE FROM research_information WHERE id IN($extract_id)";
    $result = mysqli_query($con, $sql);

    if ($result) {

      if($lenght == 1){
        $_SESSION['status'] = "$lenght record was deleted successfully!";
      }else{
        $_SESSION['status'] = "$lenght records was deleted successfully!";
      }
      header("location:research.php");
      
    } else {
      $_SESSION['error'] = "Opss! Something went wrong.";
      die(mysqli_error($con));
    }

  }else{
      $_SESSION['error'] = "To delete multiple records, please click the checkbox.";
      header("location:research.php");
  }

  
} else {
  $_SESSION['error'] = "Opss! Something went wrong.";
  header("location:research.php");
}

?>
