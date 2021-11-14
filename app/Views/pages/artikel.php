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
            <a class="nav-link active" href="#artikel">Artikel</a>
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

  <section id="artikel">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <h1>Artikel</h1>
          <form action="" method="post" autocomplete="off">
            <div class="input-group mb-4 cari-artikel">
              <input type="text" class="form-control rounded-pill pl-3 mr-2 shadow-none" placeholder="Cari artikel disini ..." name="keyword">
              <div class="input-group-append">
                <button class="btn rounded-pill" type="submit" name="submit" id="button-addon2"><i class="fas fa-search fa-sm fa-fw"></i></button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <?php if ($artikel) : ?>
        <div class="row">
          <?php foreach ($artikel as $art) :
            $user_upload = $db->table('user')->where(['id' => $art['user_id']])->get()->getRow();
            $kategori = $db->table('kategori_artikel')->where(['id' => $art['kategori_id']])->get()->getRow();
            $komentar = $db->table('komentar_artikel')->where(['artikel_id' => $art['id']])->countAllResults();
          ?>
            <div class="col-lg-4 col-sm-6">
              <div class="card mb-3 shadow">
                <img src="/template/img/thumbnail/<?= $art['thumbnail']; ?>" class="card-img-top" alt="Thumbnail artikel">
                <div class="card-body">
                  <h4 class="judul-artikel"><?= $art['judul']; ?></h4>
                  <small class="text-muted d-block mb-2">
                    <div class="mb-1">
                      <span class="mr-2 d-inline-block"><i class="far fa-user fa-fw"></i> <?= $user_upload->nama_lengkap; ?></span>
                      <span><i class="far fa-folder-open fa-fw"></i> <?= $kategori->kategori; ?></span>
                    </div>
                    <div>
                      <span class="d-inline-block mr-2"><i class="far fa-clock fa-fw"></i> <?= tanggal_lengkap($art['created_at']); ?></span>
                      <span><i class="far fa-comments fa-fw"></i> <?= $komentar; ?> Komentar</span>
                    </div>
                  </small>
                  <div class="isi-text text-break"><?php //substr($art['text'], 0, 80); ?></div>
                  <a class="btn d-block btn-baca-selengkapnya" href="/artikel/<?= $art['slug']; ?>" role="button">Baca Selengkapnya <i class="fas fa-chevron-right fa-xs fa-fw"></i></a>
                </div>
              </div>
            </div>
          <?php endforeach ?>
        </div>
      <?php else : ?>
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <div class="alert alert-info text-center" role="alert">
              Artikel Tidak ditemukan!
              <br>
              <a href="/artikel" class="small text-decoration-none">&laquo; Kembali</a>
            </div>
          </div>
        </div>
      <?php endif ?>
      <div class="row my-2">
        <div class="col d-flex justify-content-center">
          <?= $pager->links('artikel', 'artikel'); ?>
        </div>
      </div>
    </div>
  </section>
</div>


<?= $this->endSection(); ?>