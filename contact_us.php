<?php
include_once('config.php')

$name=$_POST['name'];
$email=$_POST['email'];
$phone=$_POST['phone'];
$comments=$_POST['comments'];

$query="insert into contact_us (name, email, phone, comments)
values('$name', '$email', '$phone', '$comments')";

$result = mysqli_query($link,$query);

if($result)
  { 
    echo  "Query Inserted Successful";
  }
 else 
  { 
     //Error page
    echo  "No Connection";
  }

header('location:index.php');

?>