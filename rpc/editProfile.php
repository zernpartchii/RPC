<!DOCTYPE html>
<html lang="en">
<html>

<head>
    <!-- header -->
    <?php include('includes/header.php'); ?>

    <!-- title -->
    <title>Edit Profile - RESEARCH & PUBLICATION CENTER</title>
</head>

<body>

    <?php

    // Initialize the session
    session_start();

    // Check if the user is logged in, if not then redirect him to login page
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != false) {

        // Check if the user is logged in, if not then redirect him to login page
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("location: login.php");
            exit;
        }
    }

    ?>

    <!-- include Sidebar  -->
    <?php include('includes/sidebar.php') ?>

    <div class="content p-0" id="main">
        <!-- include Topbar -->
        <?php include('includes/topBar.php') ?>

        <!-- include research content -->
        <?php include('Interface_content/editProfile_content.php') ?>
    </div>

</body>

</html>