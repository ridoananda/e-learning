<?= $this->extend('aplikasi/layout/template') ?>
<?= $this->section('content') ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-1 text-gray-800">Data Absen</h1>
  <?php if ($data_absen != NULL) : ?>
    <small><?= tanggal_lengkap($data_absen['created_at']) ?> - <?= $absen['kelas']; ?> <?= $absen['jurusan']; ?></small>

    <div class="row mt-3">
      <div class="col-xl-4 col-md-6 mb-3">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total keseluruhan</div>
                <div class="h6 mb-0 text-gray-800">Hadir : <?= $db->table('data_absen')->where(['keterangan' => 'hadir', 'absen_id' => $id])->countAllResults(); ?></div>
                <div class="h6 mb-0 text-gray-800">Sakit : <?= $db->table('data_absen')->where(['keterangan' => 'sakit', 'absen_id' => $id])->countAllResults(); ?></div>
                <div class="h6 mb-0 text-gray-800">Izin : <?= $db->table('data_absen')->where(['keterangan' => 'izin', 'absen_id' => $id])->countAllResults(); ?></div>
                <div class="h6 mb-0 text-gray-800 font-weight-bold">Total : <?= $db->table('data_absen')->where(['absen_id' => $id])->countAllResults(); ?></div>
              </div>
              <div class="col-auto">
                <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-3">
      <!-- CARD KETERANGAN ABSEN -->
      <div class="col-md-4">
        <div class="card shadow mb-4">
          <a href="#cardHadir" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="cardHadir">
            <h6 class="m-0 font-weight-bold text-primary text-capitalize">Hadir</h6>
          </a>
          <div class="collapse show" id="cardHadir">
            <div class="card-body">
              <!-- ambil seluruh data absen -->
              <?php $list_data_absen = $db->table('data_absen')->where(['absen_id' => $id, 'keterangan' => 'hadir'])->get()->getResultArray();
              $no = 1;
              foreach ($list_data_absen as $lda) :
                $user_absen = $db->table('user')->where('id', $lda['user_id'])->get()->getRowArray()
              ?>
                <p class="mb-0"><?= $no++; ?>. <?= $user_absen['nama_lengkap']; ?></p>
              <?php endforeach ?>
              <?php if (empty($list_data_absen)) : ?>
                <span class="text-gray-600">Data tidak tersedia</span>
              <?php endif ?>
            </div>
          </div>
        </div>
      </div>
      <!-- CARD KETERANGAN ABSEN -->
      <div class="col-md-4">
        <div class="card shadow mb-4">
          <a href="#cardSakit" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="cardSakit">
            <h6 class="m-0 font-weight-bold text-primary text-capitalize">Sakit</h6>
          </a>
          <div class="collapse show" id="cardSakit">
            <div class="card-body">
              <!-- ambil seluruh data absen -->
              <?php $list_data_absen = $db->table('data_absen')->where(['absen_id' => $id, 'keterangan' => 'sakit'])->get()->getResultArray();
              $no = 1;
              foreach ($list_data_absen as $lda) :
                $user_absen = $db->table('user')->where('id', $lda['user_id'])->get()->getRowArray()
              ?>
                <p class="mb-0"><?= $no++; ?>. <?= $user_absen['nama_lengkap']; ?> - <?= $lda['alasan']; ?></p>
              <?php endforeach ?>
              <?php if (empty($list_data_absen)) : ?>
                <span class="text-gray-600">Data tidak tersedia</span>
              <?php endif ?>
            </div>
          </div>
        </div>
      </div>
      <!-- CARD KETERANGAN ABSEN -->
      <div class="col-md-4">
        <div class="card shadow mb-4">
          <a href="#cardIzin" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="cardIzin">
            <h6 class="m-0 font-weight-bold text-primary text-capitalize">Izin</h6>
          </a>
          <div class="collapse show" id="cardIzin">
            <div class="card-body">
              <!-- ambil seluruh data absen -->
              <?php $list_data_absen = $db->table('data_absen')->where(['absen_id' => $id, 'keterangan' => 'izin'])->get()->getResultArray();
              $no = 1;
              foreach ($list_data_absen as $lda) :
                $user_absen = $db->table('user')->where('id', $lda['user_id'])->get()->getRowArray()
              ?>
                <p class="mb-0"><?= $no++; ?>. <?= $user_absen['nama_lengkap']; ?> - <?= $lda['alasan']; ?></p>
              <?php endforeach ?>
              <?php if (empty($list_data_absen)) : ?>
                <span class="text-gray-600">Data tidak tersedia</span>
              <?php endif ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php else : ?>

    <div class="row">
      <div class="col-md-4">
        <div class="alert alert-primary mt-3" role="alert">
          <span><i class="fa fa-info-circle" aria-hidden="true"></i> Data absen belum tersedia</span>
        </div>
      </div>
    </div>

  <?php endif ?>
</div>
<!-- /.container-fluid -->
<?= $this->endSection() ?>