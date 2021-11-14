<?= $this->extend('aplikasi/layout/template') ?>
<?= $this->section('content') ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-3 text-gray-800">Profil Saya</h1>

  <hr class="my-2">
  <!-- Content Row -->
  <div class="row mt-3 mb-5">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-lg-6 col-md-8 mb-2">
      <?php if (session()->getFlashdata('berhasil')) : ?>
        <div class="alert text-center alert-success mb-3">
          <?= session()->getFlashdata('berhasil') ?>
        </div>
      <?php endif ?>
      <div class="card border-bottom-primary shadow h-100 py-1 px-0">
        <div class="card-body">
          <div class="row no-gutters align-items-center ">
            <div class="col mr-3">
              <div class="row d-flex justify-content-center mb-3">
                <div class="col-6">
                  <img class="img-fluid rounded-circle img-thumbnail" src="/template/img/profil/<?= $user['foto'] ?>" width="240" height="240">
                </div>
              </div>
              <div class="row">
                <div class="col">

                  <span class="font-weight-bold text-primary text-capitalize mb-2">Nama lengkap
                  </span>
                  <div class="text-gray-800"><?= $user['nama_lengkap'] ?></div>
                  <hr class="my-2">

                  <span class="font-weight-bold text-primary text-capitalize mb-2">
                    <?= ($user_mapel['user_role'] == 2) ? 'Guru Mapel' : 'Kelas & Jurusan' ?>
                  </span>
                  <div class="text-gray-800"><?= ($user_mapel['user_role'] == 2) ? $user_mapel['mapel'] : $user_mapel['kelas'] . ' - ' . $user_mapel['jurusan'] ?></div>
                  <hr class="my-2">

                  <span class="font-weight-bold text-primary text-capitalize mb-2">Email
                  </span>
                  <div class="text-gray-800"><?= $user['email'] ?></div>
                  <hr class="my-2">

                  <span class="font-weight-bold text-primary text-capitalize mb-2">Alamat
                  </span>
                  <div class="text-gray-800"><?= $user['alamat'] ?></div>
                  <hr class="my-2">
                  <small>Bergabung Sejak <?= tanggal_lengkap($user['created_at']) ?></small>
                  <div class="d-flex justify-content-center mt-2">
                    <a href="/aplikasi/profil/edit" class="btn btn-primary btn-icon-split btn-sm mt-3">
                      <span class="icon text-white-50">
                        <i class="fas fa-user-edit fa-fw"></i>
                      </span>
                      <span class="text">Edit profil</span>
                    </a>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Content Row -->

</div>
<!-- /.container-fluid -->

<?= $this->endSection() ?>