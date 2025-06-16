<?php
$conn = mysqli_connect("localhost", "root", "", "kcmit_students");

$admin_username = "bibek";
$admin_password = password_hash("bibek123", PASSWORD_DEFAULT);

$sql = "INSERT INTO admin_users (username, password) VALUES (?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ss", $admin_username, $admin_password);
mysqli_stmt_execute($stmt);

echo "Admin user inserted.";
?>
