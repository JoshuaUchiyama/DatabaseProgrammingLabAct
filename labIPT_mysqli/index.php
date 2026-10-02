<?php
require_once 'db_connect.php';
require_once 'header.php';

$sql = 'SELECT id, first_name, last_name, email, enrolment_date FROM students ORDER BY enrolment_date DESC, id DESC';
$result = mysqli_query($conn, $sql);
?>

<div class="box auf-card">
  <div class="level">
    <div class="level-left"><h1 class="title is-4 is-auf-blue">Student Directory</h1></div>
    <div class="level-right"><a href="create.php" class="button is-auf-gold">+ Add New Student</a></div>
  </div>

  <table class="table is-striped is-hoverable is-fullwidth">
    <thead>
      <tr><th>ID</th><th>Name</th><th>Email</th><th>Enrolled</th><th>Actions</th></tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
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
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php 
mysqli_free_result($result);
mysqli_close($conn);
require_once 'footer.php'; 
?>