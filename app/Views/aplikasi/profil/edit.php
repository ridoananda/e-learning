<?= $this->extend("aplikasi/layout/template"); ?>

<?= $this->section("content"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-3 text-gray-800">Edit Profil </h1>

  <hr class="my-2 mb-3">
  <!-- Content Row -->
  <div class="row">
    <div class="col-md-10">
      <form action="/aplikasi/profil/update_profil" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <input type="hidden" name="foto_lama" value="<?= $user['foto'] ?>">
        <div class="form-group row">
          <label for="nama_lengkap" class="col-3 col-lg-2 col-form-label">Nama lengkap</label>
          <div class="col-9">
            <input type="text" class="form-control <?= ($validation->hasError('nama_lengkap')) ? 'is-invalid' : '' ?>" id="nama_lengkap" name="nama_lengkap" value="<?= (old('nama_lengkap')) ? old('nama_lengkap') : $user['nama_lengkap'] ?>">
            <div class="invalid-feedback">
              <?= $validation->getError('nama_lengkap') ?>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="alamat" class="col-3 col-lg-2 col-form-label">Alamat</label>
          <div class="col-9">
            <input type="text" class="form-control <?= ($validation->hasError('alamat')) ? 'is-invalid' : '' ?>" id="alamat" name="alamat" value="<?= (old('alamat')) ? old('alamat') : $user['alamat'] ?>">
            <div class="invalid-feedback">
              <?= $validation->getError('alamat') ?>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="image" class="col-3 col-lg-2 col-form-label">Foto : </label>
          <div class="col-9 col-md-6 mb-2">
            <div class="custom-file">
              <input type="file" class="custom-file-input <?= ($validation->hasError('image')) ? 'is-invalid' : '' ?>" id="image" name="image" accept="image/*">
              <div class="invalid-feedback">
                <?= $validation->getError('image') ?>
              </div>
              <label class="custom-file-label text-break" for="image"><?= $user['foto']; ?></label>
            </div>
          </div>
          <div class="col-4 col-md-3">
            <img src="/template/img/profil/<?= $user['foto']; ?>" id="imgPreview" class="img-thumbnail">
          </div>
        </div>
        <div class="form-group row mt-4">
          <div class="col d-flex justify-content-center">
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
  </div>

</div>

<?= $this->endSection(); ?>