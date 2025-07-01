<?php
// ✅ Sanitize inputs to prevent XSS
function sanitize($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// ✅ Format price
function formatPrice($price) {
    return '£' . number_format($price, 2);
}
?>
