<?php
require "config.php";
require "functions.php";

// proses tambah
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "add") {
    $name    = trim($_POST["course_name"] ?? "");
    $grade   = floatval($_POST["numeric_grade"] ?? 0);
    $credits = intval($_POST["credits"] ?? 0);

    if ($name === "" || $grade < 0 || $grade > 100 || $credits <= 0) {
        $error = "Input tidak valid. Periksa kembali data yang dimasukkan.";
    } else {
        $letter = numericToLetter($grade);
        $point  = letterToPoint($letter);

        $stmt = $pdo->prepare("INSERT INTO courses (course_name, numeric_grade, letter_grade, grade_point, credits)
                               VALUES (:name, :grade, :letter, :point, :credits)");
        $stmt->execute([
            ":name"    => $name,
            ":grade"   => $grade,
            ":letter"  => $letter,
            ":point"   => $point,
            ":credits" => $credits
        ]);
    }
}

// proses hapus
if (isset($_GET["delete"])) {
    $id = intval($_GET["delete"]);
    $stmt = $pdo->prepare("DELETE FROM courses WHERE id = :id");
    $stmt->execute([":id" => $id]);
    header("Location: index.php");
    exit;
}

// ambil semua data
$stmt = $pdo->query("SELECT * FROM courses ORDER BY id DESC");
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

$gpa       = calculateGPA($courses);
$gpaStatus = getGPAStatus($gpa);
$totalCourses = count($courses);
$totalCredits = array_sum(array_column($courses, "credits"));
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>GPA / IP Semester Calculator (PHP)</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="app-container">
  <header class="app-header">
    <h1>GPA Calculator</h1>
    <p>Track your courses and calculate your semester GPA</p>
  </header>

  <section class="top-cards">
    <div class="card">
      <p class="card-label">Current GPA</p>
      <h2><?php echo number_format($gpa, 2); ?> / 4.0</h2>
      <p class="status-text"><?php echo htmlspecialchars($gpaStatus); ?></p>
    </div>
    <div class="card">
      <p class="card-label">Total Courses</p>
      <h2><?php echo $totalCourses; ?></h2>
      <p class="status-text">Total SKS: <span id="totalCredits"><?php echo $totalCredits; ?></span></p>
    </div>
  </section>

  <section class="card">
    <h2>Add Course</h2>
    <form method="post">
      <input type="hidden" name="action" value="add">
      <div class="form-row">
        <div class="form-group">
          <label for="courseName">Course Name</label>
          <input type="text" id="courseName" name="course_name" placeholder="e.g., Calculus I" required>
        </div>
        <div class="form-group">
          <label for="courseGrade">Grade (0-100)</label>
          <input type="number" id="courseGrade" name="numeric_grade" min="0" max="100" step="0.01" required>
        </div>
        <div class="form-group">
          <label for="courseCredits">Credits (SKS)</label>
          <input type="number" id="courseCredits" name="credits" min="1" required>
        </div>
      </div>
      <button type="submit" class="btn-primary">Add Course</button>
      <?php if ($error): ?>
        <p class="error-text"><?php echo htmlspecialchars($error); ?></p>
      <?php endif; ?>
    </form>
  </section>

  <section class="card">
    <h2>Your Courses</h2>
    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>Course Name</th>
            <th>Grade</th>
            <th>Letter</th>
            <th>Grade Point</th>
            <th>Credits</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php if (empty($courses)): ?>
          <tr>
            <td colspan="6">Belum ada mata kuliah.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($courses as $c): ?>
            <tr>
              <td><?php echo htmlspecialchars($c['course_name']); ?></td>
              <td><?php echo number_format($c['numeric_grade'], 2); ?></td>
              <td><span class="badge"><?php echo htmlspecialchars($c['letter_grade']); ?></span></td>
              <td class="grade-point"><?php echo number_format($c['grade_point'], 1); ?></td>
              <td><?php echo $c['credits']; ?></td>
              <td>
                <a class="btn-delete" href="?delete=<?php echo $c['id']; ?>" onclick="return confirm('Hapus mata kuliah ini?');">🗑</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </section>
</div>
</body>
</html>
