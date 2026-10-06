<?php

session_start();

if (!isset($_SESSION["user_id"])) {
  header("Location: ./index.php");
  exit;
}

header("Cache-Control: no-store");

$fullName = $_SESSION["fullname"] ?? "";

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Caladea:wght@400;700&display=swap">
  <link rel="stylesheet" href="./assets/css/form-validation.css">
</head>
<body>
  <div class='dashboard'>

    <div class='sidebar'>
      <div class='sidebar-name' id='welcomeName'><?= htmlspecialchars($fullName) ?></div>
      <a href="./auth/logout.php" class="logout">Log out</a>
    </div>

    <div class='content'>
      <h1>Profile</h1>

      <div class='dashboard-box'>

        <div class='form-edit'>
          <h2>My information</h2>
          <button type='button' id='editButton'>Edit</button>
        </div>

        <form id='dashboard-form' novalidate>

          <div>
            <input type='text' id='fullname' name='fullname' placeholder='Full name' disabled>
          </div>

          <div>
            <input type='tel' id='number' name='number' placeholder='Number' disabled>
          </div>

          <div>
            <input type='email' id='email' name='email' placeholder='Email Address' disabled>
          </div>

          <div>
            <input type='url' id='url' name='url' placeholder='URL (https://example.com)' disabled>
          </div>

          <div id='passwordFields'>
            <input type='password' id='password' name='password' placeholder='New password' disabled>
            <input type='password' id='confirmPassword' name='confirm-password' placeholder='Confirm new password' disabled>
          </div>

          <div class='form-save'>
            <input type='submit' id='saveButton' value='Save' disabled>
          </div>

        </form>

      </div>

    </div>
  </div>

  <?php require_once "./components/modal.php"; ?>

  <script src="./assets/js/modal.js"></script>
  <script src="./assets/js/dashboard.js"></script>
</body>
</html>
