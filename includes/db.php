<?php
// ✅ Secure PDO connection to MySQL
$host = 'localhost';
$dbname = 'shoppingcart';
$user = 'root';
$pass = ''; // Replace with your MySQL password if needed

$dsn = "mysql:host=localhost;port=3306;dbname=shoppingcart;charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Show errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false, // ✅ Prevents SQL injection
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("❌ Database connection failed: " . $e->getMessage());
}
?>
