<?php
/* Defining CONSTANT variable. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'virtual_lab');//enter your db name inplace of demo
 
// Connecting Database
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Checking if connection is true or else will show error
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
