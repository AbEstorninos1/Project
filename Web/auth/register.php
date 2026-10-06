<?php

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

$fullName = $data["fullName"] ?? "";
$number = $data["number"] ?? "";
$email = $data["email"] ?? "";
$url = $data["url"] ?? "";
$password = $data["password"] ?? "";


$stmt = $conn->prepare(
    "SELECT id FROM users WHERE email = ? LIMIT 1"
);

$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    echo json_encode([
        "success" => false,
        "message" => "Email already exists"
    ]);

    exit;
}

$stmt->close();

$passwordHash = password_hash(
    $password,
    PASSWORD_DEFAULT
);

$stmt = $conn->prepare(
    "INSERT INTO users
    (fullname, number, email, url, password)
    VALUES (?, ?, ?, ?, ?)"
);

$stmt->bind_param(
    "sssss",
    $fullName,
    $number,
    $email,
    $url,
    $passwordHash
);

if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "Registration successful"
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Registration failed"
    ]);
}

$stmt->close();
$conn->close();