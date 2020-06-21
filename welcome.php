<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vlab</title>
<!--
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/style.css">


<link href="css/all.min.css" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

  <!-- Custom styles for this template -->
  <link href="css/clean-blog.min.css" rel="stylesheet">


<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand" href="/">Title</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about.php">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Notices</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</head>
<body>
    
    
    
    
    
    
    <main class="cs-page-wrapper" style="background-color:#33334d;padding-top:65px">

        <div class="container-fluid pt pb pt-lg">
          <div class="row align-items-center py">
            
            <div class="col-xl-6 col-lg-5 d-flex justify-content-end">
              <div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
    </div>
              </div>
            </div>
            
    <p>
        <a href="login/reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="login/logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>
              
              <div class="col-xl-6 col-lg-7 ">
                  
              <div class="pt-2 pb-3 pb-lg-0 mx-auto mb-5 mb-lg-0 ml-lg-0 mr-xl-7 text-center text-lg-left" style="max-width: 495px;">
                <h1 class="display-4 text-light pb-2"><span class="font-weight-light">Second Page</span></h1>
                <p class="h4 font-weight-light text-light opacity-70 line-height-base">Explore Our Virtual Laboratories</p>
<!--             Button Above the main picture
<a class="d-inline-flex align-items-center text-decoration-none pt-2 mt-4 mb-5" href="#demos" data-scroll=""><span class="btn btn-icon rounded-circle border-primary"><i class="fe-arrow-down h4 text-primary my-1"></i></span><span class="ml-3 text-primary font-weight-medium">ADD BUTTON HERE</span></a>-->
                <hr class="hr-light mb-5">
                <div class="row">
                  <div class="col-sm-4 mb-4 mb-sm-0">
                    <div class="h1 text-light mb-1">Lab A</div>
                    <div class="h5 text-light font-weight-normal opacity-70 mb-2">Demo</div><span class="badge badge-pill badge-success"></span>
                  </div>
                  <div class="col-sm-4 mb-4 mb-sm-0">
                    <div class="h1 text-light mb-1">Lab A</div>
                    <div class="h5 text-light font-weight-normal opacity-70 mb-1">Demo</div>
                  </div>
                  <div class="col-sm-4">
                    <div class="h1 text-light mb-1">Lab A</div>
                    <div class="h5 text-light font-weight-normal opacity-70 mb-1">Demo</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        
    </main>

    <section class="my-5">
        <div class="py-3">
            <h1 class="text-center">Virtual Laboratory Setup</h1>
		</div>
        <div class="container-fluid">           
                <div>
                    <img src="images/c.jpg" class="img-fluid pb-4">
                </div>
        
        </div>
    </section>        
<footer>
    <p class="p-3 bg-dark text-white text-center">Department of Computer Science</p>
</footer>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src = "js/bootsrap.bundle.min.js"></script>
<script src = "js/smooth-scroll.polyfills.min.js"></script>
<script src = "js/parallax.min.js"></script>
<!--Main Theme Script-->
<script src = "js/theme.min.js"></script>
<script src="js/clean-blog.min.js"></script>

</body>

</html>
