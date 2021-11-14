<?= $this->extend('aplikasi/layout/template') ?>
<?= $this->section('content') ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-3 text-gray-800">Forum Tugas</h1>

  <div class="row mb-5">

    <div class="col-md-6 col-lg-4">
      <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Soal</h6>
          <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
              <a class="dropdown-item" href="#"><i class="fas fa-pen fa-sm fa-fw"></i> Edit</a>
              <a class="dropdown-item" href="#"><i class="fa fa-trash fa-sm fa-fw"></i> Hapus</a>
            </div>
          </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-auto">
              <div class="icon-circle bg-secondary p-4">
                <i class="fas fa-clipboard-list text-white fa-2x"></i>
              </div>
            </div>
            <div class="col">
              <div class="h6 font-weight-bold text-gray-800">Melakukan lari cepat estapet dan mengevaluasi secara berkelompok</div>
            </div>
          </div>
        </div>
        <div class="card-footer small d-flex justify-content-between">
          <a href="/aplikasi/guru/detail-tugas" class="text-muted text-decoration-none">28 komentar</a>
          <a href="/aplikasi/guru/detail-tugas" class="text-primary text-decoration-none">Lihat selengkapnya <i class="fa fa-chevron-right fa-sm fa-fw"></i></a>

        </div>
      </div>
    </div>
  </div>





</div>
<!-- /.container-fluid -->

<?= $this->endSection() ?>