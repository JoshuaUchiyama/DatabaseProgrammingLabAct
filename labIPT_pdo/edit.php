<?php
require_once 'config.php';
require_once 'header.php';

$id = trim($_GET['id'] ?? '');
if ($id === '') { die('Invalid student ID'); }

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name     = trim($_POST['first_name'] ?? '');
    $middle_name    = trim($_POST['middle_name'] ?? '');
    $last_name      = trim($_POST['last_name'] ?? '');
    $email          = trim($_POST['email'] ?? '');
    $birthday       = trim($_POST['birthday'] ?? '');
    $sex            = trim($_POST['sex'] ?? '');
    $student_number = trim($_POST['student_number'] ?? '');
    $program        = trim($_POST['program'] ?? '');
    $enrolment_date = trim($_POST['enrolment_date'] ?? '');

    if (empty($first_name) || !preg_match("/^[A-Za-z\s]{2,100}$/", $first_name)) { $errors['first_name'] = 'Invalid first name.'; }
    if (empty($last_name) || !preg_match("/^[A-Za-z\s]{2,100}$/", $last_name)) { $errors['last_name'] = 'Invalid last name.'; }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors['email'] = 'Invalid email.'; }
    if (empty($birthday) || !preg_match("/^\d{4}-\d{2}-\d{2}$/", $birthday)) { $errors['birthday'] = 'Invalid birthday.'; }
    if (!in_array($sex, ['Male', 'Female'], true)) { $errors['sex'] = 'Invalid sex.'; }
    if (empty($enrolment_date) || !preg_match("/^\d{4}-\d{2}-\d{2}$/", $enrolment_date)) { $errors['enrolment_date'] = 'Invalid enrolment date.'; }

    if (empty($errors)) {
        $stmt = $pdo->prepare('UPDATE students SET first_name=?, middle_name=?, last_name=?, birthday=?, sex=?, email=?, student_number=?, program=?, enrolment_date=? WHERE id=?');
        $stmt->execute([$first_name, $middle_name, $last_name, $birthday, $sex, $email, $student_number, $program, $enrolment_date, $id]);

        echo '<div class="notification is-success">Record updated successfully via PDO! <a href="index.php">Return to Directory</a></div>';
    }
} else {
    $stmt = $pdo->prepare('SELECT * FROM students WHERE id = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch();

    if (!$row) { die('Student record not found.'); }

    $first_name     = $row['first_name'];
    $middle_name    = $row['middle_name'];
    $last_name      = $row['last_name'];
    $email          = $row['email'];
    $birthday       = $row['birthday'];
    $sex            = $row['sex'];
    $student_number = $row['student_number'];
    $program        = $row['program'];
    $enrolment_date = $row['enrolment_date'];
}
?>

<div class="box auf-card">
  <h1 class="title is-4 is-auf-blue">Edit Student Record (PDO)</h1>
  <form method="POST">
    <div class="columns">
      <div class="column"><label class="label">First Name</label><input class="input" type="text" name="first_name" value="<?= htmlspecialchars($first_name) ?>"></div>
      <div class="column"><label class="label">Middle Name</label><input class="input" type="text" name="middle_name" value="<?= htmlspecialchars($middle_name) ?>"></div>
      <div class="column"><label class="label">Last Name</label><input class="input" type="text" name="last_name" value="<?= htmlspecialchars($last_name) ?>"></div>
    </div>
    <div class="columns">
      <div class="column"><label class="label">Email</label><input class="input" type="email" name="email" value="<?= htmlspecialchars($email) ?>"></div>
      <div class="column"><label class="label">Student Number</label><input class="input" type="text" name="student_number" value="<?= htmlspecialchars($student_number) ?>"></div>
    </div>
    <div class="columns">
      <div class="column">
        <label class="label">Sex</label>
        <div class="select is-fullwidth">
          <select name="sex">
            <option value="Male" <?= $sex === 'Male' ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?= $sex === 'Female' ? 'selected' : '' ?>>Female</option>
          </select>
        </div>
      </div>
      <div class="column"><label class="label">Birthday</label><input class="input" type="date" name="birthday" value="<?= htmlspecialchars($birthday) ?>"></div>
      <div class="column"><label class="label">Enrolment Date</label><input class="input" type="date" name="enrolment_date" value="<?= htmlspecialchars($enrolment_date) ?>"></div>
    </div>
    <div class="field"><label class="label">Program</label><input class="input" type="text" name="program" value="<?= htmlspecialchars($program) ?>"></div>
    <div class="field mt-4">
      <button class="button is-auf-blue" type="submit">Update Record</button>
      <a href="index.php" class="button is-light">Cancel</a>
    </div>
  </form>
</div>

<?php require_once 'footer.php'; ?>