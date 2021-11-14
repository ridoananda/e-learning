<?= $this->extend("aplikasi/layout/template"); ?>

<?= $this->section("content"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-3 text-gray-800">Tambah Artikel</h1>

  <hr class="my-2">
  <a href="#" class="btn btn-primary btn-icon-split mt-2 mb-4" id="btnTambahKategori">
    <span class="icon text-white-50">
      <i class="fas fa-plus-circle fa-sm fa-fw"></i>
    </span>
    <span class="text">Tambahkan Kategori</span>
  </a>
  <!-- Content Row -->
  <div class="row">
    <div class="col-md-10">
      <?php if ($validation->getErrors()) : ?>
        <div class="alert alert-danger">
          <?= $validation->listErrors() ?>
        </div>
      <?php endif ?>

      <form action="/aplikasi/guru/tambah-artikel" method="post" enctype="multipart/form-data" autocomplete="off">
        <?= csrf_field(); ?>
        <div class="form-group row">
          <label for="judul" class="col-3 col-lg-2 col-form-label">Judul</label>
          <div class="col-9">
            <input type="text" class="form-control <?= ($validation->hasError('judul')) ? 'is-invalid' : '' ?>" id="judul" name="judul" value="<?= old('judul') ?>">
            <div class="invalid-feedback">
              <?= $validation->getError('judul') ?>
            </div>
          </div>
        </div>

        <div class="form-group row">
          <label for="kategori_id" class="col-3 col-lg-2 col-form-label">Kategori</label>
          <div class="col-9">
            <div class="form-group">
              <select class="form-control" name="kategori_id" id="kategori_id">
                <option value="">Pilih Kategori</option>
                <?php foreach ($kategori as $k) : ?>
                  <option value="<?= $k['id']; ?>" id="kategori"><?= $k['kategori']; ?></option>
                <?php endforeach ?>
              </select>
            </div>
          </div>
        </div>

        <div class="form-group row">
          <label for="thumbnail" class="col-3 col-lg-2 col-form-label">Foto :</label>
          <div class="col-9 col-md-6 mb-2">
            <div class="custom-file">
              <input type="file" class="custom-file-input <?= ($validation->hasError('thumbnail')) ? 'is-invalid' : '' ?>" id="image" name="thumbnail" accept="image/*">
              <div class="invalid-feedback">
                <?= $validation->getError('thumbnail') ?>
              </div>
              <label class="custom-file-label text-break" for="thumbnail">Foto thumbnail (opsional)</label>
            </div>
          </div>
          <div class="col-4 col-md-3">
            <img src="/template/img/thumbnail/default.jpg" id="imgPreview" class="img-thumbnail">
          </div>
        </div>

        <div class="form-group">
          <label for="summernote" class="form-label">Text</label>
          <textarea class="form-control <?= ($validation->hasError('text')) ? 'is-invalid' : '' ?>" id="summernote" name="text" rows="5"><?= old('text') ?></textarea>
          <div class="invalid-feedback">
            <?= $validation->getError('text') ?>
          </div>
        </div>

        <div class="form-group row">
          <div class="col-9">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="customCheck" name="aktif" value="1" checked>
              <label class="custom-control-label" for="customCheck">Publikasikan </label>
              <i class="far fa-question-circle fa-fw" id="info"></i>
            </div>
          </div>
        </div>

        <div class="form-group row mt-4">
          <div class="col d-flex justify-content-center">
            <button type="submit" class="btn btn-primary btn-icon-split">
              <span class="icon text-white-50">
                <i class="fas fa-plus-circle fa-sm fa-fw"></i>
              </span>
              <span class="text">Tambah</span>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

</div>


<!-- Tambah Kategori Modal -->
<script>
  $('#info').click(function(e) {
    e.preventDefault();
    swal('Apa itu publikasikan?', 'Jika kamu mencentang "dipublikasikan" maka artikel kamu dapat dilihat oleh semua orang.', 'info')
  });

  $('#btnTambahKategori').click(function(e) {
    e.preventDefault();
    swal("Masukkan Nama Kategori", {
        content: "input",
        buttons: ["Batal!", true]
      })
      .then((value) => {
        if (value) {
          $.ajax({
            type: "post",
            url: "/aplikasi/guru/tambah_kategori",
            data: {
              kategori: value
            },
            success: function(r) {
              if (r == 'oke') {
                swal("Kategori Berhasil Ditambahkan!", {
                  icon: "success",
                }).then((ditambahkan) => {
                  window.location.href = '/aplikasi/guru/buat-artikel';
                });
              } else {
                window.location.href = '/aplikasi/guru/buat-artikel';
              }
            }
          });
        }
      });
  });
</script>

<?= $this->endSection(); ?>