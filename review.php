<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // otewe ke login jika user belum login
    exit();
}
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
            <h1 class="m-0 fw-bold">Daftar Rekam Medis Telah di Review</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
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
            <div class="col-12">
                <table class="table table-striped">
                <thead>
                    <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Pasien</th>
                    <th scope="col">Jenis bedah</th>
                    <th scope="col">Tanggal Masuk</th>
                    <th scope="col">Tanggal Keluar</th>
                    <th scope="col">Jenis Pasien</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row">1</th>
                    <td>Angnes mo</td>
                    <td>Non bedah</td>
                    <td>01-02-2024</td>
                    <td>03-02-2024</td>
                    <td>Dewasa</td>
                    </tr>

                    <tr>
                    <th scope="row">2</th>
                    <td>Angnes mo</td>
                    <td>Non bedah</td>
                    <td>01-02-2024</td>
                    <td>03-02-2024</td>
                    <td>Dewasa</td>
                    </tr>

                    <tr>
                    <th scope="row">3</th>
                    <td>Angnes mo</td>
                    <td>Non bedah</td>
                    <td>01-02-2024</td>
                    <td>03-02-2024</td>
                    <td>Dewasa</td>
                    </tr>

                    <tr>
                    <th scope="row">4   </th>
                    <td>Angnes mo</td>
                    <td>Non bedah</td>
                    <td>01-02-2024</td>
                    <td>03-02-2024</td>
                    <td>Dewasa</td>
                    </tr>
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