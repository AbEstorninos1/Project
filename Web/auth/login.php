<?php

session_start();

header("Content-Type: application/json");

require_once "../config/database.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    
    echo json_encode([
        "success" => false,
        "message" => "Invalid JSON"
    ]);

    exit;
}

$email = $data["email"] ?? "";
$password = $data["password"] ?? "";
$rememberMe = $data["rememberMe"] ?? false;

if ($email === "" || $password === "") {
    echo json_encode([
        "success" => false,
        "message" => "Email and password are required"
    ]);

    exit;
}

$stmt = $conn->prepare(
    "SELECT id, fullname, number, email, url, password
     FROM users
     WHERE email = ?
     LIMIT 1"
);

$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid email or password"
    ]);

    exit;
}

$user = $result->fetch_assoc();

if (!password_verify($password, $user["password"])) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid email or password"
    ]);

    exit;
}

session_regenerate_id(true);

$_SESSION["user_id"] = $user["id"];
$_SESSION["fullname"] = $user["fullname"];

if ($rememberMe === true) {
    setcookie(
        "remember_email",
        $email,
        [
            "expires" => time() + (86400 * 30),
            "path" => "/",
            "httponly" => true,
            "samesite" => "Lax"
        ]
    );
} else {
    setcookie("remember_email", "", time() - 3600, "/");
}

echo json_encode([
    "success" => true,
    "message" => "Login successful"
]);

$stmt->close();
$conn->close();