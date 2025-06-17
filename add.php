<?php
$conn = mysqli_connect("localhost", "root", "", "kcmit_students");

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  $name = $_POST['name'];
  $batch = $_POST['batch'];
  $course = $_POST['course'];
  $semester = $_POST['semester'];

  function saveFile($fileField) {
    $targetDir = "uploads/";
    $uniqueName = uniqid() . '_' . basename($_FILES[$fileField]["name"]);
    $targetFile = $targetDir . $uniqueName;

    if (move_uploaded_file($_FILES[$fileField]["tmp_name"], $targetFile)) {
      return $uniqueName;
    } else {
      return "";
    }
  }

  $marksheet = saveFile('marksheet');
  $character_cert = saveFile('character_cert');
  $cmat = saveFile('cmat');
  $photo1 = saveFile('photo1');
  $photo2 = saveFile('photo2');

  if ($marksheet && $character_cert && $cmat && $photo1 && $photo2) {
    $sql = "INSERT INTO students (name, batch, semester, course, marksheet, character_cert, cmat, photo1, photo2)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "siissssss", $name, $batch, $semester, $course, $marksheet, $character_cert, $cmat, $photo1, $photo2);
    mysqli_stmt_execute($stmt);
    echo "<p style='color:green;'>Student added successfully.</p>";
    mysqli_stmt_close($stmt);
  } else {
    echo "<p style='color:red;'>Error uploading one or more files.</p>";
  }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Student</title>
  <style>
        * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      width: 100%;
      padding: 0;
      font-family: Arial, Helvetica, sans-serif;
      background-color: rgb(244, 244, 244);
    }

    .top-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: rgb(251, 251, 251);
      padding: 10px 30px;
      border-radius: 0 0 10px 10px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .logo img {
      width: 100px;
      border-radius: 20px;
    }

    .navbar {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px;
      margin-right:210px;
    }

    .navbar a {
      text-decoration: none;
      font-size: 1.2rem;
      color: rgb(5, 0, 16);
    }

    .navbar a:hover {
      color: rgb(233, 0, 210);
      transition: 0.3s;
    }

    main {
      padding: 30px 20px;
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #333;
    }

    .container-content {
      max-width: 600px;
      margin: auto;
      background-color: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    label {
      font-weight: bold;
      color: #444;
    }

    input[type="text"],
    input[type="number"],
    input[type="file"],
    select {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 1rem;
    }

    button[type="submit"] {
      padding: 12px;
      background-color: rgb(10, 120, 250);
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 1rem;
      cursor: pointer;
    }

    button[type="submit"]:hover {
      background-color: rgb(0, 100, 220);
    }

  </style>
</head>
<body>
  <header>
    <div class="top-container">
      <div class="logo">
        <a href="dashboard.php">
          <img src="assets/images/logo.jpg" alt="Logo">
        </a>
      </div>
      <nav class="navbar">
        <a href="dashboard.php">Home</a>
        <a href="add.php">Add Student</a>
        <a href="delete_student.php">Delete Student</a>
        <a href="see_students.php">See Students</a>
        <a href="index.php">Login</a>
        <a href="logout.php">Logout</a>
      </nav>
    </div>
  </header>

  <main>
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
  </main>
</body>
</html>
