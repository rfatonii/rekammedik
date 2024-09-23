<?php
include 'db_login.php'; // Koneksi ke database
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Menggunakan prepared statements untuk menghindari SQL Injection
    $stmt = $conn_login->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $username;
            $_SESSION['user_type'] = $user['user_type'];
            
            // Redirect ke halaman home jika login berhasil
            header("Location: ../home.php");
            exit();
        } else {
            // Redirect kembali ke halaman login dengan pesan error
            header("Location: login.php?error=wrongpassword");
            exit();
        }
    } else {
        // Redirect kembali ke halaman login dengan pesan error
        header("Location: login.php?error=nouser");
        exit();
    }

    $stmt->close();
}
?>
