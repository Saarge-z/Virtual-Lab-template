<?php

$con = mysqli_connect('localhost','root','123456');

 if($con)
  { 
    echo  "Connection Successful";
  }
 else 
  { 
    echo  "No Connection";
  }
  
mysqli_select_db($con,'mywebsite');

$name=$_POST['name'];
$email=$_POST['email'];
$phone=$_POST['phone'];
$comments=$_POST['comments'];

$query="insert into user (name, email, phone, comments)
values('$name', '$email', '$phone', '$comments')";

$result = mysqli_query($con,$query);

if($result)
  { 
    echo  "Connection Successful";
  }
 else 
  { 
    echo  "No Connection";
  }

header('location:index.php');

?>