<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div id="artikel">
  <nav class="navbar navbar-expand-lg navbar-light fixed-top custom-navbar shadow">
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
            <a class="nav-link active" href="/artikel">Artikel</a>
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

  <section id="detail-artikel">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <h3 class="text-break"><?= $artikel->judul; ?></h3>
          <p class="text-muted d-block">
            <span class="mr-2 d-inline-block">
              <i class="far fa-user fa-fw"></i> <?= $user_upload->nama_lengkap; ?>
            </span>
            <span>
              <i class="far fa-folder-open fa-fw"></i> <?= $kategori->kategori; ?>
            </span>
            <span class="d-block mr-2">
              <i class="far fa-clock fa-fw"></i> <?= tanggal_lengkap($artikel->created_at); ?>
            </span>
            <span><i class="far fa-comments fa-fw"></i> <?= $komentar ?> Komentar</span>
          </p>
          <?php if ($validation->getErrors()) : ?>
            <div class="alert alert-danger">
              <?= $validation->listErrors() ?>
            </div>
          <?php endif ?>

          <?php if (session()->getFlashdata('berhasil')) : ?>
            <div class="alert alert-success">
              <?= session()->getFlashdata('berhasil') ?>
            </div>
          <?php endif ?>

          <img src="/template/img/thumbnail/<?= $artikel->thumbnail; ?>" class=" img-fluid thumbnail text-center">
          <div class="text mt-4 text-break">
            <?= $artikel->text; ?>
          </div>

          <h4><?= ($komentar == 0) ? 'Tidak ada' : $komentar ?> Komentar</h4>
          <hr class="my-3">

          <?php foreach ($db->table('komentar_artikel')->where(['artikel_id' => $artikel->id])->get()->getResult() as $k) :
            $user_komentar = $db->table('user')->where(['id' => $k->user_id])->get()->getRow() ?>
            <div class="row mt-2">
              <div class="col-auto pr-0">
                <a href="/users/<?= $user_komentar->email; ?>">
                  <img src="/template/img/profil/<?= $user_komentar->foto; ?>" alt="Foto Profil" class="rounded-circle d-inline" width="50" height="50">
                </a>
              </div>
              <div class="col">
                <div class="info-komentar">
                  <a href="/users/<?= $user_komentar->email; ?>" class="<?= ($user_komentar->id == session()->get('id')) ? 'text-info' : ''; ?> text-decoration-none nama-lengkap"><?= $user_komentar->nama_lengkap; ?></a>
                  <p class="text-break text-komentar"><?= $k->text; ?></p>
                </div>
                <div class="tanggal-komentar d-inline">
                  <i class="far fa-clock fa-fw"></i> <?= jam($k->created_at); ?>
                  <i class="far fa-calendar fa-sm fa-fw"></i> <?= tanggal_lengkap($k->created_at); ?>
                </div>
              </div>
            </div>
          <?php endforeach ?>
          <div class="row my-4">
            <?php if (session()->has('e')) : ?>
              <div class="col tambah-komentar">
                <hr class="my-3">
                <h4>Tulis Komentar</h4>
                <form action="/add-komentar" method="POST">
                  <input type="hidden" name="slug" value="<?= $artikel->slug; ?>">
                  <div class="form-group">
                    <textarea type="password" class="form-control" rows="3" name="text"></textarea>
                  </div>
                  <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Kirim</button>
                  </div>
                </form>
              </div>
            <?php else : ?>
              <div class="col text-center">
                <h4>Masuk Untuk Komentar!</h4>
                <a class="btn btn-primary rounded-pill" href="/masuk" role="button">Masuk</a>
              </div>
          </div>
        <?php endif ?>
        </div>
      </div>
    </div>
</div>
</section>
</div>


<?= $this->endSection(); ?>