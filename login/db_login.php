<?php
$servername = "localhost";
$username = "root";  
$password = "";      
$dbname = "login_rekam_medis";  

// Membuat koneksi
$conn_login = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn_login->connect_error) {
    die("Koneksi gagal: " . $conn_login->connect_error);
}
?>
