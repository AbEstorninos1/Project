<?php
session_start();

if (isset($_SESSION["user_id"])) {
    header("Location: ./dashboard.php");
    exit;
}

header("Cache-Control: no-store");

$rememberedEmail = $_COOKIE["remember_email"] ?? "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Caladea:wght@400;700&display=swap">
    <link rel="stylesheet" href="./assets/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class='login-container'>
        <div class="login-box">
            <header>
                <h1>LOG IN</h1>
            </header>
                <form id="loginForm">
                    <input type="email" name="email" placeholder="email" value="<?= htmlspecialchars($rememberedEmail) ?>">
                    <input type="password" name="password" placeholder="Password">
                    <div class="form-checkbox">
                        <input type='checkbox' name="remember-me" <?= $rememberedEmail !== "" ? "checked" : "" ?>>
                        <p>Remember me</p>
                    </div>
                    <input type="submit" value="LOGIN">
                </form>
                <p class="create-account">Don't have an account? <a href="./register.php">Create account</a></p>
        </div>
    </div>
    <?php require_once "./components/modal.php"; ?>

    <script src="./assets/js/modal.js"></script>
    <script src="./assets/js/login.js"></script>
</body>
</html>