<?= $this->extend('aplikasi/layout/template') ?>
<?= $this->section('content') ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
  <!-- Content Row -->
  <div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-8 col-md-10 mb-2">
      <?php if (session()->getFlashdata('berhasil')) : ?>
        <div class="alert alert-success">
          <small><?= session()->getFlashdata('berhasil') ?></small>
        </div>
      <?php endif ?>
      <p class="text-gray-600">Role : <?= $role['name']; ?></p>
      <div class="card shadow mt-3 mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Role Access</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Role</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($menu as $m) : ?>
                  <tr>
                    <td scope="row"><?= $no++; ?></td>
                    <td><?= $m['menu']; ?></td>
                    <td>
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input roleAccess" id="customCheck-<?= $m['id'] ?>" <?= checked($role['id'], $m['id']); ?> data-role_id="<?= $role['id']; ?>" data-menu_id="<?= $m['id']; ?>">
                        <label class="custom-control-label" for="customCheck-<?= $m['id'] ?>"></label>
                      </div>
                    </td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Content Row -->

</div>
<!-- /.container-fluid -->


<?= $this->endSection() ?>