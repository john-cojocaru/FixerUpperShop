<?php
require 'includes/db.php';
require 'includes/functions.php';
session_start();

// ✅ Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// ✅ Handle add-to-cart POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = (int) $_POST['product_id'];
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]++;
    } else {
        $_SESSION['cart'][$product_id] = 1;
    }
    header("Location: index.php");
    exit;
}

// ✅ Fetch products from database
$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FixerUpper - Products</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="logo-container">
        <img src="img/logo.jpg" alt="FixerUpper Logo">
    </div>

    <?php if (isset($_SESSION['username'])): ?>
    <p style="color: #ccc;">Logged in as <strong><?= sanitize($_SESSION['username']) ?></strong> <a href="logout.php" class="logout-button">Logout</a></p>
    <?php endif; ?>

    <div style="text-align: center; margin-bottom: 20px;">
    <a href="cart.php" class="nav-button">🛒 View Cart (<?= array_sum($_SESSION['cart']) ?> items)</a>
    <a href="order_history.php" class="nav-button">📦 View My Orders</a>
    </div>

    <div class="products">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <img src="<?= sanitize($product['image']) ?>" alt="<?= sanitize($product['name']) ?>">
                <h3><?= sanitize($product['name']) ?></h3>
                <p><?= sanitize($product['description']) ?></p>
                <strong><?= formatPrice($product['price']) ?></strong>
                <form method="POST">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <button type="submit">Add to Cart</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
