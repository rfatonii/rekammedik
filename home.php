
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
  <title>Cek Rekam Medik Elektronik</title>
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
            <h1 class="m-0 fw-bold">Dashboard</h1>
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

         <div class="col-3">
            <div class="card mt-3 text-center" style="background: #F5B1B1;">    
                <div class="card-header">
                  <p class="fw-bold" style="font-size: 6em;">30</p>
                </div>
                <div class="card-body">
                  <p class="fw-semibold" style="font-size: 22px;">Review Rekam Medis Elektronik Harian</p>
                </div>
            </div>
         </div>

         <div class="col-4">
            <div class="card mt-3 text-center" style="background: #FFD9CB;">    
                <div class="card-header">
                  <p class="fw-bold" style="font-size: 4em;">239</p>
                </div>
                <div class="card-body">
                  <p class="fw-semibold" style="font-size: 20px;">Review Rekam Medis Elektronik Harian</p>
                </div>
            </div>
         </div>

         <div class="col-4">
            <div class="card mt-3 text-center" style="background: #F9D7D8;">    
                <div class="card-header">
                  <p class="fw-bold" style="font-size: 4em;color:#F44336">1826</p>
                </div>
                <div class="card-body">
                  <p class="fw-semibold" style="font-size: 20px;">Review Rekam Medis Elektronik Harian</p>
                </div>
            </div>
         </div>

        </div>
        <!-- /.row -->
<!-- FILTER DATA BELUM SELESAI -->
        <div class="row">
          <div class="col-4">
            <div class="accordion" id="accordionExample">
              <div class="accordion-item">
                <h1 class="accordion-header">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="background: #F5B1B1;">
                    <span class="m-auto ps-5 fs-6 fw-bold">Filter Data</span>
                  </button>
                </h1>
                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                  <div class="">
                    <ul class="list-group">
                      <li class="list-group-item" style="background: #F5B1B1;">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                          <label class="form-check-label ms-4" for="flexCheckChecked">

                            <div class="row">
                              <div class="form-check col-4">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                <label class="form-check-label pe-3" for="flexRadioDefault2">
                                  Harian
                                </label>
                              </div>
                              <div class="form-check col-4">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                <label class="form-check-label pe-3" for="flexRadioDefault2">
                                  Bulanan
                                </label>
                              </div>
                              <div class="form-check col-4">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                <label class="form-check-label pe-3" for="flexRadioDefault2">
                                  Tahunan
                                </label>
                              </div>
                            </div>

                          </label>
                        </div>
                      </li>
                      <li class="list-group-item" style="background: #F5B1B1;">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                          <label class="form-check-label ms-4" for="flexCheckChecked">

                            <div class="container">
                              <div class="row">
                              
                              <div class="col-6">
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                  <label class="form-check-label pe-3" for="flexRadioDefault2">
                                    Tanggal masuk
                                  </label>
                                </div>
                              </div>

                              <div class="col-6">
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                  <label class="form-check-label pe-3" for="flexRadioDefault2">
                                    Tanggal Keluar
                                  </label>
                                </div>
                              </div>

                              

                              </div>
                            </div>

                          </label>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                          <label class="form-check-label" for="flexCheckChecked">
                            Checked checkbox
                          </label>
                        </div>
                      </li>
                      <li class="list-group-item">A fourth item</li>
                      <li class="list-group-item">And a fifth one</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
<!-- FILTER DATA BELUM SELESAI -->

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
</div>
<!-- ./wrapper -->

<?php include 'include/footer.php'?>

</body>
</html>
