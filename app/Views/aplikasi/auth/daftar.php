<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Daftar Akun - Yapim Taruna Marelan</title>

  <!-- Custom fonts for this template-->
  <link href="/template/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="/template/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-6 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row justify-content-center">
              <div class="col-lg-10">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Form Daftar Akun</h1>
                  </div>
                  <form class="user" action="/auth/validasi_daftar" method="post" autocomplete="off">
                    <div class="form-group row">
                      <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="text" class="form-control form-control-user <?= ($validation->hasError('namaLengkap')) ? 'is-invalid' : '' ?>" id="exampleFirstName" placeholder="Nama Lengkap" name="namaLengkap" value="<?= old('namaLengkap') ?>">
                        <div class="invalid-feedback ml-3"><?= $validation->getError('namaLengkap'); ?></div>
                      </div>
                      <div class="col-sm-6">
                        <input type="text" class="form-control form-control-user <?= ($validation->hasError('email')) ? 'is-invalid' : '' ?>" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Masukan Email" name="email" value="<?= old('email') ?>">
                        <small class="form-text text-muted ml-3">
                          Email harus aktif, agar dapat mengirim pemberitahuan tugas & absen
                        </small>
                        <div class="invalid-feedback ml-3"><?= $validation->getError('email'); ?></div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="password" class="form-control form-control-user <?= ($validation->hasError('password')) ? 'is-invalid' : '' ?>" id="exampleInputPassword" placeholder="Password" name="password" value="<?= old('password') ?>">
                        <div class="invalid-feedback ml-3"><?= $validation->getError('password'); ?></div>
                      </div>
                      <div class="col-sm-6">
                        <input type="password" class="form-control form-control-user <?= ($validation->hasError('konfPassword')) ? 'is-invalid' : '' ?>" id="exampleRepeatPassword" placeholder="Konfirmasi password" name="konfPassword" value="<?= old('konfPassword') ?>">
                        <div class="invalid-feedback ml-3">
                          <?= $validation->getError('konfPassword'); ?>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <select class="form-control rounded-pill <?= ($validation->hasError('mapel_id')) ? 'is-invalid' : '' ?>" name="mapel_id" id="mapel_id">
                        <option value="">Pilih Kelas dan Jurusan</option>
                        <?php foreach ($mapel as $m) : ?>
                          <option value="<?= $m['id']; ?>"><?= $m['kelas']; ?> - <?= $m['jurusan']; ?></option>
                        <?php endforeach ?>
                      </select>
                      <div class="invalid-feedback ml-3">
                        <?= $validation->getError('mapel_id'); ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user <?= ($validation->hasError('alamat')) ? 'is-invalid' : '' ?>" id="exampleInputEmail" placeholder="Alamat" name="alamat" value="<?= old('alamat') ?>">
                      <div class="invalid-feedback ml-3"><?= $validation->getError('alamat'); ?></div>
                    </div>
                    <button class="btn btn-primary btn-user btn-block" type="submit">
                      Daftar
                    </button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small text-decoration-none" href="/lupa-password">Lupa Password</a>
                  </div>
                  <div class="text-center">
                    <a class="small text-decoration-none" href="/masuk">Sudah punya akun? Masuk!</a>
                  </div>
                  <div class="text-center mt-3">
                    <a class="small text-decoration-none" href="/"><i class="fas fa-home fa-sm fa-fw"></i> Halaman awal</a>
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

</body>

</html>