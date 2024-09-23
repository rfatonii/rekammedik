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
            <div class="col-md-12 mt-4">

                <div class="card m-auto border-0 p-5">
                    <div class="row">
                        <div class="col-md-6 text-end img-bgo">
                            <img src="../img/landing.png" alt="" class="p-3" style="width:342px;height:232;">
                            <img src="../img/text.png" alt="" class="p-3" style="width:342px;height:232;">
                        </div>
                        <!-- BELUM SELESAI UNTUK TATA LETAKNYA -->
                        <div class="col-md-6">
                            <div class="container">
                                <div class="row d-block">
                                    <form action="signup_process.php" method="POST">
                                        
                                        <div class="col-md-6 mb-2">
                                            <div class="mb-2">
                                                <label for="exampleInputEmail1" class="form-label mx-2">Email</label>
                                                <input type="email" name="email" class="form-control btn-login mb-1 pt-1 border-0 m-auto" id="exampleInputEmail1" aria-describedby="emailHelp">
                                            </div>    
                                            
                                            <div class="mb-2">
                                                <label for="exampleInputName1" class="form-label mx-2">Nama</label>
                                                <input type="text" name="nama" class="form-control btn-login mb-1 pt-1 border-0 m-auto" id="exampleInputName1" aria-describedby="nameHelp">
                                            </div>   

                                            <div class="mb-2">
                                                <label for="exampleInputNik1" class="form-label mx-2">Nik</label>
                                                <input type="tel" name="nik" class="form-control btn-login mb-1 pt-1 border-0 m-auto" id="exampleInputNik1" aria-describedby="nikHelp">
                                            </div>   

                                            <div class="mb-2">
                                                <label for="exampleInputUsername1" class="form-label mx-2">Username</label>
                                                <input type="text" name="username" class="form-control btn-login mb-1 pt-1 border-0 m-auto" id="exampleInputusername1" aria-describedby="emailusername">
                                            </div>   

                                            <div class="mb-2">
                                                <label for="exampleInputPassword1" class="form-label mx-2">Password</label>
                                                <input type="password" name="password" class="form-control btn-login mb-1 pt-1 border-0 m-auto" id="exampleInputPassword1" aria-describedby="passwordHelp">
                                            </div>   

                                            <div class="mb-2">
                                                <label for="exampleInputPassConfirm1" class="form-label mx-2">Konfirmasi Password</label>
                                                <input type="password" name="confirm_password" class="form-control btn-login mb-1 pt-1 border-0 m-auto" id="exampleInputPassConfirm1" aria-describedby="emailPassConfirm">
                                            </div>   

                                            <div class="mb-2">
                                                <label for="exampleInputPassConfirm1" class="form-label mx-2">Jenis User</label>
                                                <select class="form-select btn-login mb-1 pt-1 border-0 m-auto" name="user_type" aria-label="Default select example">
                                                    <option selected>Pilih Jenis User</option>
                                                    <option value="1">Administrator</option>
                                                    <option value="2">User Client</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>  
                                        </div>

                                        <div class="col-md-6 mt-3">
                                            <button type="submit" class="btn btn-sign d-block mb-1 pt-2 m-auto fw-bold" style="background-color:#ED3237;">Sign Up</button>
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