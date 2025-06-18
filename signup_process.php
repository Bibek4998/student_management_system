<?php
$conn = mysqli_connect("localhost", "root", "", "kcmit_students");

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  $username = trim(mysqli_real_escape_string($conn, $_POST["username"]));
  $password = $_POST["password"];
  $confirm_password = $_POST["confirm_password"];

  if ($password !== $confirm_password) {
    header("Location: signup.php?error=Passwords+do+not+match");
    exit();
  }

  $check = mysqli_prepare($conn, "SELECT id FROM admin_login WHERE username = ?");
  mysqli_stmt_bind_param($check, "s", $username);
  mysqli_stmt_execute($check);
  mysqli_stmt_store_result($check);

  if (mysqli_stmt_num_rows($check) > 0) {
    header("Location: signup.php?error=Username+already+exists");
    exit();
  }
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $insert = mysqli_prepare($conn, "INSERT INTO admin_login (username, password) VALUES (?, ?)");
  mysqli_stmt_bind_param($insert, "ss", $username, $hashed_password);

  if (mysqli_stmt_execute($insert)) {
    header("Location: signup.php?success=Account+created+successfully");
    exit();
  } else {
    header("Location: signup.php?error=Failed+to+create+account");
    exit();
  }
} else {
  header("Location: signup.php");
  exit();
}
