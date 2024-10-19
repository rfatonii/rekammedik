<?php 
include __DIR__ . '/../config/db_login.php'; // Konfigurasi untuk database login_rekam_medis
include __DIR__ . '/../config/db_data.php';  // Konfigurasi untuk database sik_trial

// Fungsi untuk mengecek koneksi database
function checkConnection($conn, $dbName) {
    if ($conn->connect_error) {
        return "Gagal terhubung ke database $dbName: " . $conn->connect_error;
    } else {
        return "Database $dbName tersambung";
    }
  }
?>