<?= $this->extend('aplikasi/layout/template') ?>
<?= $this->section('content') ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-3 text-gray-800">Absen</h1>

  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
          <h6 class="m-0 font-weight-bold text-primary">Daftar Absen hari ini</h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse show" id="collapseCardExample">
          <div class="card-body">
            <ul class="list-group">
              <?php
              $list_absen = $db->table('absen')->where('mapel_id', $user['mapel_id'])->orderBy('id', 'DESC')->get()->getResultArray();
              if ($list_absen) :
                foreach ($list_absen as $la) :
                  $row_data_absen = $db->table('data_absen')->where(['absen_id' => $la['id'], 'user_id' => $user['id']])->get()->getRowArray();
                  if (tanggal_lengkap($la['created_at']) == time_lengkap(time())) :
                    if (!empty($la) && $row_data_absen == NULL) : ?>
                      <?php if (time() <= $la['expired']) : ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                          <span>Absen <?= $la['mapel']; ?></span>
                          <a href="/aplikasi/siswa/absen/<?= $la['id']; ?>" class="badge badge-info badge-pill">lihat</a>
                        </li>
                      <?php else : ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center text-danger">
                          <span>Absen <?= $la['mapel']; ?> telah berakhir!</span>
                        </li>
                      <?php endif ?>
                    <?php else : ?>
                      <?php $show = true ?>
                    <?php endif ?>
                  <?php endif ?>
                <?php endforeach ?>
              <?php endif ?>
              <?php if (isset($show)) : ?>
                <!-- <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <span>Tunggu absen selanjutnya :)</span>
                </div> -->
              <?php endif ?>
            </ul>
          </div>
        </div>
      </div>
      <?php if ($validation->getErrors()) : ?>
        <div class="alert alert-danger">
          <?= $validation->listErrors() ?>
        </div>
      <?php endif ?>

      <?php if (session()->getFlashdata('berhasil')) : ?>
        <div class="alert alert-success text-center">
          <?= session()->getFlashdata('berhasil') ?>
        </div>
      <?php endif ?>
      <?php if (session()->getFlashdata('warning')) : ?>
        <div class="alert alert-warning text-center">
          <?= session()->getFlashdata('warning') ?>
        </div>
      <?php endif ?>
    </div>
  </div>



  <div class="card shadow mt-3 mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Riwayat Absen</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No.</th>
              <th>Mapel</th>
              <th>Keterangan</th>
              <th>Alasan</th>
              <th>Waktu</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1;
            foreach ($data_absen as $a) : ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><?= $a['mapel']; ?></td>
                <td><?= $a['keterangan']; ?></td>
                <td><?= $a['alasan']; ?></td>
                <td><?= tanggal_lengkap($a['created_at']); ?> <?= jam($a['created_at']); ?></td>
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