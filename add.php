<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "kcmit_students");

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  $name = $_POST['name'];
  $batch = $_POST['batch'];
  $course = $_POST['course'];
  $semester = $_POST['semester']; // Now user selects this

  // Upload handler function
  function saveFile($fileField) {
    $targetDir = "uploads/";
    $filename = basename($_FILES[$fileField]["name"]);
    $targetFile = $targetDir . $filename;

    // Move uploaded file
    if (move_uploaded_file($_FILES[$fileField]["tmp_name"], $targetFile)) {
      return $filename;
    } else {
      return "";
    }
  }

  // Save all files
  $marksheet = saveFile('marksheet');
  $character_cert = saveFile('character_cert');
  $cmat = saveFile('cmat');
  $photo1 = saveFile('photo1');
  $photo2 = saveFile('photo2');

  // Insert into database
  $sql = "INSERT INTO students (name, batch, semester, course, marksheet, character_cert, cmat, photo1, photo2)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "siissssss", $name, $batch, $semester, $course, $marksheet, $character_cert, $cmat, $photo1, $photo2);
  mysqli_stmt_execute($stmt);

  echo "<p style='color:green;'>Student added successfully.</p>";

  mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add students</title>
  <link rel="stylesheet" href="assets/css/add.css">
</head>
<body>
  <h2>Add New Student</h2>
  <div class="container-content">
    <form action="add.php" method="POST" enctype="multipart/form-data">
      <label>Student Name:</label>
      <input type="text" name="name" required>

      <label>Admission Year:</label>
      <input type="number" name="batch" min="2000" max="2099" required>

      <label>Semester:</label>
      <select name="semester" required>
        <option value="">-- Select Semester --</option>
        <?php for ($i = 1; $i <= 8; $i++): ?>
          <option value="<?= $i ?>"><?= $i ?></option>
        <?php endfor; ?>
      </select>

      <label>Course:</label>
      <select name="course" required>
        <option value="BIM">BIM</option>
        <option value="BBA">BBA</option>
        <option value="BCA">BCA</option>
      </select>

      <label>Marksheet (12th):</label>
      <input type="file" name="marksheet" required>

      <label>Character Certificate (12th):</label>
      <input type="file" name="character_cert" required>

      <label>CMAT Pass (TU Entrance):</label>
      <input type="file" name="cmat" required>

      <label>Passport Size Photo 1:</label>
      <input type="file" name="photo1" required>

      <label>Passport Size Photo 2:</label>
      <input type="file" name="photo2" required>

      <button type="submit" name="submit">Submit</button>
    </form>
  </div>
</body>
</html>
