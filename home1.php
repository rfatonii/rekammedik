<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); //Jiika belum login
    exit();
}
echo "Selamat datang, " . $_SESSION['user'] . "!";?>

<a href="login/logout.php">Logout</a>
