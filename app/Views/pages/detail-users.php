<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title; ?></title>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/css/bootstrap.css">
  <link rel="stylesheet" href="/css/users.css">
  <link rel="stylesheet" href="/template/vendor/fontawesome-free/css/all.min.css">
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top custom-navbar shadow">
    <div class="container">
      <a class="navbar-brand font-weight-bold" href="/">E-Learning</a>
      <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav mt-2 mt-lg-0 align-items-center">
          <li class="nav-item">
            <a class="nav-link" href="/">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/#fitur">Fitur</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/artikel">Artikel</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/#hubungi">Hubungi Kami</a>
          </li>
          <li class="nav-item">
            <a class="nav-link btn-masuk mt-2 mt-lg-0" href="/masuk">
              <?= (session()->has('e')) ? '<i class="fas fa-user fa-sm fa-fw"></i> Dashboard Saya' : '<i class="fas fa-sign-in-alt fa-sm fa-fw"></i> Masuk'; ?>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">

    <?php if (session()->has('e') || empty($user)) : ?>
      <section id="konten">
        <div class="row justify-content-center mt-5">
          <div class="col-md-8 text-center">
            <p class="text-center mb-4 back" onclick="window.history.back()"><i class="fa fa-chevron-left fa-sm fa-fw"></i> Kembali</p>
            <?php if (session()->getFlashdata('berhasil')) : ?>
              <div class="alert alert-success">
                <?= session()->getFlashdata('berhasil') ?>
              </div>
            <?php endif ?>
            <?php if ($validation->hasError('alasan')) : ?>
              <div class="alert alert-danger">
                <?= $validation->getError('alasan') ?>
              </div>
            <?php endif ?>

            <img src="/template/img/profil/<?= $user['foto']; ?>" alt="Foto - <?= $user['nama_lengkap']; ?>" class="rounded-circle" width="180" height="180">

            <h4 class="mt-3 mb-0"><?= $user['nama_lengkap']; ?></h4>
            <small>
              <?php if ($user['role_id'] == 3) : ?>
                <?= $mapel['kelas']; ?> - <?= $mapel['jurusan']; ?>
              <?php elseif ($user['role_id'] == 2) : ?>
                Guru - <?= $mapel['mapel']; ?>
              <?php else : ?>
                Admin
              <?php endif ?>
            </small>

            <?php if ($user['id'] != session()->get('id')) : ?>
              <div class="row justify-content-center mt-4">
                <div class="col-10 col-lg-6">
                  <div class="row box d-flex justify-content-center pt-3 pb-1">
                    <!-- <div class="col-4">
                  <i class="far fa-thumbs-up fa-2x fa-fw"></i>
                  <p class="like d-block font-weight-bold mt-1">120</p>
                </div>
                <div class="col-4">
                  <i class="far fa-thumbs-down fa-2x fa-fw"></i>
                  <p class="unlike d-block font-weight-bold mt-1">90</p>
                </div> -->
                    <div class="col-4" data-target="#laporkanModal" data-toggle="modal">
                      <div class="laporkan">
                        <i class="fas fa-exclamation fa-2x fa-fw"></i>
                        <p class="font-weight-bold mt-1">Laporkan</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endif ?>
          </div>
        </div>
      </section>
    <?php else : ?>
      <div class="row mt-5 justify-content-center text-center">
        <div class="col">
          <h3 class="mt-5">Upss... Masuk untuk melihat</h3>
          <a class="btn btn-primary rounded-pill" href="/masuk" role="button">Masuk</a>
        </div>
      </div>
    <?php endif ?>
  </div>

  <!-- Laporkan Modal -->
  <div class="modal fade" id="laporkanModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Laporkan <?= $user['nama_lengkap']; ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="/laporan" method="post">
          <div class="modal-body">
            <h5>Alasan pelaporan :</h5>
            <input type="hidden" name="user_id" value="<?= $user['id']; ?>">
            <input type="hidden" name="email" value="<?= $user['email']; ?>">
            <input type="hidden" name="user_lapor_id" value="<?= session()->get('id') ?>">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" name="alasan1" id="customCheck1">
              <label class="custom-control-label" for="customCheck1">Berperilaku buruk</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" name="alasan2" id="customCheck2">
              <label class="custom-control-label" for="customCheck2">Menyalahgunakan Akun</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" name="alasan3" id="customCheck3">
              <label class="custom-control-label" for="customCheck3">Berkata tidak sopan</label>
            </div>
            <div class="form-group mt-2">
              <textarea class="form-control" name="alasan" rows="4" placeholder="Alasan lainnya ..."></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Kirim</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <script src="/js/jquery.min.js"></script>
  <script src="/js/jquery.easing.min.js"></script>
  <script src="/js/bootstrap.min.js"></script>
  <script src="/js/main.js"></script>
</body>

</html>