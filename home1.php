<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Arahkan ke login jika user belum login
    exit();
}
echo "Selamat datang, " . $_SESSION['user'] . "!";?>

<a href="login/logout.php">Logout</a>
