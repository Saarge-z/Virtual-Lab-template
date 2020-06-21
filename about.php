<!DOCTYPE html>
<html>

<head>
    <title>Team VLab</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php 
    include ("header.php")    
    ?>
</head>

<body>
    <!--Add background color as per style -> style="background-color:#0b2e13"-->
    <div class="jumbotron">
        <h1>About Us</h1>
        <p>This is the about us page</p>
    </div>
    <section class="my-5">
        <div class="py-3">
            <h1 class="text-center"></h1>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    <img src="images/d.jpeg" class="img-fluid aboutimg">
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <h2 class="display-4">The Call isn't out there at all, it's inside me.</h2>
                    <p class="py-5">Like the tide slowly falling and rising.
                        I will carry you here in my heart you remind me.</p>
                    <a href="about.php" class="btn btn-success">Click Here</a>
                </div>
            </div>
        </div>
    </section>
    <?php 
include ("footer.php")    
?>
</body>

</html>
