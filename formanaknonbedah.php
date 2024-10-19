
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

// Mengambil parameter no_rawat dari URL
$no_rawat = isset($_GET['no_rawat']) ? $_GET['no_rawat'] : null;

// Validasi no_rawat
if (!$no_rawat) {
    // Jika no_rawat tidak ada, redirect atau tampilkan pesan error
    echo "No Rawat tidak valid.";
    exit();
}


$no_rawat = $conn_sik->real_escape_string($no_rawat);


// Memeriksa apakah ada parameter 'nama_pasien' di URL
if (isset($_GET['nama'])) {
    $nama_pasien = $_GET['nama'];
} else {
    $nama_pasien = "Nama tidak ditemukan";
}


// Inisialisasi total
$total_lengkap = 0;
$total_tidak_lengkap = 0;

// Data Identitas Pasien
$dataPasien = "	SELECT 
COUNT(DISTINCT CASE WHEN pasien.no_rkm_medis IS NOT NULL THEN rp.no_rawat END) AS pasien,
COUNT(DISTINCT CASE WHEN pasien.no_rkm_medis IS NULL THEN rp.no_rawat END) AS non_pasien
FROM 
reg_periksa rp
INNER JOIN 
poliklinik poli ON rp.kd_poli = poli.kd_poli
LEFT JOIN 
pasien pasien ON rp.no_rkm_medis = pasien.no_rkm_medis
WHERE poli.kd_poli = 'IGDK'
AND rp.no_rawat = '$no_rawat'
AND status_lanjut='Ranap'";

$dataResult1 = $conn_sik->query($dataPasien);
// End Data Identitas Pasien

// Query Data Triase
$dataTriase = "SELECT 
COUNT(DISTINCT CASE WHEN triase.no_rawat IS NOT NULL THEN rp.no_rawat END) jumlah_pasien_triase,
COUNT(DISTINCT CASE WHEN triase.no_rawat IS NULL THEN rp.no_rawat END) AS jumlah_pasien_non_triase
FROM 
reg_periksa rp
INNER JOIN 
poliklinik poli ON rp.kd_poli = poli.kd_poli
LEFT JOIN 
data_triase_igd triase ON rp.no_rawat = triase.no_rawat
WHERE poli.kd_poli = 'IGDK'
AND rp.no_rawat = '$no_rawat'
AND status_lanjut='Ranap'";

$dataResult2 = $conn_sik->query($dataTriase);
// End Query Data Triase

// Penilaian Awal Keperawatan IGD
$dataAwalKeperawatanIgd = "SELECT 
COUNT(DISTINCT CASE WHEN pkigd.no_rawat IS NOT NULL THEN rp.no_rawat END) AS jumlah_awal_keperawatan_igd,
COUNT(DISTINCT CASE WHEN pkigd.no_rawat IS NULL THEN rp.no_rawat END) AS jumlah_awal_nonkeperawatan_igd
FROM 
reg_periksa rp
INNER JOIN 
poliklinik poli ON rp.kd_poli = poli.kd_poli
LEFT JOIN 
penilaian_awal_keperawatan_igd pkigd ON rp.no_rawat = pkigd.no_rawat
WHERE poli.kd_poli = 'IGDK'
AND rp.no_rawat = '$no_rawat'
AND status_lanjut='Ranap'";

$dataResult3 = $conn_sik->query($dataAwalKeperawatanIgd);

// End Penilaian Awal Keperawatan IGD

// Query Penilaian Medis IGD
$dataPenilaianMedisIgd = "SELECT 
COUNT(DISTINCT CASE WHEN pmigd.no_rawat IS NOT NULL THEN rp.no_rawat END) AS jumlah_penilaian,
COUNT(DISTINCT CASE WHEN pmigd.no_rawat IS NULL THEN rp.no_rawat END) AS jumlah_non_penilaian
FROM 
reg_periksa rp
INNER JOIN 
poliklinik poli ON rp.kd_poli = poli.kd_poli
LEFT JOIN 
penilaian_medis_igd pmigd ON rp.no_rawat = pmigd.no_rawat
WHERE poli.kd_poli = 'IGDK'
AND rp.no_rawat = '$no_rawat'
AND status_lanjut='Ranap'";

$dataResult4 = $conn_sik->query($dataPenilaianMedisIgd);

//End Query Penilaian Medis IGD

// Queri Data Pemeriksaan Rawat Jalan

$dataPemeriksaanRalan = "SELECT 
COUNT(DISTINCT CASE WHEN pralan.no_rawat IS NOT NULL THEN rp.no_rawat END) AS jumlah_pemeriksaan_ralan,
COUNT(DISTINCT CASE WHEN pralan.no_rawat IS NULL THEN rp.no_rawat END) AS jumlah_nonpemeriksaan_ralan
FROM 
reg_periksa rp
INNER JOIN 
poliklinik poli ON rp.kd_poli = poli.kd_poli
LEFT JOIN 
pemeriksaan_ralan pralan ON rp.no_rawat = pralan.no_rawat
WHERE poli.kd_poli = 'IGDK'
AND rp.no_rawat = '$no_rawat'
AND status_lanjut='Ranap'";

$dataResult5 = $conn_sik->query($dataPemeriksaanRalan);

// End Queri Data Pemeriksaan Rawat Jalan

// Data Penilaian Awal Keperawatan Ranap
$dataPenilaianAwalRanap = "SELECT 
COUNT(DISTINCT CASE WHEN awalranap.no_rawat IS NOT NULL THEN rp.no_rawat END) AS awal_ranap,
COUNT(DISTINCT CASE WHEN awalranap.no_rawat IS NULL THEN rp.no_rawat END) AS nonawal_ranap
FROM 
reg_periksa rp
INNER JOIN 
poliklinik poli ON rp.kd_poli = poli.kd_poli
LEFT JOIN 
penilaian_awal_keperawatan_ranap awalranap ON rp.no_rawat = awalranap.no_rawat
WHERE poli.kd_poli = 'IGDK'
AND rp.no_rawat = '$no_rawat'
AND status_lanjut='Ranap'";

$dataResult6 = $conn_sik->query($dataPenilaianAwalRanap);
// End Data Penilaian Awal Keperawatan Ranap

// Data Pemeriksaan Rawat Inap
$dataPemeriksaanRanap = "SELECT 
-- note
COUNT(DISTINCT CASE WHEN prinap.no_rawat IS NOT NULL THEN rp.no_rawat END) AS jumlah_pemeriksaan_ranap,
COUNT(DISTINCT CASE WHEN prinap.no_rawat IS NULL THEN rp.no_rawat END) AS jumlah_nonpemeriksaan_ranap
FROM 
reg_periksa rp
INNER JOIN 
poliklinik poli ON rp.kd_poli = poli.kd_poli
LEFT JOIN 
pemeriksaan_ranap prinap ON rp.no_rawat = prinap.no_rawat
WHERE poli.kd_poli = 'IGDK'
AND rp.no_rawat = '$no_rawat'
AND status_lanjut='Ranap'";

$dataResult7 = $conn_sik->query($dataPemeriksaanRanap);
// End Data Pemeriksaan Rawat Inap

// Data Catatan Keperawatan Ranap
$dataCatatanPerawatanRanap = "SELECT 
COUNT(DISTINCT CASE WHEN catatranap.no_rawat IS NOT NULL THEN rp.no_rawat END) AS catatan_keperawatan_ranap,
COUNT(DISTINCT CASE WHEN catatranap.no_rawat IS NULL THEN rp.no_rawat END) AS catatan_keperawatan_nonranap
FROM 
reg_periksa rp
INNER JOIN 
poliklinik poli ON rp.kd_poli = poli.kd_poli
LEFT JOIN 
catatan_keperawatan_ranap catatranap ON rp.no_rawat = catatranap.no_rawat
WHERE poli.kd_poli = 'IGDK'
AND rp.no_rawat = '$no_rawat'
AND status_lanjut='Ranap'";

$dataResult8 = $conn_sik->query($dataCatatanPerawatanRanap);
// End Data Catatan Keperawatan Ranap

// Data Penilaian Resiko Jatuh Anak
$dataPenilaianResikoJatuhAnak = "SELECT 
COUNT(DISTINCT CASE WHEN plresikojatuhanak.no_rawat IS NOT NULL THEN rp.no_rawat END) AS resikojatuh_anak,
COUNT(DISTINCT CASE WHEN plresikojatuhanak.no_rawat IS NULL THEN rp.no_rawat END) AS nonresikojatuh_anak
FROM 
reg_periksa rp
INNER JOIN 
poliklinik poli ON rp.kd_poli = poli.kd_poli
LEFT JOIN 
penilaian_lanjutan_resiko_jatuh_anak plresikojatuhanak ON rp.no_rawat = plresikojatuhanak.no_rawat
WHERE poli.kd_poli = 'IGDK'
AND rp.no_rawat = '$no_rawat'
AND status_lanjut='Ranap'";

$dataResult9 = $conn_sik->query($dataPenilaianResikoJatuhAnak);
// End Data Penilaian Resiko Jatuh Anak

// Data Pemantauan EWS Anak
$dataPewsAnak = "SELECT 
COUNT(DISTINCT CASE WHEN pewsanak.no_rawat IS NOT NULL THEN rp.no_rawat END) AS pews_anak,
COUNT(DISTINCT CASE WHEN pewsanak.no_rawat IS NULL THEN rp.no_rawat END) AS nonpews_anak
FROM 
reg_periksa rp
INNER JOIN 
poliklinik poli ON rp.kd_poli = poli.kd_poli
LEFT JOIN 
pemantauan_pews_anak pewsanak ON rp.no_rawat = pewsanak.no_rawat
WHERE poli.kd_poli = 'IGDK'
AND rp.no_rawat = '$no_rawat'
AND status_lanjut='Ranap'";

$dataResult10 = $conn_sik->query($dataPewsAnak);
// End Data Pemantauan EWS Anak

// Tranfer Pasien Antar Ruang
$dataTfPasienAntarRuang = "SELECT 
COUNT(DISTINCT CASE WHEN pantarruang.no_rawat IS NOT NULL THEN rp.no_rawat END) AS pasien_antarruang,
COUNT(DISTINCT CASE WHEN pantarruang.no_rawat IS NULL THEN rp.no_rawat END) AS nonpasien_antarruang
FROM 
reg_periksa rp
INNER JOIN 
poliklinik poli ON rp.kd_poli = poli.kd_poli
LEFT JOIN 
transfer_pasien_antar_ruang pantarruang ON rp.no_rawat = pantarruang.no_rawat
WHERE poli.kd_poli = 'IGDK'
AND rp.no_rawat = '$no_rawat'
AND status_lanjut='Ranap'";

$dataResult11 = $conn_sik->query($dataTfPasienAntarRuang);
// End Transfer Pasien Antar Ruang

// Data Diagnosa Pasien
$dataDiagnosaPasien = "SELECT 
COUNT(DISTINCT CASE WHEN diagnosa.no_rawat IS NOT NULL THEN rp.no_rawat END) AS diagnosa_pasien,
COUNT(DISTINCT CASE WHEN diagnosa.no_rawat IS NULL THEN rp.no_rawat END) AS nondiagnosa_pasien
FROM 
reg_periksa rp
INNER JOIN 
poliklinik poli ON rp.kd_poli = poli.kd_poli
LEFT JOIN 
diagnosa_pasien diagnosa ON rp.no_rawat = diagnosa.no_rawat
WHERE poli.kd_poli = 'IGDK'
AND rp.no_rawat = '$no_rawat'
AND status_lanjut='Ranap'";

$dataResult12 = $conn_sik->query($dataDiagnosaPasien);
// End data Diagnosa Pasien

// Data Resume Pasien
$dataResumePasien = "	SELECT 
	COUNT(DISTINCT CASE WHEN resume.no_rawat IS NOT NULL THEN rp.no_rawat END) AS resume_pasien,
	COUNT(DISTINCT CASE WHEN resume.no_rawat IS NULL THEN rp.no_rawat END) AS nonresume_pasien
	FROM 
	reg_periksa rp
	INNER JOIN 
	poliklinik poli ON rp.kd_poli = poli.kd_poli
	LEFT JOIN 
	resume_pasien resume ON rp.no_rawat = resume.no_rawat
	WHERE poli.kd_poli = 'IGDK'
	AND rp.no_rawat = '$no_rawat'
	AND status_lanjut='Ranap'";

$dataResult21 = $conn_sik->query($dataResumePasien);
// End Data Resume Pasien

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
          <div class="col-1"></div>
          <div class="col-11">
            <h3 class="text-bold"><?php echo htmlspecialchars($nama_pasien). " ( " . htmlspecialchars($no_rawat) . ")"; ?></h3>
          </div>
        </div>
        <div class="row">
            <div class="col-1">
                <a href="review.php" class="btn rounded-circle text-white" style="background: #E97C7C;">
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

                <?php
                  if ($dataResult1->num_rows > 0){
                    $row = $dataResult1->fetch_assoc();
                     echo "<tr>
                    <th scope='row'>1</th>
                    <td>Identitas Pasien</td>
                    <td>{$row['pasien']}</td>
                    <td>{$row['non_pasien']}</td>
                    </tr>";
                     
                    $total_lengkap += $row['pasien'];
                    $total_tidak_lengkap += $row['non_pasien'];
                  } else {
                    echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
                  }
                  ?>

                <!-- Data pasien Triase IGD -->
                <?php
                  if ($dataResult2->num_rows > 0){
                    $row = $dataResult2->fetch_assoc();
                     echo "<tr>
                    <th scope='row'>2</th>
                    <td>Triase UGD</td>
                    <td>{$row['jumlah_pasien_triase']}</td>
                    <td>{$row['jumlah_pasien_non_triase']}</td>
                    </tr>";
                     
                    $total_lengkap += $row['jumlah_pasien_triase'];
                    $total_tidak_lengkap += $row['jumlah_pasien_non_triase'];
                  } else {
                    echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
                  }
                  ?>
                   <!--End Data pasien Triase IGD -->
                  
                   <!-- Data Awal Keperawatan IGD -->
                <?php 
                  if ($dataResult3->num_rows > 0){
                    $row = $dataResult3->fetch_assoc();
                     echo "<tr>
                    <th scope='row'>3</th>
                    <td>Penilaian Awal Keperawatan IGD</td>
                    <td>{$row['jumlah_awal_keperawatan_igd']}</td>
                    <td>{$row['jumlah_awal_nonkeperawatan_igd']}</td>
                    </tr>";
                     
                    $total_lengkap += $row['jumlah_awal_keperawatan_igd'];
                    $total_tidak_lengkap += $row['jumlah_awal_nonkeperawatan_igd'];
                  } else {
                    echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
                  }
                  ?>
                  <!-- End Data Awal Keperawatan IGD -->

                  <!-- Data Penilaian Medis IGD -->
                <?php
                  if ($dataResult4->num_rows > 0){
                    $row = $dataResult4->fetch_assoc();
                     echo "<tr>
                    <th scope='row'>4</th>
                    <td>Penilaian Awal Medis IGD</td>
                    <td>{$row['jumlah_penilaian']}</td>
                    <td>{$row['jumlah_non_penilaian']}</td>
                    </tr>";
                    
                    $total_lengkap += $row['jumlah_penilaian'];
                    $total_tidak_lengkap += $row['jumlah_non_penilaian'];                    
                  } else {
                    echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
                  }
                  ?>
                  <!-- End Data Penilaian Medis IGD -->

                  <!-- Data Pemeriksaan Rawat Jalan -->
                <?php
                  if ($dataResult5->num_rows > 0){
                    $row = $dataResult5->fetch_assoc();
                     echo "<tr>
                    <th scope='row'>5</th>
                    <td>Pemeriksaan Rawat Jalan</td>
                    <td>{$row['jumlah_pemeriksaan_ralan']}</td>
                    <td>{$row['jumlah_nonpemeriksaan_ralan']}</td>
                    </tr>";

                    $total_lengkap += $row['jumlah_pemeriksaan_ralan'];
                    $total_tidak_lengkap += $row['jumlah_nonpemeriksaan_ralan'];  
                  } else {
                    echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
                  }
                  ?>
                   <!-- End Data Pemeriksaan Rawat Jalan -->

                   <?php
                  if ($dataResult6->num_rows > 0){
                    $row = $dataResult6->fetch_assoc();
                     echo "<tr>
                    <th scope='row'>6</th>
                    <td>Penilaian Awal Medis Rawat Inap Umum</td>
                    <td>{$row['awal_ranap']}</td>
                    <td>{$row['nonawal_ranap']}</td>
                    </tr>";

                    $total_lengkap += $row['awal_ranap'];
                    $total_tidak_lengkap += $row['nonawal_ranap'];  
                  } else {
                    echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
                  }
                  ?>

                   <!-- Data Data Pemeriksaan Rawat Inap -->
                   <?php
                  if ($dataResult7->num_rows > 0){
                    $row = $dataResult7->fetch_assoc();
                     echo "<tr>
                    <th scope='row'>7</th>
                    <td>Pemeriksaan Rawat Inap</td>
                    <td>{$row['jumlah_pemeriksaan_ranap']}</td>
                    <td>{$row['jumlah_nonpemeriksaan_ranap']}</td>
                    </tr>";

                    $total_lengkap += $row['jumlah_pemeriksaan_ranap'];
                    $total_tidak_lengkap += $row['jumlah_nonpemeriksaan_ranap'];  
                  } else {
                    echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
                  }
                  ?>
                   <!-- End Data Pemeriksaan Rawat Inap -->

                   <?php
                  if ($dataResult8->num_rows > 0){
                    $row = $dataResult8->fetch_assoc();
                     echo "<tr>
                    <th scope='row'>8</th>
                    <td>Catatan Keperawatan</td>
                    <td>{$row['catatan_keperawatan_ranap']}</td>
                    <td>{$row['catatan_keperawatan_nonranap']}</td>
                    </tr>";

                    $total_lengkap += $row['catatan_keperawatan_ranap'];
                    $total_tidak_lengkap += $row['catatan_keperawatan_nonranap'];  
                  } else {
                    echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
                  }
                  ?>
                  
                  <?php
                  if ($dataResult9->num_rows > 0){
                    $row = $dataResult9->fetch_assoc();
                     echo "<tr>
                    <th scope='row'>9</th>
                    <td>Penilaian Lanjutan Risiko Jatuh Anak</td>
                    <td>{$row['resikojatuh_anak']}</td>
                    <td>{$row['nonresikojatuh_anak']}</td>
                    </tr>";

                    $total_lengkap += $row['resikojatuh_anak'];
                    $total_tidak_lengkap += $row['nonresikojatuh_anak'];  
                  } else {
                    echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
                  }
                  ?>

                  <?php
                  if ($dataResult10->num_rows > 0){
                    $row = $dataResult10->fetch_assoc();
                     echo "<tr>
                    <th scope='row'>10</th>
                    <td>Pemantauan EWS Anak</td>
                    <td>{$row['pews_anak']}</td>
                    <td>{$row['nonpews_anak']}</td>
                    </tr>";

                    $total_lengkap += $row['pews_anak'];
                    $total_tidak_lengkap += $row['nonpews_anak'];  
                  } else {
                    echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
                  }
                  ?>

                  <?php
                  if ($dataResult11->num_rows > 0){
                    $row = $dataResult11->fetch_assoc();
                     echo "<tr>
                    <th scope='row'>11</th>
                    <td>Transfer Pasien Antar Ruangan</td>
                    <td>{$row['pasien_antarruang']}</td>
                    <td>{$row['nonpasien_antarruang']}</td>
                    </tr>";

                    $total_lengkap += $row['pasien_antarruang'];
                    $total_tidak_lengkap += $row['nonpasien_antarruang'];  
                  } else {
                    echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
                  }
                  ?>

                  <?php
                  if ($dataResult12->num_rows > 0){
                    $row = $dataResult12->fetch_assoc();
                     echo "<tr>
                    <th scope='row'>12</th>
                    <td>Diagnosa Penyakit</td>
                    <td>{$row['diagnosa_pasien']}</td>
                    <td>{$row['nondiagnosa_pasien']}</td>
                    </tr>";

                    $total_lengkap += $row['diagnosa_pasien'];
                    $total_tidak_lengkap += $row['nondiagnosa_pasien'];  
                  } else {
                    echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
                  }
                  ?>

                  <?php
                  if ($dataResult21->num_rows > 0){
                    $row = $dataResult21->fetch_assoc();
                     echo "<tr>
                    <th scope='row'>13</th>
                    <td>Resume</td>
                    <td>{$row['resume_pasien']}</td>
                    <td>{$row['nonresume_pasien']}</td>
                    </tr>";

                    $total_lengkap += $row['resume_pasien'];
                    $total_tidak_lengkap += $row['nonresume_pasien'];  
                  } else {
                    echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
                  }
                  ?>
                  
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
                                <td>Lengkap</td>
                                <td class="w-25">: &nbsp;<span><?php echo $total_lengkap ?></span></td>
                            </tr>
                            <tr>
                                <td>Tidak Lengkap</td>
                                <td class="w-25">: &nbsp;<span><?php echo $total_tidak_lengkap ?></span></td>
                            </tr>
                            <!-- Perhitungan persentase -->
                            <tr>
                                <td>Persentase Kelengkapan</td>
                                <td class="w-25">: &nbsp;<span>
                                    <?php
                                        // Menghitung persentase lengkap
                                        $persentase_lengkap = ($total_lengkap / 13) * 100;
                                        echo number_format($persentase_lengkap, 2) . "%";
                                    ?>
                                </span></td>
                            </tr>
                        </tbody>
                    </table>
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