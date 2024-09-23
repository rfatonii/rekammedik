<?php
include 'db_login.php'; // Koneksi ke database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $user_type = $_POST['user_type'];

    // Validasi password dan konfirmasi password
    if ($password !== $confirm_password) {
        echo "Password tidak cocok!";
        exit;
    }

    // Hash password untuk keamanan
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Cek apakah username sudah ada
    $sql_check = "SELECT * FROM users WHERE username='$username'";
    $result = $conn_login->query($sql_check);

    if ($result->num_rows > 0) {
        echo "Username sudah digunakan!";
    } else {
        // Simpan user baru ke database
        $sql_insert = "INSERT INTO users (email, nama, nik, username, password, user_type) 
                       VALUES ('$email', '$nama', '$nik', '$username', '$hashed_password', '$user_type')";

        if ($conn_login->query($sql_insert) === TRUE) {
            echo "Registrasi berhasil! Silakan login.";
            header("Location: login.php"); // Arahkan ke halaman login setelah berhasil
        } else {
            echo "Error: " . $sql_insert . "<br>" . $conn_login->error;
        }
    }
}
?>
