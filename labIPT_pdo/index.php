<?php
require_once 'config.php';
require_once 'header.php';

$sql = 'SELECT id, first_name, last_name, email, enrolment_date FROM students ORDER BY enrolment_date DESC, id DESC';
$stmt = $pdo->query($sql);
$students = $stmt->fetchAll();
?>

<div class="box auf-card">
  <div class="level">
    <div class="level-left"><h1 class="title is-4 is-auf-blue">Student Directory (PDO)</h1></div>
    <div class="level-right"><a href="create.php" class="button is-auf-gold">+ Add New Student</a></div>
  </div>

  <table class="table is-striped is-hoverable is-fullwidth">
    <thead>
      <tr><th>ID</th><th>Name</th><th>Email</th><th>Enrolled</th><th>Actions</th></tr>
    </thead>
    <tbody>
      <?php foreach ($students as $row): ?>
        <tr>
          <td><code><?= htmlspecialchars(substr($row['id'], 0, 8)) ?>...</code></td>
          <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['enrolment_date']) ?></td>
          <td>
            <div class="buttons are-small">
              <a href="view.php?id=<?= $row['id'] ?>" class="button is-info is-light">View</a>
              <a href="edit.php?id=<?= $row['id'] ?>" class="button is-warning is-light">Edit</a>
              <a href="delete.php?id=<?= $row['id'] ?>" class="button is-danger is-light">Delete</a>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php require_once 'footer.php'; ?>