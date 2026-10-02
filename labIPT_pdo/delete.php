<?php
require_once 'config.php';
require_once 'header.php';

$id = trim($_GET['id'] ?? '');
if ($id === '') { die('Invalid student ID'); }

$stmt = $pdo->prepare('SELECT first_name, last_name FROM students WHERE id = ?');
$stmt->execute([$id]);
$student = $stmt->fetch();

if (!$student) { die('Student record not found.'); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $delStmt = $pdo->prepare('DELETE FROM students WHERE id = ?');
    $delStmt->execute([$id]);
    
    if ($delStmt->rowCount() > 0) {
        echo '<div class="notification is-success">Student successfully deleted via PDO! <a href="index.php">Return to Directory</a></div>';
    } else {
        echo '<div class="notification is-danger">Failed to delete record.</div>';
    }
    require_once 'footer.php';
    exit;
}
?>

<div class="box auf-card">
  <h1 class="title is-4 is-auf-blue">Delete Confirmation (PDO)</h1>
  <div class="notification is-danger is-light">
    Are you sure you want to delete student <strong><?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></strong>?
  </div>

  <form method="POST">
    <div class="buttons">
      <button type="submit" class="button is-danger">Yes, Delete Record</button>
      <a href="index.php" class="button is-light">Cancel</a>
    </div>
  </form>
</div>

<?php require_once 'footer.php'; ?>