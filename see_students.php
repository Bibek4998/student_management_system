<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>See Students</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
      <section>
        <div class="top-container">
            <div class="image-container">
                <a href="dashboard.php">
                    <img src="assets/images/logo.jpg" alt="logo">
                </a>
            </div>
            <nav class="navbar">
                <a href="dashboard.php">Home</a>
                <a href="add.php">Add student</a>
                <a href="delete_student.php">Delete student</a>
                <a href="see_students.php">See students</a>
                <a href="index.php">Login</a>
                <a href="logout.php">Logout</a>
            </nav>
        </div>
    </section>

  
</body>
</html>

<?php
$conn = mysqli_connect("localhost", "root", "", "kcmit_students");

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM students ORDER BY course, batch, semester";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  echo "<style>
    body { font-family: Arial, sans-serif; padding: 20px; }
    h2 { background: #eee; padding: 10px; margin-top: 40px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 40px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
    a { color: blue; text-decoration: none; }
  </style>";

  $courses = ['BIM', 'BBA', 'BCA'];

  foreach ($courses as $course) {
    echo "<h2>$course Students</h2>";
    echo "<table>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Batch</th>
              <th>Semester</th>
              <th>Marksheet</th>
              <th>Character Certificate</th>
              <th>CMAT</th>
              <th>Photo1</th>
              <th>Photo2</th>
            </tr>";

    mysqli_data_seek($result, 0);

    $found = false;
    while ($row = mysqli_fetch_assoc($result)) {
      if ($row['course'] === $course) {
        $found = true;
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['batch']}</td>
                <td>{$row['semester']}</td>
                <td><a href='uploads/{$row['marksheet']}' target='_blank'>View</a></td>
                <td><a href='uploads/{$row['character_cert']}' target='_blank'>View</a></td>
                <td><a href='uploads/{$row['cmat']}' target='_blank'>View</a></td>
                <td><a href='uploads/{$row['photo1']}' target='_blank'>View</a></td>
                <td><a href='uploads/{$row['photo2']}' target='_blank'>View</a></td>
              </tr>";
      }
    }

    if (!$found) {
      echo "<tr><td colspan='9'>No students found in this course.</td></tr>";
    }

    echo "</table>";
  }
} else {
  echo "<p>No student records found.</p>";
}

mysqli_close($conn);
?>
