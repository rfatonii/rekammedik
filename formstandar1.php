
<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // otewe ke login jika user belum login
    exit();
}

include 'include/db.php';

// Mengecek koneksi ke database login_rekam_medis
$loginMessage = checkConnection($conn_login, "login_rekam_medis");
// Mengecek koneksi ke database sik_trial
$dataMessage = checkConnection($conn_sik, "sik_trial");

// Query Data Triase
$dataTriase = "SELECT 
    COUNT(CASE WHEN triase.no_rawat IS NOT NULL THEN 1 END) AS jumlah_pasien_triase,
    COUNT(CASE WHEN triase.no_rawat IS NULL THEN 1 END) AS jumlah_pasien_non_triase
FROM 
reg_periksa rp
INNER JOIN poliklinik poli ON rp.kd_poli = poli.kd_poli
LEFT JOIN data_triase_igd triase ON rp.no_rawat = triase.no_rawat
WHERE poli.kd_poli = 'IGDK' and tgl_registrasi='2023-09-08' and status_lanjut='Ranap'";

$dataResult = $conn_sik->query($dataTriase);
// End Query Data Triase

// Penilaian Awal Keperawatan IGD

$dataAwalKeperawatanIgd = "SELECT 
    COUNT(CASE WHEN penilaiankeperawatanigd.no_rawat IS NOT NULL THEN 1 END) AS jumlah_awal_keperawatan_igd,
    COUNT(CASE WHEN penilaiankeperawatanigd.no_rawat IS NULL THEN 1 END) AS jumlah_awal_nonkeperawatan_igd
FROM 
reg_periksa rp
INNER JOIN poliklinik poli ON rp.kd_poli = poli.kd_poli
LEFT JOIN penilaian_awal_keperawatan_igd penilaiankeperawatanigd ON rp.no_rawat = penilaiankeperawatanigd.no_rawat
WHERE 
poli.kd_poli = 'IGDK' and tgl_registrasi='2023-09-08' and status_lanjut='Ranap'";

$dataResult2 = $conn_sik->query($dataAwalKeperawatanIgd);

// End Penilaian Awal Keperawatan IGD

// Query Penilaian Medis IGD

$dataPenilaianMedisIgd = "SELECT 
    COUNT(CASE WHEN penilaian.no_rawat IS NOT NULL THEN 1 END) AS jumlah_penilaian,
    COUNT(CASE WHEN penilaian.no_rawat IS NULL THEN 1 END) AS jumlah_non_penilaian
FROM 
reg_periksa rp
INNER JOIN poliklinik poli ON rp.kd_poli = poli.kd_poli
LEFT JOIN penilaian_medis_igd penilaian ON rp.no_rawat = penilaian.no_rawat
WHERE 
poli.kd_poli = 'IGDK' AND tgl_registrasi = '2023-09-08' and status_lanjut='Ranap'";

$dataResult3 = $conn_sik->query($dataPenilaianMedisIgd);

//End Query Penilaian Medis IGD

// Query Penilaian Medis IGD

$dataPenilaianMedisIgd = "SELECT 
    COUNT(CASE WHEN penilaian.no_rawat IS NOT NULL THEN 1 END) AS jumlah_penilaian,
    COUNT(CASE WHEN penilaian.no_rawat IS NULL THEN 1 END) AS jumlah_non_penilaian
FROM 
reg_periksa rp
INNER JOIN poliklinik poli ON rp.kd_poli = poli.kd_poli
LEFT JOIN penilaian_medis_igd penilaian ON rp.no_rawat = penilaian.no_rawat
WHERE 
poli.kd_poli = 'IGDK' AND tgl_registrasi = '2023-09-08' and status_lanjut='Ranap'";

$dataResult3 = $conn_sik->query($dataPenilaianMedisIgd);

//End Query Penilaian Medis IGD

// Queri Data Pemeriksaan Rawat Jalan

$dataPemeriksaanRalan = "SELECT 
    COUNT(CASE WHEN pr.no_rawat IS NOT NULL THEN 1 END) AS jumlah_pemeriksaan_ralan,
    COUNT(CASE WHEN pr.no_rawat IS NULL THEN 1 END) AS jumlah_nonpemeriksaan_ralan
FROM 
reg_periksa rp
INNER JOIN 
poliklinik poli ON rp.kd_poli = poli.kd_poli
LEFT JOIN 
pemeriksaan_ralan pr ON rp.no_rawat = pr.no_rawat
WHERE 
poli.kd_poli = 'IGDK' and tgl_registrasi='2023-09-08' and status_lanjut='Ranap'";

$dataResult4 = $conn_sik->query($dataPemeriksaanRalan);

// End Queri Data Pemeriksaan Rawat Jalan

// Data Pemeriksaan Rawat Inap
$dataPemeriksaanRanap = "SELECT 
    COUNT(CASE WHEN prp.no_rawat IS NOT NULL THEN 1 END) AS jumlah_pemeriksaan_ranap,
    COUNT(CASE WHEN prp.no_rawat IS NULL THEN 1 END) AS jumlah_nonpemeriksaan_ranap
FROM 
reg_periksa rp
INNER JOIN 
poliklinik poli ON rp.kd_poli = poli.kd_poli
LEFT JOIN 
pemeriksaan_ranap prp ON rp.no_rawat = prp.no_rawat
WHERE 
poli.kd_poli = 'IGDK' and tgl_registrasi='2023-09-08' and status_lanjut='Ranap'";

$dataResult5 = $conn_sik->query($dataPemeriksaanRanap)
// End Data Pemeriksaan Rawat Inap
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'include/head.php' ?>
  <title>Jenis Formulir Standar</title>
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
          <p class="d-block text-white mb-0"><?php echo $_SESSION['user'];?></p>
          <p class="d-block text-white mb-0"><?php echo $_SESSION['user_type'];?></p>
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
            <h1 class="m-0 fw-bold"></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Formulir Standar</li>
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
            <div class="col-1">
                <a href="#" class="btn rounded-circle text-white" style="background: #E97C7C;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                    </svg>
                </a>
            </div>
            <div class="col-11">
                <table class="table table-striped text-center">
                <thead>
                    <tr>
                    <th scope="col">No</th>
                    <th scope="col">Jenis Formulir Standar</th>
                    <th scope="col">Lengkap</th>
                    <th scope="col">Tidak Lengkap</th>
                    </tr>
                </thead>
                <tbody>
                <!-- Data pasien Triase IGD -->
                <?php
                  if ($dataResult->num_rows > 0){
                    $row = $dataResult->fetch_assoc();
                     echo "<tr>
                    <th scope='row'>1</th>
                    <td>Triase UGD</td>
                    <td>{$row['jumlah_pasien_triase']}</td>
                    <td>{$row['jumlah_pasien_non_triase']}</td>
                    </tr>";
                  } else {
                    echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
                  }
                  ?>
                   <!--End Data pasien Triase IGD -->
                  
                   <!-- Data Awal Keperawatan IGD -->
                <?php 
                  if ($dataResult2->num_rows > 0){
                    $row = $dataResult2->fetch_assoc();
                     echo "<tr>
                    <th scope='row'>2</th>
                    <td>Penilaian Awal Keperawatan IGD</td>
                    <td>{$row['jumlah_awal_keperawatan_igd']}</td>
                    <td>{$row['jumlah_awal_nonkeperawatan_igd']}</td>
                    </tr>";
                  } else {
                    echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
                  }
                  ?>
                  <!-- End Data Awal Keperawatan IGD -->

                  <!-- Data Penilaian Medis IGD -->
                <?php
                  if ($dataResult3->num_rows > 0){
                    $row = $dataResult3->fetch_assoc();
                     echo "<tr>
                    <th scope='row'>3</th>
                    <td>Penilaian Awal Medis IGD</td>
                    <td>{$row['jumlah_penilaian']}</td>
                    <td>{$row['jumlah_non_penilaian']}</td>
                    </tr>";
                  } else {
                    echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
                  }
                  ?>
                  <!-- End Data Penilaian Medis IGD -->

                  <!-- Data Pemeriksaan Rawat Jalan -->
                <?php
                  if ($dataResult4->num_rows > 0){
                    $row = $dataResult4->fetch_assoc();
                     echo "<tr>
                    <th scope='row'>4</th>
                    <td>Pemeriksaan Rawat Jalan</td>
                    <td>{$row['jumlah_pemeriksaan_ralan']}</td>
                    <td>{$row['jumlah_nonpemeriksaan_ralan']}</td>
                    </tr>";
                  } else {
                    echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
                  }
                  ?>
                   <!-- End Data Pemeriksaan Rawat Jalan -->

                   <!-- Data Data Pemeriksaan Rawat Inap -->
                   <?php
                  if ($dataResult5->num_rows > 0){
                    $row = $dataResult5->fetch_assoc();
                     echo "<tr>
                    <th scope='row'>5</th>
                    <td>Pemeriksaan Rawat Inap</td>
                    <td>{$row['jumlah_pemeriksaan_ranap']}</td>
                    <td>{$row['jumlah_nonpemeriksaan_ranap']}</td>
                    </tr>";
                  } else {
                    echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
                  }
                  ?>
                   <!-- End Data Pemeriksaan Rawat Inap -->

                    <tr>
                    <th scope="row">6</th>
                    <td>Catatan Keperawatan</td>
                    <td>1</td>
                    <td>0</td>
                    </tr>

                    <tr>
                    <th scope="row">7</th>
                    <td>Transfer Pasien Antar Ruangan</td>
                    <td>1</td>
                    <td>0</td>
                    </tr>

                    <tr>
                    <th scope="row">8</th>
                    <td>Resume</td>
                    <td>1</td>
                    <td>0</td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-1"></div>
            <div class="col-6 mt-3">
                <div class="card w-50 p-4" style="background: #F9D7D8;">
                    <table>
                        <tbody>
                            <tr>
                                <td>Jumlah Nilai</td><td></td><td></td>
                            </tr>
                            <tr>
                                <td>Lengkap</td><td class="w-25">: &nbsp;<span>8</span></td>
                            </tr>
                            <tr>
                                <td>Tidak Lengkap</td><td class="w-25">: &nbsp;<span>0</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-5 d-flex justify-content-end">
                <div class="#">
                    <a href="#" class="btn px-4 rounded-4 text-white me-5 mt-4" style="background: #EB5757;">Selanjutnya</a>
                </div>
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