<?php

session_start();

header("Content-Type: application/json");

require_once "../config/database.php";


$userId = (int) $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] === "GET") {

    $stmt = $conn->prepare(
        "SELECT fullname, number, email, url
         FROM users
         WHERE id = ?
         LIMIT 1"
    );

    $stmt->bind_param("i", $userId);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows !== 1) {
        echo json_encode([
            "success" => false,
            "message" => "User not found"
        ]);

        exit;
    }

    echo json_encode(["success" => true,
        "user" => $result->fetch_assoc()
    ]);

    $stmt->close();
    $conn->close();

    exit;
}

if($_SERVER["REQUEST_METHOD"] !== 'POST'){
  exit;
}



$data = json_decode(file_get_contents("php://input"), true);

$fullName = $data["fullName"] ?? "";
$number = $data["number"] ?? "";
$email = $data["email"] ?? "";
$url = $data["url"] ?? "";
$password = $data["password"] ?? "";


$stmt = $conn->prepare(
    "SELECT id FROM users WHERE email = ? AND id != ? LIMIT 1"
);

$stmt->bind_param("si", $email, $userId);
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

if ($password !== "") {
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare(
        "UPDATE users
         SET fullname = ?, number = ?, email = ?, url = ?, password = ?
         WHERE id = ?"
    );

    $stmt->bind_param(
        "sssssi",
        $fullName,
        $number,
        $email,
        $url,
        $passwordHash,
        $userId
    );
} else {
    $stmt = $conn->prepare(
        "UPDATE users
         SET fullname = ?, number = ?, email = ?, url = ?
         WHERE id = ?"
    );

    $stmt->bind_param(
        "ssssi",
        $fullName,
        $number,
        $email,
        $url,
        $userId
    );
}

if ($stmt->execute()) {

    $_SESSION["fullname"] = $fullName;
    $_SESSION["email"] = $email;

    echo json_encode([
        "success" => true,
        "message" => "Information updated successfully"
    ]);

} else {
    echo json_encode([
        "success" => false,
        "message" => "Update failed"
    ]);
}

$stmt->close();
$conn->close();