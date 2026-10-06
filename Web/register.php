<?php
session_start();

if (isset($_SESSION["user_id"])) {
    header("Location: ./dashboard.php");
    exit;
}

header("Cache-Control: no-store");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Caladea:wght@400;700&display=swap">
    <link rel="stylesheet" href="./assets/css/register.css">

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

    <div class="register-container">
        <div class="register-box">

            <header>
                <h1>Sign up</h1>
            </header>

            <form id="registerForm">

                <div>
                    <input
                        type="text"
                        placeholder="Full name"
                        name="fullname"
                        required>
                </div>

                <div>
                    <input
                        type="tel"
                        placeholder="Number"
                        name="number"
                        required>
                </div>

                <div>
                    <input
                        type="email"
                        name="email"
                        placeholder="Email Address"
                        required>
                </div>

                <div>
                    <input
                        type="url"
                        name="url"
                        placeholder="URL (https://example.com)"
                        required>
                </div>

                <div>
                    <input
                        type="password"
                        name="password"
                        placeholder="Password"
                        required>
                </div>

                <div>
                    <input
                        type="password"
                        name="confirm-password"
                        placeholder="Confirm Password"
                        required>
                </div>

                <input
                    type="submit"
                    value="Sign Up">

            </form>

            <a href="./index.php" class="login">
                Already have an account?
            </a>

        </div>
    </div>

    <?php require_once "./components/modal.php"; ?>

    <script src="./assets/js/modal.js"></script>
    <script src="./assets/js/register.js"></script>

</body>

</html>