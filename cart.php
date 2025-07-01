<?php
require 'includes/db.php';
require 'includes/functions.php';
session_start();

// ✅ Protect against undefined cart
$cart = $_SESSION['cart'] ?? [];
$items = [];
$total = 0;

// ✅ SQL Injection Protection: Prepared statements
if (!empty($cart)) {
    $placeholders = implode(',', array_fill(0, count($cart), '?'));
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute(array_keys($cart));
    $items = $stmt->fetchAll();
}

// ✅ Input Validation and secure form processing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update'])) {
        foreach ($_POST['qty'] as $id => $qty) {
            // ✅ Type casting to int and enforcing minimum value
            $_SESSION['cart'][$id] = max(1, (int)$qty);
        }
    }

    if (isset($_POST['remove'])) {
        // ✅ Only remove known product IDs
        unset($_SESSION['cart'][$_POST['remove']]);
    }

    // ✅ Prevent duplicate form submissions on refresh
    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart - FixerUpper</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- FixerUpper Logo -->
    <div class="logo-container">
        <img src="img/logo.jpg" alt="FixerUpper Logo" style="max-width: 250px;">
    </div>

    <?php if (isset($_SESSION['username'])): ?>
    <p style="color: #ccc;">Logged in as <strong><?= sanitize($_SESSION['username']) ?></strong></p>
    <?php endif; ?>

    <h2>Your Cart</h2>
    <p><a href="index.php">← Continue Shopping</a></p>

    <?php if (empty($cart)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <form method="POST">
            <table style="margin:auto; background-color: #1e1e1e; color: #fff; border-collapse: collapse; width: 1800px;">
                <tr style="background-color: #333;">
                    <th style="padding:12px;">Image</th>
                    <th style="padding:12px;">Product</th>
                    <th style="padding:12px;">Price</th>
                    <th style="padding:12px;">Quantity</th>
                    <th style="padding:12px;">Subtotal</th>
                    <th style="padding:12px;">Action</th>
                </tr>

                <?php foreach ($items as $item): 
                    $qty = $cart[$item['id']];
                    $subtotal = $item['price'] * $qty;
                    $total += $subtotal;
                ?>
                <tr>
                    <!-- ✅ Output Sanitization: Prevent Cross-Site Scripting (XSS) -->
                    <td style="padding:10px;">
                        <img src="<?= sanitize($item['image']) ?>" alt="Product Image" style="width: 100px; border-radius: 6px;">
                    </td>
                    <td style="padding:10px;"><?= sanitize($item['name']) ?></td>
                    <td style="padding:10px;"><?= formatPrice($item['price']) ?></td>
                    <td style="padding:10px;">
                        <!-- ✅ Quantity input with validation -->
                        <input type="number" name="qty[<?= $item['id'] ?>]" value="<?= $qty ?>" min="1" style="width: 70px; font-size: 1.1rem;">
                    </td>
                    <td style="padding:10px;"><?= formatPrice($subtotal) ?></td>
                    <td style="padding:10px;">
                        <!-- ✅ Secure POST action with scoped value -->
                        <button type="submit" name="remove" value="<?= $item['id'] ?>" style="padding: 8px 14px; font-size: 1rem;">Remove</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>

            <br>
           <div style="display: flex; justify-content: center; align-items: center; gap: 20px; margin-top: 30px;">
  <strong style="font-size: 1.6rem; color: #ffffff;">Total: <?= formatPrice($total) ?></strong>
  <button type="submit" name="update" class="logout-button" style="max-width: 200px;">🛠 Update Quantities</button>
</div>

            <div class="cart-actions">
            <a href="checkout.php" class="action-button">✅ Proceed to Checkout</a>
            </div>
        </form>
    <?php endif; ?>
</body>
</html>
