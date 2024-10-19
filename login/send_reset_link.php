<?php
include '../config/db_login.php'; // Koneksi ke database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Cek apakah email ada di database
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn_login->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $token = bin2hex(random_bytes(50)); // Generate token
        $expiry = date("Y-m-d H:i:s", strtotime('+1 hour')); // Token berlaku selama 1 jam

        // Simpan token dan expiry di database
        $sql = "INSERT INTO password_resets (email, token, expiry) VALUES ('$email', '$token', '$expiry')";
        $conn_login->query($sql);

        // Kirim email dengan link reset password
        $resetLink = "localhost/login/reset_password.php?token=$token"; // Ganti dengan domain Anda
        $subject = "Reset Password";
        $message = "Klik link ini untuk mereset password Anda: $resetLink";
        mail($email, $subject, $message); // Anda mungkin ingin menggunakan PHPMailer untuk email yang lebih aman

        echo "Link reset password telah dikirim ke email Anda.";
    } else {
        echo "Email tidak ditemukan.";
    }
}
?>
