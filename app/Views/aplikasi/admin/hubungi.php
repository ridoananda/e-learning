<?= $this->extend('aplikasi/layout/template') ?>
<?= $this->section('content') ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-8 col-md-10 mb-2">
    <?php if (session()->getFlashdata('berhasil')) : ?>
      <div class="alert alert-success">
        <small><?= session()->getFlashdata('berhasil') ?></small>
      </div>
    <?php endif ?>
  </div>

    <div class="card shadow mt-3 mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Pesan Hubungi</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover" id="dataTable">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Pesan</th>
                <th>Waktu</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach ($hubungi as $h) : ?>
                <tr>
                  <td scope="row"><?= $no++; ?></td>
                  <td><?= $h['nama_lengkap']; ?></td>
                  <td><?= $h['email']; ?></td>
                  <td><?= $h['pesan']; ?></td>
                  <td><?= time_lengkap($h['created_at']); ?></td>
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

<?= $this->endSection() ?>