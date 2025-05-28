<?php
    <?php
// Database connection parameters
$servername = "localhost";  // Usually 'localhost' if your DB is on the same server
$username = "root";         // Your MySQL username
$password = "";             // Your MySQL password (often empty on local setups)
$dbname = "kcmit_students";  // Your database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

// Close connection when done
mysqli_close($conn);
?>

?>