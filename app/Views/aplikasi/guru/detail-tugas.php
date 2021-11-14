<?= $this->extend('aplikasi/layout/template') ?>
<?= $this->section('content') ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="/aplikasi/guru"><i class="fa fa-home fa-fw fa-sm"></i> home</a></li>
    <li class="breadcrumb-item"><a href="/aplikasi/guru/tugas"><i class="fas fa-clipboard-list fa-sm fa-fw"></i> tugas kelas</a></li>
    <li class="breadcrumb-item active"><?= $tugas['judul']; ?></li>
  </ol>

  <div class="row mb-5">

    <div class="col-md-6">
      <?php if (session()->getFlashdata('berhasil')) : ?>
        <div class="alert alert-success">
          <?= session()->getFlashdata('berhasil') ?>
        </div>
      <?php endif ?>
      <?php if ($validation->getErrors()) : ?>
        <div class="alert alert-danger">
          <?= $validation->listErrors() ?>
        </div>
      <?php endif ?>
      <div class="mr-3 float-left">
        <a href="/users/<?= $user_tugas['email']; ?>">
          <img class="rounded-circle" src="/template/img/profil/<?= $user_tugas['foto']; ?>" width="60" height="60">
        </a>
      </div>
      <a href="/users/<?= $user_tugas['email']; ?>" class="h5 text-dark font-weight-bold text-decoration-none"><?= $user_tugas['nama_lengkap']; ?></a>
      <div class="small text-gray-500"><?= tanggal_lengkap($tugas['created_at']); ?> - <?= jam($tugas['created_at']); ?></div>
      <hr class="mb-3 mt-4">
      <p class="text-left text-break" style="white-space: pre-line;"><?= $tugas['deskripsi']; ?></p>
      <?php if (!empty($file_tugas)) : ?>
        <div class="text-gray-600 mb-1 text-left" style="white-space: pre-line;">Lampiran</div>

        <?php foreach ($file_tugas as $file) : ?>
          <?php if ($file['ext'] == 'jpg' || $file['ext'] == 'png' || $file['ext'] == 'jpeg') : ?>
            <div class="mb-2">
              <span class="d-block text-primary"><i class="fas fa-image fa-sm fa-fw"></i> <?= $file['name']; ?></span>
              <span>
                <a class="text-gray-600 small text-decoration-none" href="/aplikasi/guru/download/<?= $file['name']; ?>" class="text-primary d-inline" onclick="return confirm('Download file ini?')"><i class="fas fa-file-download fa-sm fa-fw"></i> download</a>
              </span>
              <span id="lihat" class="small text-gray-600" data-target="#gambarModal" data-toggle="modal" data-src="<?= $file['name']; ?>">
                <i class="fas fa-eye fa-sm fa-fw"></i> lihat
              </span>
            </div>
          <?php elseif ($file['ext'] == 'mp4' || $file['ext'] == '3gp' || $file['ext'] == 'mov') : ?>
            <video class="img-fluid rounded" controls>
              <source src="/file/tugas/<?= $file['name']; ?>" type="video/<?= $file['ext']; ?>">
              Browser kamu tidak mendukung Video!
            </video>
          <?php else : ?>
            <a href="/aplikasi/guru/download/<?= $file['name']; ?>" class="text-primary d-block text-decoration-none" onclick="return confirm('Download file ini?')"><i class="fas fa-file-alt fa-sm fa-fw"></i> <?= $file['name']; ?></a>
          <?php endif ?>
        <?php endforeach ?>

      <?php endif ?>
      <hr class="my-3">
    </div>
    <div class="col-md-6">
      <h5 class="text-capitalize mb-2"><?= $komentar->where('tugas_id', $id)->countAllResults() . ' Komentar Kelas'; ?></h5>
      <?php foreach ($komentar->where('tugas_id', $id)->get()->getResultArray() as $k) :
        $user_komen = $db->table('user')->where('id', $k['user_id'])->get()->getRowArray();
      ?>
        <div class="row mt-3">
          <div class="col-auto">
            <a href="/users/<?= $user_komen['email']; ?>">
              <img class="rounded-circle" src="/template/img/profil/<?= $user_komen['foto']; ?>" width="50" height="50">
            </a>
          </div>
          <div class="col">
            <a href="/users/<?= $user_komen['email']; ?>" class="text-decoration-none mb-0 font-weight-bold d-block <?= ($user_komen['id'] == $user['id']) ? 'text-info' : 'text-dark'; ?>">
              <?= $user_komen['nama_lengkap']; ?>
              <span class="text-gray-600 small"><?= waktu_lalu($k['created_at']); ?></span>
            </a>
            <span class="text-break"><?= $k['komentar']; ?></span>
          </div>
        </div>
      <?php endforeach ?>

      <!-- Komentar -->
      <form action="/aplikasi/guru/tambah-komentar" method="post">
        <?= csrf_field(); ?>
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="id" value="<?= $id; ?>">
        <hr class="my-3">
        <div class="form-group row">
          <div class="col-10">
            <input type="text" class="form-control <?= ($validation->hasError('title')) ? 'is-invalid' : '' ?>" id="komentar" name="komentar" value="<?= old('komentar') ?>" placeholder="Tulis komentar..." autocomplete="off">
            <div class="invalid-feedback">
              <?= $validation->getError('komentar') ?>
            </div>
          </div>
          <div class="col-2">
            <button type="submit" class="btn btn-primary rounded-pill"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
          </div>
        </div>
      </form>
    </div>

  </div>
</div>
<!-- /.container-fluid -->

<!-- GAMBAR MODAL -->
<div class="modal fade" id="gambarModal" tabindex="-1" role="dialog" aria-labelledby="gambarModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <!-- <div class="modal-body"> -->
      <img src="" class="img-fluid rounded" id="img">
      <!-- </div> -->
      <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">tutup</button>
        <a href="#" id="lihatPenuh" class="btn btn-sm btn-primary">lihat penuh</a>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>