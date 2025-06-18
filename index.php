<?php
session_start();
if (isset($_SESSION['admin_logged_in'])) {
  header("Location: dashboard.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
  <div class="login-container">
    <h2>Admin Login</h2>

    <?php
    if (isset($_GET['error'])) {
      echo "<p class='error-message'>" . htmlspecialchars($_GET['error']) . "</p>";
    }
    ?>

    <form method="POST" action="login_process.php">
      <label for="username">Username:</label>
      <input type="text" name="username" id="username" required>

      <label for="password">Password:</label>
      <input type="password" name="password" id="password" required>

      <button type="submit" name="login">Sign In</button>
    </form>

    <p class="bottom-link">Don't have an account? <a href="signup.php">Sign up</a></p>
  </div>
</body>
</html>
