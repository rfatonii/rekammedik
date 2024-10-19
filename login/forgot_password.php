<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
</head>
<body>
    <h2>Lupa Password</h2>
    <form action="send_reset_link.php" method="POST">
        <label for="email">Masukkan alamat email Anda:</label>
        <input type="email" name="email" required>
        <button type="submit">Kirim Link Reset Password</button>
    </form>
</body>
</html>
