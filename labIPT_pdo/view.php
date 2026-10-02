<?php
require_once 'config.php';
require_once 'header.php';

$id = trim($_GET['id'] ?? '');
if ($id === '') {
    echo '<div class="notification is-danger">Invalid student ID</div>';
    require_once 'footer.php';
    exit;
}

$stmt = $pdo->prepare('SELECT id, first_name, middle_name, last_name, birthday, sex, email, student_number, program, enrolment_date, created_at FROM students WHERE id = ?');
$stmt->execute([$id]);
$student = $stmt->fetch();
?>

<div class="box auf-card">
  <div class="level">
    <div class="level-left"><h1 class="title is-4 is-auf-blue">Student Details (PDO)</h1></div>
    <div class="level-right"><a href="index.php" class="button is-auf-gold">← Back to List</a></div>
  </div>

  <?php if (!$student): ?>
    <div class="notification is-warning">Student not found.</div>
  <?php else: ?>
    <table class="table is-bordered is-fullwidth">
      <tr><th>UUID</th><td><code><?= htmlspecialchars($student['id']) ?></code></td></tr>
      <tr><th>Full Name</th><td><?= htmlspecialchars($student['first_name'] . ' ' . ($student['middle_name'] ? $student['middle_name'] . ' ' : '') . $student['last_name']) ?></td></tr>
      <tr><th>Student Number</th><td><?= htmlspecialchars($student['student_number']) ?></td></tr>
      <tr><th>Email</th><td><?= htmlspecialchars($student['email']) ?></td></tr>
      <tr><th>Program</th><td><?= htmlspecialchars($student['program']) ?></td></tr>
      <tr><th>Sex</th><td><?= htmlspecialchars($student['sex']) ?></td></tr>
      <tr><th>Birthday</th><td><?= htmlspecialchars($student['birthday']) ?></td></tr>
      <tr><th>Enrolment Date</th><td><?= htmlspecialchars($student['enrolment_date']) ?></td></tr>
      <tr><th>Created At</th><td><?= htmlspecialchars($student['created_at']) ?></td></tr>
    </table>
  <?php endif; ?>
</div>

<?php require_once 'footer.php'; ?>