<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Arahkan ke login jika user belum login
    exit();
}
echo "Selamat datang, " . $_SESSION['user'] . "!";?>

<a href="logout.php">Logout</a>
<?php
// File logout.php
session_start();
session_destroy();
header("Location: login.php");
exit();
?>
