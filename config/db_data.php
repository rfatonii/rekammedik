<?php
// $servername = "localhost";  // Nama server
// $username = "root";         // Username database
// $password = "";             // Password database
// $dbname_sik = "sik_trial";  // Nama database kedua

$servername = "192.168.1.150";  // Nama server
$username = "client";         // Username database
$password = "ariaviv1234";             // Password database
$dbname_sik = "sik10052021";  // Nama database kedua

// Buat koneksi
$conn_sik = new mysqli($servername, $username, $password, $dbname_sik);

// Cek koneksi
if ($conn_sik->connect_error) {
    die("Koneksi gagal: " . $conn_sik->connect_error);
}
?>
