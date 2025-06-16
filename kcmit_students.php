<?php
$servername = "localhost"; 
$username = "root";         
$password = ""; 
$dbname = "kcmit_students"; 

$conn = mysqli_connect($servername, $username, $password, $dbname);
echo "Connected successfully";
mysqli_close($conn);
?>