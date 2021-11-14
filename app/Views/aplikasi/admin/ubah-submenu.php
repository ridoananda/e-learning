<?= $this->extend("aplikasi/layout/template"); ?>

<?= $this->section("content"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-3 text-gray-800">Edit <?= $title; ?></h1>

  <hr class="my-2 mb-3">
  <!-- Content Row -->
  <div class="row">
    <div class="col-md-10">

      <form action="/aplikasi/menu/update_sub_menu/<?= $submenu['id'] ?>" method="post">
        <?= csrf_field(); ?>
        <input type="hidden" name="_method" value="UPDATE">
        <div class="form-group row">
          <label for="title" class="col-3 col-lg-2 col-form-label">Judul</label>
          <div class="col-9">
            <input type="text" class="form-control <?= ($validation->hasError('title')) ? 'is-invalid' : '' ?>" id="title" name="title" value="<?= (old('title')) ? old('title') : $submenu['title'] ?>">
            <div class="invalid-feedback">
              <?= $validation->getError('title') ?>
            </div>
          </div>
        </div>

        <div class="form-group row">
          <label for="menu_id" class="col-3 col-lg-2 col-form-label">Menu</label>
          <div class="col-9">
            <div class="form-group">
              <select class="form-control" name="menu_id" id="menu_id">
                <option value="<?= $submenu['menu_id']; ?>"><?= $submenu['menu']; ?></option>
                <?php foreach ($menu as $m) : ?>
                  <?php if ($m['menu'] != $submenu['menu']) : ?>
                    <option value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>
                  <?php endif ?>
                <?php endforeach ?>
              </select>
            </div>
          </div>
        </div>

        <div class="form-group row">
          <label for="url" class="col-3 col-lg-2 col-form-label">URL</label>
          <div class="col-9">
            <input type="text" class="form-control <?= ($validation->hasError('url')) ? 'is-invalid' : '' ?>" id="url" name="url" value="<?= (old('url')) ? old('url') : $submenu['url'] ?>">
            <div class="invalid-feedback">
              <?= $validation->getError('url') ?>
            </div>
          </div>
        </div>

        <div class="form-group row">
          <label for="icon" class="col-3 col-lg-2 col-form-label">Icon</label>
          <div class="col-9">
            <input type="text" class="form-control <?= ($validation->hasError('icon')) ? 'is-invalid' : '' ?>" id="icon" name="icon" value="<?= (old('icon')) ? old('icon') : $submenu['icon'] ?>">
            <div class="invalid-feedback">
              <?= $validation->getError('icon') ?>
            </div>
          </div>
        </div>

        <div class="form-group row">
          <label for="is_active" class="col-3 col-lg-2 col-form-label">Aktif ?</label>
          <div class="col-9">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" <?= ($submenu['is_active'] == 1) ? 'checked' : '' ?>>
              <label class="custom-control-label" for="is_active"></label>
            </div>
          </div>
        </div>


        <div class="form-group row mt-4">
          <div class="col d-flex justify-content-center">
            <button type="submit" class="btn btn-primary btn-icon-split btn-sm">
              <span class="icon text-white-50">
                <i class="fas fa-pen"></i>
              </span>
              <span class="text">Ubah</span>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

</div>

<?= $this->endSection(); ?>