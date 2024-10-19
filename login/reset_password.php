<?php
include '../config/db_login.php'; // Koneksi ke database

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Cek apakah token valid
    $sql = "SELECT * FROM password_resets WHERE token='$token' AND expiry > NOW()";
    $result = $conn_login->query($sql);

    if ($result->num_rows > 0) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $email = $result->fetch_assoc()['email'];

            // Update password di database
            $sql = "UPDATE users SET password='$newPassword' WHERE email='$email'";
            $conn_login->query($sql);

            // Hapus token dari database
            $sql = "DELETE FROM password_resets WHERE token='$token'";
            $conn_login->query($sql);

            echo "Password Anda telah diperbarui.";
        }
    } else {
        echo "Token tidak valid atau telah kadaluarsa.";
    }
} else {
    echo "Token tidak ditemukan.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <form action="" method="POST">
        <label for="password">Password Baru:</label>
        <input type="password" name="password" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
