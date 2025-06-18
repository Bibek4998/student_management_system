<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "kcmit_students");

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = $_POST['password'];

  $query = "SELECT * FROM admin_login WHERE username = '$username'";
  $result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row['password'])) {
      $_SESSION['admin_logged_in'] = true;
      $_SESSION['admin_username'] = $username;
      header("Location: dashboard.php");
      exit();
    } else {
      header("Location: index.php?error=Incorrect+password");
      exit();
    }
  } else {
    header("Location: index.php?error=User+not+found");
    exit();
  }
} else {
  header("Location: index.php");
  exit();
}
