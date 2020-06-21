<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: welcome.php");
  exit;
}
 
// Include config file
require_once "config.php";

//-------------------------------------------------------------------------------------------------- Problem here
$log_id = $_GET['id'];

// Define variables and initialize with empty values for login
$username = $password = "";
$username_err = $password_err = "";


// Define variables and initialize with empty values for signup
$confirm_password = "";
$confirm_password_err = "";

if ($log_id == 'login')
{ 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}

}
elseif($log_id == 'signup')
{
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $susername_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // For Redirection
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}


}

?>















<!DOCTYPE html>
<html>

<head>
    <title>Vlab</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    
    
    
    
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
<!--        <i class="fas fa-bars"></i>-->
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
          <li class="nav-item">
            <a class="nav-link" href="" data-toggle="modal" data-target="#login">Login | Register</a>
<!--              <a href="" class="btn btn-warning btnEquip" title="issue_equip" data-toggle="modal" data-target="#return_equip">Return Equipment</a>-->
          </li>
        </ul>
      </div>
    </div>
  </nav>
    
    
    
    
    
    
    
    
    

</head>

<body>
    <main class="cs-page-wrapper" style="background-color:#33334d">

        <div class="container-fluid pt pb pt-lg">
          <div class="row align-items-center py">
            
            <div class="col-xl-6 col-lg-5 d-flex justify-content-end">
              <div class="cs-parallax" style="max-width: 1010px; transform: translate3d(0px, 0px, 0px) rotate(0.0001deg); transform-style: preserve-3d; backface-visibility: hidden; pointer-events: none;">
                <div class="cs-parallax-layer position-relative" data-depth="0.1" style="transform: translate3d(-7.9px, 3.7px, 0px); transform-style: preserve-3d; backface-visibility: hidden; position: relative; display: block; left: 0px; top: 0px;"><img src="images/layer01.png" alt="Layer">
                </div>
                <div class="cs-parallax-layer" data-depth="0.15" style="transform: translate3d(-11.8px, 5.5px, 0px); transform-style: preserve-3d; backface-visibility: hidden; position: absolute; display: block; left: 0px; top: 0px;"><img src="images/layer02.png" alt="Layer">
                </div>
                <div class="cs-parallax-layer" data-depth="0.25" style="transform: translate3d(-19.7px, 9.2px, 0px); transform-style: preserve-3d; backface-visibility: hidden; position: absolute; display: block; left: 0px; top: 0px;"><img src="images/layer03.png" alt="Layer">
                </div>
                <div class="cs-parallax-layer" data-depth="0.35" style="transform: translate3d(-27.6px, 12.9px, 0px); transform-style: preserve-3d; backface-visibility: hidden; position: absolute; display: block; left: 0px; top: 0px;"><img src="images/layer04.png" alt="Layer">
                </div>
                <div class="cs-parallax-layer" data-depth="0.5" style="transform: translate3d(-39.4px, 18.5px, 0px); transform-style: preserve-3d; backface-visibility: hidden; position: absolute; display: block; left: 0px; top: 0px;"><img src="images/layer05.png" alt="Layer">
                </div>
                <div class="cs-parallax-layer" data-depth="0.28" style="transform: translate3d(-22.1px, 10.3px, 0px); transform-style: preserve-3d; backface-visibility: hidden; position: absolute; display: block; left: 0px; top: 0px;"><img src="images/layer06.png" alt="Layer">
                </div>
                <div class="cs-parallax-layer" data-depth="0.4" style="transform: translate3d(-31.5px, 14.8px, 0px); transform-style: preserve-3d; backface-visibility: hidden; position: absolute; display: block; left: 0px; top: 0px;"><img src="images/layer07.png" alt="Layer">
                </div>
                <div class="cs-parallax-layer" data-depth="0.5" style="transform: translate3d(-39.4px, 18.5px, 0px); transform-style: preserve-3d; backface-visibility: hidden; position: absolute; display: block; left: 0px; top: 0px;"><img src="images/layer08.png" alt="Layer">
                </div>
                <div class="cs-parallax-layer" data-depth="0.28" style="transform: translate3d(-22.1px, 10.3px, 0px); transform-style: preserve-3d; backface-visibility: hidden; position: absolute; display: block; left: 0px; top: 0px;"><img src="images/layer09.png" alt="Layer">
                </div>
                <div class="cs-parallax-layer" data-depth="0.4" style="transform: translate3d(-31.5px, 14.8px, 0px); transform-style: preserve-3d; backface-visibility: hidden; position: absolute; display: block; left: 0px; top: 0px;"><img src="images/layer10.png" alt="Layer">
                </div>
                <div class="cs-parallax-layer" data-depth="0.25" style="transform: translate3d(-19.7px, 9.2px, 0px); transform-style: preserve-3d; backface-visibility: hidden; position: absolute; display: block; left: 0px; top: 0px;"><img src="images/layer11.png" alt="Layer">
                </div>
                <div class="cs-parallax-layer" data-depth="0.45" style="transform: translate3d(-35.5px, 16.6px, 0px); transform-style: preserve-3d; backface-visibility: hidden; position: absolute; display: block; left: 0px; top: 0px;"><img src="images/layer12.png" alt="Layer">
                </div>
              </div>
            </div>
              
              <div class="col-xl-6 col-lg-7 ">
              <div class="pt-2 pb-3 pb-lg-0 mx-auto mb-5 mb-lg-0 ml-lg-0 mr-xl-7 text-center text-lg-left" style="max-width: 495px;">
                <h1 class="display-4 text-light pb-2"><span class="font-weight-light">Have a look </span>Around!</h1>
                <p class="h4 font-weight-light text-light opacity-70 line-height-base">Let the learning begin.</p>
<!--             Button Above the main picture
<a class="d-inline-flex align-items-center text-decoration-none pt-2 mt-4 mb-5" href="#demos" data-scroll=""><span class="btn btn-icon rounded-circle border-primary"><i class="fe-arrow-down h4 text-primary my-1"></i></span><span class="ml-3 text-primary font-weight-medium">ADD BUTTON HERE</span></a>-->
                <hr class="hr-light mb-5">
                <div class="row">
                  <div class="col-sm-4 mb-4 mb-sm-0">
                    <div class="h1 text-light mb-1">cc</div>
                    <div class="h5 text-light font-weight-normal opacity-70 mb-2">Just for Demo</div><span class="badge badge-pill badge-success">More coming</span>
                  </div>
                  <div class="col-sm-4 mb-4 mb-sm-0">
                    <div class="h1 text-light mb-1">cc</div>
                    <div class="h5 text-light font-weight-normal opacity-70 mb-1">Just for Demo</div>
                  </div>
                  <div class="col-sm-4">
                    <div class="h1 text-light mb-1">cc</div>
                    <div class="h5 text-light font-weight-normal opacity-70 mb-1">Just for Demo</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </main>
<!--    For curve below the main design
        <div class="cs-shape cs-shape-bottom cs-shape-curve bg-secondary">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3000 185.4">
            <path fill="currentColor" d="M3000,0v185.4H0V0c496.4,115.6,996.4,173.4,1500,173.4S2503.6,115.6,3000,0z"></path>
          </svg>
        </div>
-->
<!--
    <div id="demo" class="carousel slide" data-ride="carousel">

         Indicators 
        <ul class="carousel-indicators">
            <li data-target="#demo" data-slide-to="0" class="active"></li>
            <li data-target="#demo" data-slide-to="1"></li>
            <li data-target="#demo" data-slide-to="2"></li>
        </ul>
-->

<!--
         The slideshow 
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/c.jpg" alt="Los Angeles" width="1100" height="500">
                <div class="carousel-caption">
                    <h5 class="p-2 text-dark bg-white text-center">I have delivered us to where we are</h5>
                    <p>1</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/a.jpg" alt="Chicago" width="1100" height="500">
                <div class="carousel-caption">
                    <h5 class="p-2 text-dark bg-white text-center">I have Journeyed Farther</h5>
                    <p>2</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/b.jpg" alt="New York" width="1100" height="500">
                <div class="carousel-caption">
                    <h5 class="p-2 text-dark bg-white text-center">I am everything I have learnt and more.</h5>
                    <p>3</p>
                </div>
            </div>
        </div>
-->

<!--
         Left and right controls 
        <a class="carousel-control-prev" href="#demo" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#demo" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>
    </div>

    <section class="my-5">
        <div class="py-3">
            <h1 class="text-center">About VLab</h1>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    <img src="images/d.jpeg" class="img-fluid aboutimg">
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <h2 class="display-4">SOME TEXT</h2>
                    <p class="py-5">MORE TEXT.</p>
                    <a href="about.php" class="btn btn-success">Click Here</a>
                </div>
            </div>
        </div>
    </section>
-->

<!--
    <section class="my-5">
        <div class="py-3">
            <h1 class="text-center">Services</h1>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="card">
                        <img class="card-img-top" src="images/shin.jpg" alt="Card image">
                        <div class="card-body">
                            <h4 class="card-title">Click 1</h4>
                            <p class="card-text">IMAGE A</p>
                            <a href="#" class="btn btn-primary">View</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="card">
                        <img class="card-img-top" src="images/mr.jpg" alt="Card image">
                        <div class="card-body">
                            <h4 class="card-title">Click 1</h4>
                            <p class="card-text">IMAGE B</p>
                            <a href="#" class="btn btn-primary">View</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="card">
                        <img class="card-img-top" src="images/hiroshi.jpg" alt="Card image">
                        <div class="card-body">
                            <h4 class="card-title">Click 1</h4>
                            <p class="card-text">IMAGE C</p>
                            <a href="#" class="btn btn-primary">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
-->

    <section class="my-5">
        <div class="py-3">
            <h1 class="text-center">Gallery</h1>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-12">
                    <img src="images/c.jpg" class="img-fluid pb-4">
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <img src="images/c.jpg" class="img-fluid pb-4">
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <img src="images/c.jpg" class="img-fluid pb-4">
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <img src="images/c.jpg" class="img-fluid pb-4">
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <img src="images/c.jpg" class="img-fluid pb-4">
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <img src="images/c.jpg" class="img-fluid pb-4">
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <img src="images/c.jpg" class="img-fluid pb-4">
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <img src="images/c.jpg" class="img-fluid pb-4">
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <img src="images/c.jpg" class="img-fluid pb-4">
                </div>
            </div>
        </div>
    </section>

    <section class="my-5">
        <div class="py-3">
            <h1 class="text-center">Contact Us</h1>
        </div>
        <div class="w-50 m-auto">
            <form action="contact_us.php" method="post">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="name" autocomplete="off" class="form-control">
                </div>
                <div class="form-group">
                    <label>Email-Id</label>
                    <input type="text" name="email" autocomplete="off" class="form-control">
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" autocomplete="off" class="form-control">
                </div>
                <div class="form-group">
                    <label>Comments</label>
                    <textarea class="form-control" name="comments"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </section>
    
    
    
    
    
    
    
    
    <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Login</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="modal_body_contents">

                       <div class="wrapper">
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id=login" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="" data-toggle="modal" data-target="#register">Sign up now</a>.</p>
        </form>
    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    
    
    
    
    
    
    
    
    
    
    
    <div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Sign Up</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="modal_body_contents">

                       <div class="wrapper">
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id=signup" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? Go back & Login.</p>
        </form>
    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
            
            <?php include('footer.php') ?>

</body>

</html>
