<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit;
}

$username = htmlspecialchars($_SESSION["username"], ENT_QUOTES, "UTF-8");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Clark Coaching</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .welcome { min-height:75vh; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; padding:40px 20px; }
        .welcome h1 { color:var(--primary); font-size:clamp(32px,6vw,52px); }
        .welcome p { color:#bcb5c3; margin:15px 0 25px; }
        .welcome a { display:inline-block; padding:13px 25px; border-radius:8px; background:var(--primary); color:var(--black); font-weight:bold; }
    </style>
</head>
<body>
    <nav>
        <a href="index.html" class="logo">Clark<span>Coaching</span></a>
    </nav>
    <main class="welcome">
        <h1>Welcome, <?= $username ?>!</h1>
        <p>You have successfully logged in to Clark Coaching.</p>
        <a href="index.html">Visit Website</a>
        <p><a href="logout.php">Log Out</a></p>
    </main>
</body>
</html>
