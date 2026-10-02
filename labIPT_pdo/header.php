<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AUF Student Portal</title>
  <!-- Bulma CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <!-- AUF Custom Styling -->
  <style>
    :root { --auf-blue: #002B66; --auf-gold: #D4AF37; }
    body { background-color: #f8f9fa; min-height: 100vh; }
    .navbar.is-auf { background-color: var(--auf-blue); border-bottom: 4px solid var(--auf-gold); }
    .navbar.is-auf .navbar-item, .navbar.is-auf strong { color: #fff !important; }
    .button.is-auf-gold { background-color: var(--auf-gold); color: #000; font-weight: 600; }
    .button.is-auf-blue { background-color: var(--auf-blue); color: #fff; font-weight: 600; }
    .title.is-auf-blue { color: var(--auf-blue); }
    .box.auf-card { border-top: 5px solid var(--auf-gold); }
  </style>
</head>
<body>
  <nav class="navbar is-auf mb-5">
    <div class="container">
      <div class="navbar-brand">
        <a class="navbar-item" href="index.php"><strong>Angeles University Foundation</strong></a>
      </div>
      <div class="navbar-menu">
        <div class="navbar-start">
          <a class="navbar-item" href="index.php">Student Directory</a>
          <a class="navbar-item" href="create.php">Add Student</a>
        </div>
      </div>
    </div>
  </nav>
  <main class="container px-4">