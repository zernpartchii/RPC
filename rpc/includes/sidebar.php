<style>
.sidenav {
    height: 100%;
    width: 240px;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    padding-top: 100px;
    padding-left: 4px;
    overflow-x: hidden;
    transition: 0.5s;
    border-radius: 5px;
    /* background-color: rgb(251, 251, 251); */
    background-color: #fff;
}

li:hover {
    background-color: #eee;
    color: #B22222;
    border-radius: 5px;
    /* transition: .3s; */
}

.icon {
    color: #B22222;
}

#main {
    margin-top: 67px;
    background-color: #fff;
    margin-left: 240px;
    transition: margin-left .5s;
}

.um_Side_Logo {
    width: 90%;
    padding-top: 10px;
}

/* .toggle_btn {
        display: none;
    } */

.sidebar_hidden {
    visibility: hidden;
}

.hidden-label {
    margin-right: 11px;
}

@media (max-height: 630px) {

    .sidenav {
        width: 60px;
    }

    #main {
        margin-left: 60px;
        transition: margin-left .5s;
    }


}

@media (max-width:900px) {

    .sidenav {
        width: 60px;
        padding-right: 3px;
    }

    #main {
        margin-left: 60px;
        transition: margin-left .5s;
    }

    /* .toggle_btn {
            display: inline;
        } */

    .user {
        display: none;
    }

    .logo {
        margin-right: auto;
    }

    .sidebar_hidden {
        visibility: visible;
    }

    @media (max-width:767px) {

        .hidden-label {
            display: none;
        }

    }

    @media (max-width:500px) {
        .sidenav {
            width: 0;
        }

        .hidden-label {
            display: none;
        }

        #main {
            margin-left: 0;
            transition: margin-left .5s;
        }

    }
}
</style>

<script>
function myFunction() {
    var x = document.getElementById("mySidenav");
    if (x.className === "sidenav") {
        x.className += "responsive";
        document.getElementById("mySidenav").style.width = "0px";
        document.getElementById("main").style.marginLeft = "0px";
        document.getElementById("mySidenav").classList.add('d-none');
    } else {
        x.className = "sidenav";
        document.getElementById("mySidenav").style.width = "240px";
        document.getElementById("main").style.marginLeft = "240px";
        document.getElementById("mySidenav").classList.remove('d-none');
    }
}
myFunction();
</script>

<!-- Start Sidebar Header -->
<div id="mySidenav" class="sidenav m-0">
    <ul class="px-0">
        <div class="w-100 text-center mb-4">
            <img class="side-logo img-fluid" src="img/logo-transparent.png" alt="um-logo" width="200">
        </div>
        <li class="w-100 umv px-2 my-1 d-flex align-items-center">
            <span class="active1 py-4"></span>
            <a class="nav-link ps-2 py-2 w-100 bi bi-grid-fill icon fs-5 hover
            d-flex align-items-center" href="vmv.php">
                <span class="text-dark active-nav1 ms-4 fs-5 text-nowrap">UM - VMV</span></a>
        </li>
        <li class="w-100 px-2 my-1 d-flex align-items-center">
            <span class="active2 py-4"></span>
            <a class="nav-link ps-2 py-2 w-100 bi bi-speedometer icon fs-5 hover
            d-flex align-items-center" href="dashboard.php">
                <span class="text-dark active-nav2 ms-4 fs-5">Dashboard</span></a>
        </li>
        <li class="w-100 px-2 my-1 d-flex align-items-center">
            <span class="active3 py-4"></span>
            <a class="nav-link ps-2 py-2 w-100 bi bi-search-heart-fill icon fs-5 hover
            d-flex align-items-center" href="research.php">
                <span class="text-dark active-nav3 ms-4 fs-5">Research</span></a>
        </li>
        <li class="w-100 px-2 my-1 d-flex align-items-center">
            <span class="active4 py-4"></span>
            <a class="nav-link ps-2 py-2 w-100 bi bi-flag-fill icon fs-5 hover
            d-flex align-items-center" href="reports.php">
                <span class="text-dark active-nav4 ms-4 fs-5">Reports</span></a>
        </li>
        <li class="w-100 px-2 my-1 d-flex align-items-center">
            <span class="active5 py-4"></span>
            <a class="nav-link ps-2 py-2 w-100 bi bi-gear-fill icon fs-5 hover
            d-flex align-items-center" href="settings.php">
                <span class="text-dark active-nav5 ms-4 fs-5">Settings</span></a>
        </li>
        <li class="w-100 about px-2 my-1 d-flex align-items-center">
            <span class="active6 py-4"></span>
            <a class="nav-link ps-2 py-2 w-100 bi bi-info-circle-fill icon fs-5 hover
            d-flex align-items-center" href="aboutUs.php">
                <span class="text-dark active-nav6 ms-4 fs-5 text-nowrap">About Us</span></a>
        </li>
        <li class="w-100 px-2 my-1 sidebar_hidden d-flex align-items-center">
            <span class="active7 py-4"></span>
            <a class="nav-link ps-2 py-2 w-100 bi bi-person-fill icon fs-5 hover
            d-flex align-items-center" href="profile.php">
                <span class="text-dark active-nav7 ms-4 fs-5">Profile</span></a>
        </li>
        <li class="w-100 px-2 my-1 sidebar_hidden d-flex align-items-center">
            <span class="active8 py-4"></span>
            <a class="nav-link ps-2 py-2 w-100 bi bi-box-arrow-right icon fs-5 hover
            d-flex align-items-center" href="logout.php">
                <span class="text-dark active-nav8 ms-4 fs-5">Logout</span></a>
        </li>
    </ul>
</div>

<!-- End Sidebar Body -->