<?php
require_once 'db_connect.php';
require_once 'header.php';

$id = trim($_GET['id'] ?? '');
if ($id === '') { die('Invalid student ID'); }

$stmt = $conn->prepare('SELECT first_name, last_name FROM students WHERE id = ?');
$stmt->bind_param('s', $id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$student) { die('Student record not found.'); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $delStmt = $conn->prepare('DELETE FROM students WHERE id = ?');
    $delStmt->bind_param('s', $id);
    $delStmt->execute();
    
    if ($delStmt->affected_rows > 0) {
        echo '<div class="notification is-success">Student successfully deleted! <a href="index.php">Return to Directory</a></div>';
    } else {
        echo '<div class="notification is-danger">Failed to delete record.</div>';
    }
    $delStmt->close();
    $conn->close();
    require_once 'footer.php';
    exit;
}
?>

<div class="box auf-card">
  <h1 class="title is-4 is-auf-blue">Delete Confirmation</h1>
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

<?php 
$conn->close();
require_once 'footer.php'; 
?>