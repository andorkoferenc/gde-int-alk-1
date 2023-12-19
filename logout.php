<?php
session_start();

// Munkamenet felülírása üres tömbbel
$_SESSION = array();

// A cookiek törlése (ha használatban vannak)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Munkamenet megszüntetése
session_destroy();

// Átirányítás a kezdőlapra
header("Location: index.php");
exit();

?>