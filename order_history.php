<?php
require 'includes/db.php';
require 'includes/functions.php';
require 'includes/auth.php'; // ✅ Enforces login and session checks

$user_id = $_SESSION['user_id'] ?? null;

// ✅ Get orders for the logged-in user
$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Orders - FixerUpper</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Logo -->
    <div class="logo-container">
        <img src="img/logo.jpg" alt="FixerUpper Logo" style="max-width: 150px;">
    </div>

    <h2>Your Order History</h2>
    <p><a href="index.php">← Back to Shop</a></p>

    <?php if (empty($orders)): ?>
        <p>You have not placed any orders yet.</p>
    <?php else: ?>
        <?php foreach ($orders as $order): ?>
            <div style="margin: 30px auto; padding: 20px; background: #1e1e1e; border-radius: 10px; max-width: 800px;">
                <h3>Order #<?= $order['id'] ?> (<?= $order['order_date'] ?>)</h3>
                <table style="width: 100%; border-collapse: collapse; color: white;">
                    <tr style="background: #333;">
                        <th style="padding: 10px;">Product</th>
                        <th style="padding: 10px;">Qty</th>
                        <th style="padding: 10px;">Price</th>
                        <th style="padding: 10px;">Subtotal</th>
                    </tr>
                    <?php
                    $stmtItems = $pdo->prepare("
                        SELECT oi.quantity, oi.price, p.name
                        FROM order_items oi
                        JOIN products p ON oi.product_id = p.id
                        WHERE oi.order_id = ?
                    ");
                    $stmtItems->execute([$order['id']]);
                    $items = $stmtItems->fetchAll();

                    $total = 0;
                    foreach ($items as $item):
                        $subtotal = $item['quantity'] * $item['price'];
                        $total += $subtotal;
                    ?>
                    <tr>
                        <td style="padding: 10px;"><?= sanitize($item['name']) ?></td>
                        <td style="padding: 10px;"><?= $item['quantity'] ?></td>
                        <td style="padding: 10px;"><?= formatPrice($item['price']) ?></td>
                        <td style="padding: 10px;"><?= formatPrice($subtotal) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr style="font-weight: bold;">
                        <td colspan="3" style="padding: 10px; text-align: right;">Total:</td>
                        <td style="padding: 10px;"><?= formatPrice($total) ?></td>
                    </tr>
                </table>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
