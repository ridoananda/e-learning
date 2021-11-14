<?= $this->extend('aplikasi/layout/template') ?>
<?= $this->section('content') ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800">Ubah Password</h1>
  <hr class="my-2">
  <?php if (session()->getFlashdata('gagal')) : ?>
    <div class="row">
      <div class="col col-lg-9">
        <div class="alert text-center alert-danger mb-3">
          <?= session()->getFlashdata('gagal') ?>
        </div>
      </div>
    </div>
  <?php endif ?>

  <form action="/aplikasi/profil/update_password" method="post" enctype="multipart/form-data">
    <?= csrf_field(); ?>
    <div class="form-group row align-items-center">
      <label for="password_lama" class="col-3 col-lg-2 col-form-label">Password lama</label>
      <div class="col-9 col-lg-7">
        <input type="password" class="form-control <?= ($validation->hasError('password_lama')) ? 'is-invalid' : '' ?>" id="password_lama" name="password_lama" value="<?= old('password_lama') ?>">
        <div class="invalid-feedback">
          <?= $validation->getError('password_lama') ?>
        </div>
      </div>
    </div>
    <div class="form-group row align-items-center">
      <label for="password_baru" class="col-3 col-lg-2 col-form-label">Password baru</label>
      <div class="col-9 col-lg-7">
        <input type="password" class="form-control <?= ($validation->hasError('password_baru')) ? 'is-invalid' : '' ?>" id="password_baru" name="password_baru" value="<?= old('password_baru') ?>">
        <div class="invalid-feedback">
          <?= $validation->getError('password_baru') ?>
        </div>
      </div>
    </div>
    <div class="form-group row align-items-center">
      <label for="ulang_password_baru" class="col-3 col-lg-2 col-form-label">Konfirmasi Password baru</label>
      <div class="col-9 col-lg-7">
        <input type="password" class="form-control <?= ($validation->hasError('konf_password_baru')) ? 'is-invalid' : '' ?>" id="konf_password_baru" name="konf_password_baru" value="<?= old('konf_password_baru') ?>">
        <div class="invalid-feedback">
          <?= $validation->getError('konf_password_baru') ?>
        </div>
      </div>
    </div>
    <div class="form-group row mt-4">
      <div class="col-lg-10 d-flex justify-content-center">
        <button type="submit" class="btn btn-primary btn-icon-split btn-sm">
          <span class="icon text-white-50">
            <i class="fas fa-pen"></i>
          </span>
          <span class="text">Edit</span>
        </button>
      </div>
    </div>
  </form>

</div>
<!-- /.container-fluid -->

<?= $this->endSection() ?>