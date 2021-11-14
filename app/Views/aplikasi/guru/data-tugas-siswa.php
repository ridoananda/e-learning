<?= $this->extend('aplikasi/layout/template') ?>
<?= $this->section('content') ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h4 mb-1 text-gray-800">Data Tugas <?= $user_tugas['nama_lengkap']; ?></h1>
  <?php if ($data_tugas != NULL) : ?>

    <div class="row mt-3">
      <div class="col-md-8 mb-3">
        <h4>File / Foto</h4>
        <hr class="my-2">
        <div class="row">
          <?php foreach ($file_data_tugas as $file) : ?>
            <?php if ($file['ext'] == 'jpg' || $file['ext'] == 'png' || $file['ext'] == 'jpeg') : ?>
              <div class="mb-2 col-sm-6 col-md-4">
                <img src="/file/tugas/<?= $file['name']; ?>" alt="<?= $file['name']; ?>" class="rounded img-fluid">
                <a href="/aplikasi/guru/download/<?= $file['name']; ?>" class="text-gray-700 d-block text-decoration-none small mt-2 text-center" onclick="return confirm('Download Foto ini?')"><i class="fas fa-download fa-sm fa-fw"></i> Download</a>
              </div>
            <?php elseif ($file['ext'] == 'mp4' || $file['ext'] == '3gp' || $file['ext'] == 'mov') : ?>
              <div class="mb-2 col-sm-6 col-md-4">
                <span class="d-block text-primary mb-1 text-break">
                  <i class="fas fa-file-video fa-sm fa-fw"></i> <?= $file['name']; ?>
                </span>
                <video class="img-fluid rounded" controls>
                  <source src="/file/tugas/<?= $file['name']; ?>" type="video/<?= $file['ext']; ?>">
                  Browser kamu tidak mendukung Video!
                </video>
                <a href="/aplikasi/guru/download/<?= $file['name']; ?>" class="text-gray-700 d-block text-decoration-none small mt-2 text-center" onclick="return confirm('Download Foto ini?')"><i class="fas fa-download fa-sm fa-fw"></i> Download</a>
              </div>
            <?php else : ?>
              <div class="col">
                <a href="/aplikasi/guru/download/<?= $file['name']; ?>" class="text-primary d-block text-decoration-none" onclick="return confirm('Download file ini?')">
                  <i class="fas fa-file-alt fa-sm fa-fw"></i> <?= $file['name']; ?>
                </a>
              </div>
            <?php endif ?>
          <?php endforeach ?>
        </div>
        <div class="form-group mt-3">
          <label for="deskripsi">Deskripsi :</label>
          <textarea class="form-control" id="deskripsi" rows="4" readonly><?= $data_tugas['deskripsi']; ?></textarea>
        </div>
      </div>
    </div>
</div>


<?php else : ?>

  <div class="row">
    <div class="col-md-4">
      <div class="alert alert-primary mt-3" role="alert">
        <span><i class="fa fa-info-circle" aria-hidden="true"></i> Data tugas belum tersedia</span>
      </div>
    </div>
  </div>

<?php endif ?>
</div>
<!-- /.container-fluid -->

<?= $this->endSection() ?>