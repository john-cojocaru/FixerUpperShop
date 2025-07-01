<?php
// ✅ Start session if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Clear all session variables
$_SESSION = [];

// ✅ Destroy the session
session_destroy();

// ✅ Optional: unset session cookie for extra security
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// ✅ Redirect to login or homepage
header("Location: login.php");
exit;
