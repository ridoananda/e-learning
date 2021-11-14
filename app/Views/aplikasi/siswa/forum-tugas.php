<?= $this->extend('aplikasi/layout/template') ?>
<?= $this->section('content') ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-3 text-gray-800">Forum Tugas</h1>

  <div class="row mb-5">

    <?php foreach ($tugas as $t) : ?>
      <?php $guru = $db->table('user')->where('id', $t['user_id'])->get()->getRowArray(); ?>
      <div class="col-md-6 col-lg-4">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><?= $t['mapel']; ?></h6>
          </div>
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <div class="icon-circle bg-primary p-4">
                  <i class="fas fa-clipboard-list text-white fa-2x"></i>
                </div>
              </div>
              <div class="col">
                <!-- <div class="h6 font-weight-bold text-gray-800">Total tugas : 17</div> -->
                <div class="small font-weight-bold text-gray-800">Guru mapel :</div>
                <div class="small text-gray-800"><?= $guru['nama_lengkap']; ?></div>
              </div>
            </div>
          </div>
          <div class="card-footer small d-flex justify-content-center">
            <a href="/aplikasi/siswa/tugas/<?= $t['user_id']; ?>" class="text-primary text-decoration-none">Lihat daftar tugas <i class="fa fa-chevron-right fa-sm fa-fw"></i></a>

          </div>
        </div>
      </div>
    <?php endforeach ?>

  </div>





</div>
<!-- /.container-fluid -->

<?= $this->endSection() ?>