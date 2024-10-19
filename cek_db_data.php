<?php
// Include kedua file konfigurasi database
include 'config/db_login.php'; // Konfigurasi untuk database login_rekam_medis
include 'config/db_data.php';  // Konfigurasi untuk database sik_trial

// Fungsi untuk mengecek koneksi database
function checkConnection($conn, $dbName) {
    if ($conn->connect_error) {
        return "Gagal terhubung ke database $dbName: " . $conn->connect_error;
    } else {
        return "Database $dbName tersambung";
    }
}

// Mengecek koneksi ke database login_rekam_medis
$loginMessage = checkConnection($conn_login, "login_rekam_medis");

// Mengecek koneksi ke database sik_trial
$dataMessage = checkConnection($conn_sik, "sik_trial");

// Jika koneksi ke database sik_trial berhasil, coba menarik data
$jadwalQuery = "SELECT jadwal.kd_dokter, dokter.nm_dokter, jadwal.hari_kerja, jadwal.jam_mulai, jadwal.jam_selesai, poliklinik.kd_poli, poliklinik.nm_poli
FROM jadwal 
INNER JOIN dokter ON jadwal.kd_dokter = dokter.kd_dokter 
INNER JOIN poliklinik ON jadwal.kd_poli = poliklinik.kd_poli";

$dataResult = $conn_sik->query($jadwalQuery);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Koneksi Database</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Status Koneksi Database</h1>
    <p><?php echo $loginMessage; ?></p>
    <p><?php echo $dataMessage; ?></p>

    <h2>Data Jadwal Dokter</h2>
    <table>
        <tr>
            <th>Kode Dokter</th>
            <th>Nama Dokter</th>
            <th>Hari Kerja</th>
            <th>Jam Mulai</th>
            <th>Jam Selesai</th>
            <th>Kode Poli</th>
            <th>Nama Poli</th>
        </tr>
        <?php
        if ($dataResult->num_rows > 0) {
            // Output data dari setiap baris
            while ($row = $dataResult->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['kd_dokter']}</td>
                        <td>{$row['nm_dokter']}</td>
                        <td>{$row['hari_kerja']}</td>
                        <td>{$row['jam_mulai']}</td>
                        <td>{$row['jam_selesai']}</td>
                        <td>{$row['kd_poli']}</td>
                        <td>{$row['nm_poli']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
// Tutup koneksi
$conn_login->close();
$conn_sik->close();
?>

