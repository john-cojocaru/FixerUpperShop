<?php
require 'includes/db.php';
require 'includes/functions.php';
require 'includes/auth.php'; // ✅ Enforces session protection

// ✅ Validate session and cart
if (!isset($_SESSION['user_id'])) {
    header("Location: /FixerUpperShop/login.php");
    exit;
}

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    header("Location: cart.php");
    exit;
}

// ✅ Fetch items
$placeholders = implode(',', array_fill(0, count($cart), '?'));
$stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
$stmt->execute(array_keys($cart));
$items = $stmt->fetchAll();

$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - FixerUpper</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="logo-container">
        <img src="img/logo.jpg" alt="FixerUpper Logo" style="max-width: 250px;">
    </div>

    <?php if (isset($_SESSION['username'])): ?>
    <p style="color: #ccc;">Logged in as <strong><?= sanitize($_SESSION['username']) ?></strong></p>
    <?php endif; ?>

    <h2>Confirm Your Order</h2>
    
    <p><a href="cart.php">← Back to Cart</a></p>

    <form action="confirm_order.php" method="POST">
        <table style="margin:auto; width: 1000px; background-color: #1e1e1e; color: #fff; border-collapse: collapse;">
            <tr style="background-color: #333;">
                <th style="padding: 12px;">Product</th>
                <th style="padding: 12px;">Qty</th>
                <th style="padding: 12px;">Subtotal</th>
            </tr>
            <?php foreach ($items as $item): 
                $qty = $cart[$item['id']];
                $subtotal = $item['price'] * $qty;
                $total += $subtotal;
            ?>
            <tr>
                <td style="padding: 10px;"><?= sanitize($item['name']) ?></td>
                <td style="padding: 10px;"><?= $qty ?></td>
                <td style="padding: 10px;"><?= formatPrice($subtotal) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <br>
<div style="display: flex; justify-content: center; align-items: center; gap: 20px; margin-top: 30px;">
  <strong style="font-size: 1.6rem; color: #ffffff;">Total: <?= formatPrice($total) ?></strong>
</div>

<!-- Confirm Button -->
<div class="cart-actions" style="margin-top: 20px;">
  <button type="submit" class="action-button">✅ Confirm Order</button>
</div>
    </form>
</body>
</html>
