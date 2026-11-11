<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.html");
    exit;
}

$identity = trim($_POST["identity"] ?? "");
$password = $_POST["password"] ?? "";

if ($identity === "" || $password === "") {
    header("Location: login.html?error=missing");
    exit;
}

/* Update these settings if your MySQL configuration is different. */
$dbHost = "localhost";
$dbName = "clark_coaching_db";
$dbUser = "root";
$dbPass = "";

try {
    $pdo = new PDO(
        "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4",
        $dbUser,
        $dbPass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );

    $stmt = $pdo->prepare(
        "SELECT id, username, email, password_hash
         FROM users
         WHERE username = :identity OR email = :identity
         LIMIT 1"
    );
    $stmt->execute(["identity" => $identity]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password_hash"])) {
        session_regenerate_id(true);
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];

        header("Location: welcome.php");
        exit;
    }

    header("Location: login.html?error=invalid");
    exit;

} catch (PDOException $e) {
    error_log("Database connection/login error: " . $e->getMessage());
    http_response_code(500);
    echo "Unable to connect to the database. Check your database setup and connection settings.";
    exit;
}
?>
