<?php


// ✅ Secure session cookie parameters
$secure = true; // Set to true if using HTTPS + SSL Certificate
$httponly = true;
session_set_cookie_params([
    'lifetime' => 3600,
    'path' => '/',
    'secure' => $secure,
    'httponly' => $httponly,
    'samesite' => 'Strict'
]);

session_start();

// ✅ Session timeout
$timeout = 1200;
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $timeout)) {
    session_unset();
    session_destroy();
    header("Location: /FixerUpperShop/login.php");
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time();

// ✅ Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /FixerUpperShop/login.php");
    exit;
}
?>
