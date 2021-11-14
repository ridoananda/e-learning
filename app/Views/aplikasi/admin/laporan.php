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
        <h6 class="m-0 font-weight-bold text-primary">Laporan</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover" id="dataTable">
            <thead>
              <tr>
                <th>#</th>
                <th>Laporan</th>
                <th>Kepada</th>
                <th>Alasan</th>
                <th>Waktu</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach ($laporan as $lapor) :
                $user = $db->table('user')->where(['id' => $lapor['user_id']])->get()->getRowArray();
                $user_lapor = $db->table('user')->where(['id' => $lapor['user_lapor_id']])->get()->getRowArray();
              ?>
                <tr>
                  <td scope="row"><?= $no++; ?></td>
                  <td><?= $user_lapor['nama_lengkap']; ?></td>
                  <td><?= $user['nama_lengkap']; ?></td>
                  <td><?= $lapor['alasan']; ?></td>
                  <td><?= time_lengkap($lapor['created_at']); ?></td>
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