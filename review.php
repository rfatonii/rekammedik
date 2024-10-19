<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Redirect ke login jika user belum login
    exit();
}

include 'include/db.php';

// Mengecek koneksi ke database login_rekam_medis
$loginMessage = checkConnection($conn_login, "login_rekam_medis");
// Mengecek koneksi ke database sik_trial
$dataMessage = checkConnection($conn_sik, "sik_trial");

// Filter Tanggal
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : date('Y-m-d');
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : date('Y-m-d');

// Pastikan tanggal valid
function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

if (!validateDate($start_date) || !validateDate($end_date)) {
    $start_date = date('Y-m-d');
    $end_date = date('Y-m-d');
}

// Sanitasi input tanggal
$start_date = $conn_sik->real_escape_string($start_date);
$end_date = $conn_sik->real_escape_string($end_date);

// Query untuk mengambil data pasien
$dataReview = "SELECT 
    rp.no_rawat as no_rawat,
    p.nm_pasien as nama,
    ki.tgl_masuk as masuk,
    ki.tgl_keluar as keluar,
    CASE 
        WHEN p.umur > 13 THEN 'Dewasa'
        ELSE 'Anak'
    END AS kategori,
    CASE 
        WHEN po.nm_perawatan IS NULL THEN 'Bedah'
        ELSE 'Non Bedah'
    END AS jenis
FROM 
    reg_periksa rp
INNER JOIN 
    pasien p ON rp.no_rkm_medis = p.no_rkm_medis
INNER JOIN
    kamar_inap ki ON rp.no_rawat = ki.no_rawat
LEFT JOIN 
    operasi o ON rp.no_rawat = o.no_rawat
LEFT JOIN 
    paket_operasi po ON o.kode_paket = po.kode_paket
WHERE 
    rp.tgl_registrasi BETWEEN '$start_date' AND '$end_date'
    AND rp.kd_poli = 'IGDK' 
    AND rp.status_lanjut='Ranap'";

$dataResultReview = $conn_sik->query($dataReview);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'include/head.php' ?>
  <title>Daftar RM di Review</title>
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand" style="background: #F9D7D8;">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars" style="color:#092C4C;"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link" style="color:#092C4C;">MENU</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar elevation-4" style="background: #0E2030;">
    <!-- Brand Logo -->
    <nav class="navbar">
      <div class="container-fluid p-2">
          <img src="img/text.png" alt="Logo" width="220" class="d-inline-block align-text-top mt-2">
      </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2 mt-2" alt="User Image">
        </div>
        <div class="info">
          <p class="d-block text-white mb-0"><?php echo htmlspecialchars($_SESSION['user']);?></p>
          <p class="d-block text-white mb-0"><?php echo htmlspecialchars($_SESSION['user_type']);?></p>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <?php include 'include/sidebar.php' ?>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 fw-bold">Daftar Rekam Medis Telah di Review</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Review</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-8 p-4">
              <form id="filter-form" class="form-inline" method="POST">
                  <label for="start_date" class="mr-2">Tanggal Mulai:</label> <br>
                  <input type="date" id="start_date" class="form-control mr-2 shadow" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>">
                  <label for="end_date" class="mr-2">Sampai Tanggal:</label>
                  <input type="date" id="end_date" class="form-control mr-2 shadow" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>">
                  <button type="submit" class="btn btn-info shadow text-light">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                  </svg></button>
              </form>             
          </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-light table-hover text-black-50 mb-3" id="mauexport">
                <thead>
                    <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Pasien</th>
                    <th scope="col">Jenis bedah</th>
                    <th scope="col">Tanggal Masuk</th>
                    <th scope="col">Tanggal Keluar</th>
                    <th scope="col">Jenis Pasien</th>
                    <th scope="col">Persentase</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>

                <?php
                    if ($dataResultReview->num_rows > 0){

                      $no = 1;
                      while($row = $dataResultReview->fetch_assoc()) {

                        // Menentukan file formulir berdasarkan kategori dan jenis bedah
                        if ($row['kategori'] == 'Anak' && $row['jenis'] == 'Bedah') {
                            $formFile = 'formanakbedah.php';
                        } elseif ($row['kategori'] == 'Anak' && $row['jenis'] == 'Non Bedah') {
                            $formFile = 'formanaknonbedah.php';
                        } elseif ($row['kategori'] == 'Dewasa' && $row['jenis'] == 'Bedah') {
                            $formFile = 'formdewasabedah.php';
                        } elseif ($row['kategori'] == 'Dewasa' && $row['jenis'] == 'Non Bedah') {
                            $formFile = 'formdewasanonbedah.php';
                        } else {
                            // Jika kombinasi tidak dikenali, arahkan ke formstandar.php atau tampilkan pesan error
                            $formFile = 'formstandar.php';
                        }

                        echo "<tr>
                        <th scope='row'>{$no}</th>
                        <td>{$row['nama']}</td>
                        <td>{$row['jenis']}</td>
                        <td>{$row['masuk']}</td>
                        <td>{$row['keluar']}</td>
                        <td>{$row['kategori']}</td>
                        <td>50%</td>
                        <td><a href='{$formFile}?no_rawat=" . urlencode($row['no_rawat']) . "&nama=" . urlencode($row['nama']) . "' class='btn btn-success'>Lihat</a></td>
                        </tr>";

                        $no++;
                      }
                    } else {
                      echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
                    }
                  ?>

                </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <div class="btn px-4 py-3 rounded-4 text-white" style="background: #E97C7C;"><i class="nav-icon fas fa-pen"></i></div>
            </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer" style="background: #F9D7D8;">
    <strong></strong>
  </footer>
</div>
<!-- ./wrapper -->

<?php include 'include/footer.php'?>

</body>
</html>
