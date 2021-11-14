<?= $this->extend('aplikasi/layout/template') ?>
<?= $this->section('content') ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800">Log Aktivitas</h1>
  <hr class="my-2">

    <div class="card shadow mt-3 mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Riwayat Login</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No.</th>
                <th>Alamat IP</th>
                <th>Pengguna</th>
                <th>Waktu</th>
              </tr>
            </thead>
            <tbody>
            	<?php 
            	$no = 1;
            	foreach ($log as $l) : ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><?= $l['ip_address']; ?></td>
                <td><?= $l['user_agent']; ?></td>
                <td><?= $l['created_at']; ?></td>
              </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

</div>
<!-- /.container-fluid -->

<?= $this->endSection() ?>