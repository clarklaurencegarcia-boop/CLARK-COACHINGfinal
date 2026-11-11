<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: register.html");
    exit;
}

$username = trim($_POST["username"] ?? "");
$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";
$confirmPassword = $_POST["confirm_password"] ?? "";

if (strlen($username) < 3 || strlen($username) > 50 ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) ||
    strlen($email) > 100 || strlen($password) < 8) {
    exit("Please provide a valid username, email, and password of at least 8 characters. <a href='register.html'>Go back</a>");
}

if ($password !== $confirmPassword) {
    exit("Passwords do not match. <a href='register.html'>Try again</a>");
}

$dbHost = "localhost";
$dbName = "clark_coaching_db";
$dbUser = "root";
$dbPass = "";

try {
    $pdo = new PDO(
        "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4",
        $dbUser,
        $dbPass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare(
        "INSERT INTO users (username, email, password_hash)
         VALUES (:username, :email, :password_hash)"
    );
    $stmt->execute([
        "username" => $username,
        "email" => $email,
        "password_hash" => $passwordHash
    ]);

    header("Location: login.html?registered=1");
    exit;

} catch (PDOException $e) {
    if ($e->getCode() === "23000") {
        exit("That username or email is already registered. <a href='register.html'>Go back</a>");
    }
    error_log("Registration error: " . $e->getMessage());
    http_response_code(500);
    exit("Unable to create your account. Check your database setup.");
}
?>
