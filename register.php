<?php
require 'includes/db.php';
require 'includes/functions.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = sanitize($_POST['username']);
    $email = sanitize($_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "✖ Invalid email format.";
    }
    $password = $_POST['password'];

    if (!empty($username) && !empty($password) && !empty($email)) {
        // ✅ Password hashed securely
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        try {
            $stmt->execute([$username, $email, $hashedPassword]);
            $message = "✅ Registration successful. You can now <a href='login.php'>login</a>.";
        } catch (PDOException $e) {
            $message = "❌ Username or email already exists.";
        }
    } else {
        $message = "❌ All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - FixerUpper</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Logo -->
    <div class="logo-container">
        <img src="img/logo.jpg" alt="FixerUpper Logo" style="max-width: 150px;">
    </div>

    <h2>Create Account</h2>
    <p><?= $message ?></p>

    <form method="POST" style="max-width: 400px; margin: 20px auto; background-color: #1e1e1e; padding: 30px; border-radius: 10px;">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
        <p><a href="login.php">Already have an account? Login</a></p>
    </form>
</body>
</html>
