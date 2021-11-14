<?= $this->extend('aplikasi/layout/template') ?>
<?= $this->section('content') ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-3 text-gray-800">Absen</h1>

  <?php if (time() <= $absen['expired'] && $data_absen == NULL) : ?>
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="alert alert-info" role="alert">
          <div class="row align-items-center">
            <div class="col-auto">
              <i class="fa fa-bell fa-2x fa-fw"></i>
            </div>
            <div class="col">
              <span class="h5 font-weight-bold">Absen <?= $absen['mapel']; ?>!</span>
              <span class="d-block">Berakhir pada pukul <?= date('H:i', $absen['expired']); ?></span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <form action="/aplikasi/siswa/mengabsen" method="post" enctype="multipart/form-data">
          <?= csrf_field(); ?>
          <input type="hidden" name="absen_id" value="<?= $absen['id']; ?>">
          <input type="hidden" name="mapel" value="<?= $absen['mapel']; ?>">
          <h4 class="text-dark">Keterangan</h4>
          <div class="form-group">
            <div class="custom-control custom-radio mb-2">
              <input type="radio" id="hadir" name="keterangan" class="custom-control-input" value="hadir">
              <label class="custom-control-label" for="hadir">Hadir</label>
            </div>
            <div class="custom-control custom-radio mb-2">
              <input type="radio" id="sakit" name="keterangan" class="custom-control-input" value="sakit">
              <label class="custom-control-label" for="sakit">Sakit</label>
            </div>
            <div class="custom-control custom-radio mb-2">
              <input type="radio" id="izin" name="keterangan" class="custom-control-input" value="izin">
              <label class="custom-control-label" for="izin">Izin</label>
            </div>
          </div>
          <div class="form-group" id="barisAlasan">
            <label for="alasan">Alasan</label>
            <textarea class="form-control" id="alasan" name="alasan" placeholder="Tulis alasannya ..."></textarea>
          </div>
          <div class="form-group justify-content-center d-flex">
            <button type="submit" class="btn btn-primary">Kirim</button>
          </div>
        </form>
      </div>
    </div>
  <?php elseif ($data_absen['is_absen'] == 1) : ?>
    <div class="row">
      <div class="col-lg-6">
        <div class="alert alert-success" role="alert">
          <div class="row align-items-center">
            <div class="col-auto">
              <i class="fa fa-info-circle fa-2x fa-fw"></i>
            </div>
            <div class="col">
              <span class="h5 font-weight-bold">Absen <?= $absen['mapel']; ?></span>
              <span class="d-block">Kamu sudah absen, Terima kasih.</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php elseif ($absen == null) : ?>
    <div class="row">
      <div class="col-lg-6">
        <div class="alert alert-warning" role="alert">
          <div class="row align-items-center">
            <div class="col-auto">
              <i class="fa fa-info-circle fa-2x fa-fw"></i>
            </div>
            <div class="col">
              <span class="h5 font-weight-bold">Absen <?= $absen['mapel']; ?></span>
              <span class="d-block">Oppss ... absen sudah dihapus</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php else : ?>
    <div class="row">
      <div class="col-lg-6">
        <div class="alert alert-danger" role="alert">
          <div class="row align-items-center">
            <div class="col-auto">
              <i class="fa fa-info-circle fa-2x fa-fw"></i>
            </div>
            <div class="col">
              <span class="h5 font-weight-bold">Absen <?= $absen['mapel']; ?></span>
              <span class="d-block">Maaf ya, absen sudah berakhir.</span>
            </div>
          </div>
        </div>
      </div>
    </div>

  <?php endif ?>



</div>
<!-- /.container-fluid -->

<?= $this->endSection() ?>