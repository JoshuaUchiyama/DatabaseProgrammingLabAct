<?php
require_once 'db_connect.php';
require_once 'header.php';

$errors = [];
$first_name = $middle_name = $last_name = $email = $birthday = $sex = $student_number = $program = $enrolment_date = '';

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

    // Validation Rules
    if (empty($first_name) || !preg_match("/^[A-Za-z\s]{2,100}$/", $first_name)) {
        $errors['first_name'] = 'First name must be 2-100 letters and spaces only.';
    }
    if (empty($last_name) || !preg_match("/^[A-Za-z\s]{2,100}$/", $last_name)) {
        $errors['last_name'] = 'Last name must be 2-100 letters and spaces only.';
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Enter a valid email address.';
    }
    if (empty($birthday) || !preg_match("/^\d{4}-\d{2}-\d{2}$/", $birthday)) {
        $errors['birthday'] = 'Birthday must be YYYY-MM-DD.';
    }
    if (!in_array($sex, ['Male', 'Female'], true)) {
        $errors['sex'] = 'Please select a valid sex.';
    }
    if (empty($enrolment_date) || !preg_match("/^\d{4}-\d{2}-\d{2}$/", $enrolment_date)) {
        $errors['enrolment_date'] = 'Enrolment date must be YYYY-MM-DD.';
    }

    if (empty($errors)) {
        $stmt = $conn->prepare('INSERT INTO students (id, first_name, middle_name, last_name, birthday, sex, email, student_number, program, enrolment_date) VALUES (UUID(), ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('sssssssss', $first_name, $middle_name, $last_name, $birthday, $sex, $email, $student_number, $program, $enrolment_date);
        
        if ($stmt->execute()) {
            $success = "Student added successfully!";
            $first_name = $middle_name = $last_name = $email = $birthday = $sex = $student_number = $program = $enrolment_date = '';
        }
        $stmt->close();
    }
}
?>

<div class="box auf-card">
  <div class="level">
    <div class="level-left"><h1 class="title is-4 is-auf-blue">Add New Student</h1></div>
    <div class="level-right"><a href="index.php" class="button is-auf-gold">← Back</a></div>
  </div>

  <?php if (!empty($success)): ?>
    <div class="notification is-success"><?= $success ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="columns">
      <div class="column">
        <div class="field">
          <label class="label">First Name *</label>
          <div class="control"><input class="input" type="text" name="first_name" value="<?= htmlspecialchars($first_name) ?>"></div>
          <?php if (isset($errors['first_name'])): ?><p class="help is-danger"><?= $errors['first_name'] ?></p><?php endif; ?>
        </div>
      </div>
      <div class="column">
        <div class="field">
          <label class="label">Middle Name</label>
          <div class="control"><input class="input" type="text" name="middle_name" value="<?= htmlspecialchars($middle_name) ?>"></div>
        </div>
      </div>
      <div class="column">
        <div class="field">
          <label class="label">Last Name *</label>
          <div class="control"><input class="input" type="text" name="last_name" value="<?= htmlspecialchars($last_name) ?>"></div>
          <?php if (isset($errors['last_name'])): ?><p class="help is-danger"><?= $errors['last_name'] ?></p><?php endif; ?>
        </div>
      </div>
    </div>

    <div class="columns">
      <div class="column">
        <div class="field">
          <label class="label">Email *</label>
          <div class="control"><input class="input" type="email" name="email" value="<?= htmlspecialchars($email) ?>"></div>
          <?php if (isset($errors['email'])): ?><p class="help is-danger"><?= $errors['email'] ?></p><?php endif; ?>
        </div>
      </div>
      <div class="column">
        <div class="field">
          <label class="label">Student Number</label>
          <div class="control"><input class="input" type="text" name="student_number" value="<?= htmlspecialchars($student_number) ?>"></div>
        </div>
      </div>
    </div>

    <div class="columns">
      <div class="column">
        <div class="field">
          <label class="label">Sex *</label>
          <div class="control select is-fullwidth">
            <select name="sex">
              <option value="">-- Select --</option>
              <option value="Male" <?= $sex === 'Male' ? 'selected' : '' ?>>Male</option>
              <option value="Female" <?= $sex === 'Female' ? 'selected' : '' ?>>Female</option>
            </select>
          </div>
          <?php if (isset($errors['sex'])): ?><p class="help is-danger"><?= $errors['sex'] ?></p><?php endif; ?>
        </div>
      </div>
      <div class="column">
        <div class="field">
          <label class="label">Birthday *</label>
          <div class="control"><input class="input" type="date" name="birthday" value="<?= htmlspecialchars($birthday) ?>"></div>
          <?php if (isset($errors['birthday'])): ?><p class="help is-danger"><?= $errors['birthday'] ?></p><?php endif; ?>
        </div>
      </div>
      <div class="column">
        <div class="field">
          <label class="label">Enrolment Date *</label>
          <div class="control"><input class="input" type="date" name="enrolment_date" value="<?= htmlspecialchars($enrolment_date) ?>"></div>
          <?php if (isset($errors['enrolment_date'])): ?><p class="help is-danger"><?= $errors['enrolment_date'] ?></p><?php endif; ?>
        </div>
      </div>
    </div>

    <div class="field">
      <label class="label">Program</label>
      <div class="control"><input class="input" type="text" name="program" value="<?= htmlspecialchars($program) ?>"></div>
    </div>

    <div class="field mt-5">
      <button class="button is-auf-blue" type="submit">Save Student Record</button>
    </div>
  </form>
</div>

<?php 
$conn->close();
require_once 'footer.php'; 
?>