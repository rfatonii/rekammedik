<!doctype html>
<html lang="en">
  <head>
  <title>Cek Rekam Medik</title>
  <?php include '../include/head.php'; ?>
  <link rel="stylesheet" href="../include/style.css">
  </head>
  <body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 top-wrapper mt-4">

                <div class="card m-auto border-0">
                    <div class="row">
                        <div class="col-md-6 text-end">
                            <img src="../img/landing.png" alt="" class="p-3" style="width:342px;height:232;">
                            <img src="../img/text.png" alt="" class="p-3" style="width:342px;height:232;">
                        </div>
                        <!-- BELUM SELESAI UNTUK TATA LETAKNYA -->
                        <div class="col-md-6 btn-wrapper text-white">
                            <div class="container">
                                <div class="row d-block">
                                    <form action="login_process.php" method="POST">
                                        <div class="col-md-6 mb-2">
                                            <input type="text" name="username" class="form-control btn-login mb-1 pt-1 border-0 m-auto" placeholder="Username" required>
                                            <input type="password" name="password" class="form-control btn-login mb-1 pt-1 border-0 m-auto" placeholder="Password" required>
                                            <a href="#" id="emailHelp" class="fgt-pass px-2">Forgot Password ?</a>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-sign d-block mb-1 pt-2 m-auto fw-bold" style="background-color:#ED3237;">Log In</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                         <!-- BELUM SELESAI UNTUK TATA LETAKNYA -->
                    </div>
                </div>

            </div>
        </div>
    </div>
  <?php include '../include/footer.php'; ?>
  </body>
</html>




<button type="button" class="btn btn-primary" id="liveToastBtn">Show live toast</button>


<?php if (isset($_GET['error'])): ?>
<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <img src="..." class="rounded me-2" alt="...">
      <strong class="me-auto">Bootstrap</strong>
      <small>11 mins ago</small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      Hello, world! This is a toast message.
    </div>
  </div>
</div>



    <div class="alert alert-danger">
        <?php
        if ($_GET['error'] == 'wrongpassword') {
            echo "Password salah!";
        } elseif ($_GET['error'] == 'nouser') {
            echo "Username tidak ditemukan!";
        }
        ?>
    </div>
<?php endif; ?>