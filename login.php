<?php
//This script will handle login
session_start();

// check if the user is already logged in
if(isset($_SESSION['username']))
{
    header("location: welcome.php");
    
}
require_once "config.php";

$username = $password = "";
$err = "";

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty(trim($_POST['username'])) || empty(trim($_POST['password'])))
    {
        $err = "Please enter username + password";
    }
    else{
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
    }


if(empty($err))
{
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $param_username);
    $param_username = $username;
    
    
    // Try to execute this statement
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt))
                    {
                        if(password_verify($password, $hashed_password))
                        {
                            // this means the password is corrct. Allow user to login
                            session_start();
                            $_SESSION["username"] = $username;
                            $_SESSION["id"] = $id;
                            $_SESSION["loggedin"] = true;

                            //Redirect user to welcome page
                            header("location: welcome.php");
                            
                        }
                    }

                }

    }
}    


}


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>My Resume Builder</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/resume.png" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- Login Page CSS -->
  <link rel="stylesheet" href="assets\css\Login Page.css">
</head>
<body>
  <!-- ======= Top Bar ======= -->
  <!--<div id="topbar" class="d-flex align-items-center fixed-top">
    <div class="container d-flex justify-content-center justify-content-md-between">

      <div class="languages d-none d-md-flex align-items-center">
        <ul>
          <li>En</li>
        <!  <li><a href="#">Hindi</a></li>
        </ul>
      </div>
    </div>
  </div>


  <! ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-cente">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-lg-between">

      <h1 class="logo me-auto me-lg-0"><a href="index.html">My resume builder</a></h1>

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto active" href="index.html">Home</a></li>
          <li><a class="nav-link scrollto" href="Get my Resume Page.html">Get my resume</a></li>
          <li><a class="nav-link scrollto" href="View my Profile.html">View my profile</a></li>
          <li><a class="nav-link scrollto" href="Upload my Progress.html">Upload my progress</a></li>
          <li class="dropdown"><a href="#"><span>Templates</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="#">template 1</a></li>
              <li><a href="#">template 2</a></li>
              <li><a href="#">template 3</a></li>
              <li><a href="#">template 4</a></li>
            </ul>
          </li>

        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->
      <a href="login.php" class="book-a-table-btn scrollto d-lg-flex">Login</a>

    </div>
  </header>
<!-- End Header -->

<!-- ======= Hero Section ======= -->
<section class="Form  py-10 my-10 mx-5">
    <div class="container">
        <div class="row  g-0">
            <div class="col-lg-5 ">
                <img src="assets\Login page image.jpg" class="img-fluid" alt="" width="400" height="100">
            </div>
            <div class="col-lg-7 px-7 pt-5">
                 <h1 class="font-weight-bold py-3">LOGIN</h1>
                 <h4>Sign in into your account</h4>
                <form action="" method="post">
                    <div class="form-row">
                        <div class="col-lg-7">
                            <input type="text" name="username" class="form-control my-3 p-2" id="exampleInputEmail1" placeholder="Enter New Username">
                        </div>
                        <div class="col-lg-7">
                            <input type="password" name="password" id="exampleInputPassword1" class="form-control my-3 p-2" placeholder="*******">
                        </div>
                        <div class="form-group form-check">
                          <input type="checkbox" class="form-check-input" id="exampleCheck1">
                          <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div>                      
                        <div class="col-lg-7">
                            <button type="submit" class="btn1 mt-3 mb-5 ">Login</button>
                        </div>
                    </div>
                    <a href="#">Forgot password?</a>
                    <p>Don't Have an account? <a href="register.php">Register here!</a></p>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- End Hero -->

<!-- ======= Footer ======= -->
<footer id="footer">
  <div class="footer-top">
    <div class="container">
      <div class="row" style="background-color: #5c9ca8; border-radius: 0%; box-shadow: none;">

        <div class="col-lg-3 col-md-6">
          <div class="footer-info">
            <h3>Resume builder</h3>
            <p>BMS College of Engineering</p>
              Basavanagudi <br>
              bengaluru<br><br>

              <strong>Email:</strong> keerthanak.is20@bmsce.ac.in<br>
              <strong>Email:</strong> omkatkam.is20@bmsce.ac.in<br>
            </p>

          </div>
        </div>





      </div>
    </div>
  </div>


  
</footer>
<!-- End Footer -->

<div id="preloader"></div>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<!-- Main JS File -->
<script src="assets/js/main.js"></script>
</body>
</html>