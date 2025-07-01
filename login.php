<?php
require 'includes/db.php';
require 'includes/functions.php';
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = sanitize($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // ✅ Prevent session fixation (Session Hijacking protection)
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
        exit;
    } else {
        $message = "❌ Invalid login credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - FixerUpper</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Logo -->
    <div class="logo-container">
        <img src="img/logo.jpg" alt="FixerUpper Logo" style="max-width: 150px;">
    </div>

    <h2>Login</h2>
    <p><?= $message ?></p>

    <form method="POST" style="max-width: 400px; margin: 20px auto; background-color: #1e1e1e; padding: 30px; border-radius: 10px;">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
        <p><a href="register.php">Don't have an account? Register</a></p>
    </form>
</body>
</html>
