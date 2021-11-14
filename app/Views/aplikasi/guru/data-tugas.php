<?= $this->extend('aplikasi/layout/template') ?>
<?= $this->section('content') ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-1 text-gray-800">Data Tugas</h1>
  <?php if ($data_tugas != NULL) : ?>
    <small><?= tanggal_lengkap($data_tugas['created_at']) ?> - <?= $tugas['kelas']; ?> <?= $tugas['jurusan']; ?></small>

    <div class="row mt-3">
      <div class="col-xl-4 col-md-6 mb-3">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pengumpulan</div>
                <div class="h6 mb-0 text-gray-800">Jumlah : <?= $db->table('data_tugas')->where(['is_kumpul' => 1, 'tugas_id' => $id])->countAllResults(); ?></div>
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
      <!-- CARD KETERANGAN TUGAS -->
      <div class="col-md-4">
        <div class="card shadow mb-4">
          <a href="#cardSudahNgumpul" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="cardSudahNgumpul">
            <h6 class="m-0 font-weight-bold text-primary text-capitalize">Yang Sudah Ngumpul</h6>
          </a>
          <div class="collapse show" id="cardSudahNgumpul">
            <div class="card-body">
              <!-- ambil seluruh data Tugas -->
              <?php $list_data_tugas = $db->table('data_tugas')->where(['tugas_id' => $id, 'is_kumpul' => 1])->get()->getResultArray();
              $no = 1;
              foreach ($list_data_tugas as $ldt) :
                $user_tugas = $db->table('user')->where('id', $ldt['user_id'])->get()->getRowArray()
              ?>
                <p class="mb-1"><?= $no++; ?>. <?= $user_tugas['nama_lengkap']; ?>
                  <a href="/aplikasi/guru/data-tugas-siswa/<?= $ldt['user_id']; ?>/<?= $ldt['tugas_id']; ?>" class="text-decoration-none small ml-2"><i class="fas fa-eye fa-sm fa-fw"></i> lihat data tugas
                  </a>
                </p>
              <?php endforeach ?>
              <?php if (empty($list_data_tugas)) : ?>
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
          <span><i class="fa fa-info-circle" aria-hidden="true"></i> Data tugas belum tersedia</span>
        </div>
      </div>
    </div>

  <?php endif ?>
</div>
<!-- /.container-fluid -->

<?= $this->endSection() ?>