<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Mari belajar online bersama dengan aplikasi ini">
  <meta name="og:title" content="Masuk Ke Aplikasi Sekarang">
  <meta name="author" content="Rido Ananda">
  <meta property="og:image" content="<?= base_url('/template/img/images.jpeg'); ?>">
  <meta property="og:image:type" content="image/jpeg">
  <meta property="og:image:width" content="569">
  <meta property="og:image:height" content="539">

  <title>Masuk Aplikasi - Yapim Taruna Marelan</title>

  <!-- Custom fonts for this template-->
  <link href="/template/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="/template/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-8 col-lg-6 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row justify-content-center">
              <div class="col-lg-8">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Silahkan Masuk</h1>
                    <?php if (session()->getFlashdata('pesan')) : ?>
                      <div class="alert alert-danger">
                        <small><?= session()->getFlashdata('pesan') ?></small>
                      </div>
                    <?php endif ?>
                    <?php if (session()->getFlashdata('berhasil')) : ?>
                      <div class="alert alert-success">
                        <small><?= session()->getFlashdata('berhasil') ?></small>
                      </div>
                    <?php endif ?>
                  </div>

                  <form class="user" method="post" action="/auth/validasi">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user <?= ($validation->hasError('email')) ? 'is-invalid' : '' ?>" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Masukan Email" name="email" value="<?= old('email') ?>">
                      <div class="invalid-feedback ml-3"><?= $validation->getError('email'); ?></div>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user <?= ($validation->hasError('password')) ? 'is-invalid' : '' ?>" id="exampleInputPassword" placeholder="Password" name="password" value="<?= old('password') ?>">
                      <div class="invalid-feedback ml-3"><?= $validation->getError('password'); ?></div>
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck" name="ingat" value="oke" checked>
                        <label class="custom-control-label" for="customCheck">Ingat Saya </label>
                        <span id="ingat"><i class="far fa-question-circle fa-fw mt-1"></i></span>
                      </div>
                    </div>
                    <button class="btn btn-primary btn-user btn-block" type="submit" name="submit">
                      Masuk
                    </button>

                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small text-decoration-none" href="/lupa-password">Lupa Password</a>
                  </div>
                  <div class="text-center">
                    <a class="small text-decoration-none" href="/daftar">Belum punya akun? Daftar disini</a>
                  </div>
                  <div class="text-center mt-3">
                    <a class="small text-decoration-none" href="/"><i class="fas fa-home fa-sm fa-fw"></i> Halaman awal</a>
                  </div>
                  <div class="text-center mt-1">
                    <p class="small">Jika ada kendala dalam aplikasi silahkan hubungi admin</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="/template/vendor/jquery/jquery.min.js"></script>
  <script src="/template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="/template/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="/template/js/sb-admin-2.min.js"></script>
  <!-- Sweet alert -->
  <script src="/template/js/swal.js"></script>

  <script>
    $('#ingat').click(function() {
      swal('Apa itu Ingat Saya ?', 'Ketika kamu centang tombol ingat saya, maka kamu tetap berada dihalaman dashboard kamu dan tidak perlu login lagi', 'info');
    });
  </script>
</body>

</html>