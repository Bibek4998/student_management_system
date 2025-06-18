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
  <title>Admin Signup</title>
  <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
  <div class="login-container">
    <h2>Create Admin Account</h2>

    <?php
    if (isset($_GET['error'])) {
      echo "<p class='error-message'>" . htmlspecialchars($_GET['error']) . "</p>";
    } elseif (isset($_GET['success'])) {
      echo "<p class='success-message'>" . htmlspecialchars($_GET['success']) . "</p>";
    }
    ?>

    <form method="POST" action="signup_process.php">
      <label for="username">Username:</label>
      <input type="text" name="username" required>

      <label for="password">Password:</label>
      <input type="password" name="password" required>

      <label for="confirm_password">Confirm Password:</label>
      <input type="password" name="confirm_password" required>

      <button type="submit" name="signup">Register</button>
    </form>

    <p class="bottom-link">Already have an account? <a href="index.php">Log in</a></p>
  </div>
</body>
</html>
