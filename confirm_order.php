<?php
require 'includes/db.php';
require 'includes/functions.php';
require 'includes/auth.php'; // ✅ Enforces user login & session timeout

$user_id = $_SESSION['user_id'] ?? null;
$cart = $_SESSION['cart'] ?? [];

if (!$user_id || empty($cart)) {
    header("Location: index.php");
    exit;
}

try {
    // ✅ Start secure transaction to prevent partial orders
    $pdo->beginTransaction();

    // ✅ Insert order into `orders` table
    $stmt = $pdo->prepare("INSERT INTO orders (user_id) VALUES (?)");
    $stmt->execute([$user_id]);
    $order_id = $pdo->lastInsertId();

    // ✅ Prepared statement to insert each item
    $stmtItem = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");

    foreach ($cart as $product_id => $qty) {
        // ✅ Retrieve product price to prevent manipulation
        $productStmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
        $productStmt->execute([$product_id]);
        $product = $productStmt->fetch();

        if ($product) {
            $stmtItem->execute([
                $order_id,
                $product_id,
                (int)$qty,                       // ✅ Input Validation
                $product['price']               // ✅ Trust server-side price
            ]);
        }
    }

    // ✅ Commit transaction and clear cart
    $pdo->commit();
    $_SESSION['cart'] = [];

    $success = true;

} catch (Exception $e) {
    $pdo->rollBack();
    $success = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation - FixerUpper</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="logo-container">
        <img src="img/logo.jpg" alt="FixerUpper Logo" style="max-width: 150px;">
    </div>

    <h2>Order Confirmation</h2>

    <?php if ($success): ?>
        <p>✅ Thank you! Your order has been placed successfully.</p>
        <p><a href="index.php">Return to Home</a></p>
    <?php else: ?>
        <p>❌ Sorry, there was a problem placing your order.</p>
        <p><a href="cart.php">Back to Cart</a></p>
    <?php endif; ?>
</body>
</html>
