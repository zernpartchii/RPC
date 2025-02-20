<!DOCTYPE html>
<html lang="en">
<html>

<head>
    <!-- header -->
    <?php include('includes/header.php'); ?>

    <!-- title -->
    <title>About Us - RESEARCH & PUBLICATION CENTER</title>
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

    <style>
        .active6 {
            background-color: #B22222;
            width: 6px;
            height: 25px;
        }

        .about {
            background-color: rgb(255, 245, 200);
            color: #B22222;
            border-radius: 5px;
        }
    </style>

    <div class="content p-0" id="main">

        <!-- include Topbar -->
        <?php include('includes/topBar.php') ?>

        <!-- include dashboard content -->
        <?php include('Interface_content/aboutUs_content.php') ?>

    </div>

</body>

</html>