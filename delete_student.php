<?php
$conn = mysqli_connect("localhost", "root", "", "kcmit_students");

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


if (isset($_POST['delete_id'])) {
  $id = $_POST['delete_id'];
  $sql = "DELETE FROM students WHERE id = '$id'";
  $result = mysqli_query($conn, $sql);

  $message = ($result && mysqli_affected_rows($conn) > 0)
    ? "Student record deleted."
    : "No matching record found.";
}

$searchResults = [];
if (isset($_POST['search_name'])) {
  $searchName = mysqli_real_escape_string($conn, $_POST['search_name']);
  $sql = "SELECT * FROM students WHERE name LIKE '%$searchName%'";
  $res = mysqli_query($conn, $sql);
  if ($res && mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
      $searchResults[] = $row;
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Delete Student</title>
  <link rel="stylesheet" href="assets/css/delete.css">
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

  <h2>Search and Delete Student</h2>

  <?php if (!empty($message)) echo "<p style='color: green;'>$message</p>"; ?>

  <form method="POST" action="">
    <label>Search by Name:</label>
    <input type="text" name="search_name" required>
    <button type="submit">Search</button>
  </form>

  <?php if (!empty($searchResults)) : ?>
    <h3>Search Results:</h3>
    <table border="1" cellpadding="10" cellspacing="0">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Batch</th>
        <th>Semester</th>
        <th>Course</th>
        <th>Action</th>
      </tr>
      <?php foreach ($searchResults as $student): ?>
        <tr>
          <td><?= $student['id'] ?></td>
          <td><?= $student['name'] ?></td>
          <td><?= $student['batch'] ?></td>
          <td><?= $student['semester'] ?></td>
          <td><?= $student['course'] ?></td>
          <td>
            <form method="POST" action="" onsubmit="return confirm('Are you sure you want to delete this record?');">
              <input type="hidden" name="delete_id" value="<?= $student['id'] ?>">
              <button type="submit">Delete</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  <?php elseif (isset($_POST['search_name'])): ?>
    <p>No records found for "<strong><?= htmlspecialchars($_POST['search_name']) ?></strong>".</p>
  <?php endif; ?>

</body>
</html>
