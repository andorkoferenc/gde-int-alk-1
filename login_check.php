<?php
// Ha nincs bejelentkezve akkor átirányítja login oldalra
session_start();
if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>