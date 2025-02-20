<style>
    .navbar, .user{
      background-color: #B22222;
    }
    .active:hover{
        background-color: rgb(150,0,0);
        border-radius: 5px;
    }
</style>
<!-- topbar for form  -->
<nav class="navbar navbar-expand-lg navbar-dark shadow sticky-top">
    <div class="container-fluid">
        <img class="img-fluid mx-auto" src="img/favicon.png" alt="um-logo" width="50">
        <a class="align-middle navbar-brand mx-auto ms-2 fs-5 text-uppercase text-white">Research and Publication Center</a>
        <button class="navbar-toggler mx-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse mx-5" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item mx-2">
                    <a class="nav-link active" href="home.php"><i class="bi-house-fill"></i> Home</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link active" href="about.php"><i class="bi-info-circle"></i> About Us</a>
                </li>
                <li class="nav-item mx-2 d-inline-flex align-items-center">
                    <a class="nav-link active" href="login.php"><i class="bi-person-fill"></i> Login</a>
                    <span class="text-white mx-2"> | </span>
                    <a class="nav-link active" href="register.php"> Sign Up</a>
                </li>
            </ul>
        </div>
    </div>
</nav>