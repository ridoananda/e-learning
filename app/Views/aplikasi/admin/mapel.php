<?= $this->extend('aplikasi/layout/template') ?>
<?= $this->section('content') ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
  <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahMapelModal"><i class="fas fa-plus-circle fa-fw"></i> Tambah Mapel Guru</button>
  <button type="button" class="btn btn-info ml-lg-2 mb-3" data-toggle="modal" data-target="#tambahKelasModal"><i class="fas fa-plus-circle fa-fw"></i> Tambah Kelas & Jurusan Siswa</button>
  <!-- Content Row -->
  <div class="row">

    <div class="col-xl-8 col-md-10 mb-2">
      <?php if (session()->getFlashdata('berhasil')) : ?>
        <div class="alert alert-success">
          <small><?= session()->getFlashdata('berhasil') ?></small>
        </div>
      <?php endif ?>
      <?php if ($validation->getErrors()) : ?>
        <div class="alert alert-danger">
          <?= $validation->listErrors() ?>
        </div>
      <?php endif ?>
      <div class="card shadow mt-3 mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Daftar Mata Pelajaran</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>User Role</th>
                  <th>Mapel</th>
                  <th>Kelas & Jurusan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($mapel as $m) : ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $m['name']; ?></td>
                    <td><?= (!$m['mapel']) ? '-' : $m['mapel']; ?></td>
                    <td><?= $m['kelas']; ?> - <?= $m['jurusan'] ?></td>
                    <td>
                      <a class="badge badge-info" href="#" id="btnUbahMapel" data-id="<?= $m['id'] ?>" data-mapel="<?= $m['mapel'] ?>" data-kelas="<?= $m['kelas'] ?>" data-jurusan="<?= $m['jurusan'] ?>" <?= (!$m['mapel']) ? 'data-target="#ubahKelasModal"' : 'data-target="#ubahMapelModal"'; ?> data-toggle="modal"><i class="fas fa-pen fa-sm fa-fw"></i> Ubah</a>
                      <a class="badge badge-danger" href="#" id="btnHapusMapel" data-id="<?= $m['id'] ?>"><i class="fas fa-trash fa-fw"></i> Hapus</a>
                    </td>
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
<!-- /.container-fluid -->

<!-- Tambah Mapel Modal-->
<div class="modal fade" id="tambahMapelModal" tabindex="-1" role="dialog" aria-labelledby="tambahMapelModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahRoleModal">Tambah Mapel</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form action="/aplikasi/admin/tambah_mapel" method="POST">
        <?= csrf_field(); ?>
        <div class="modal-body">
          <div class="form-group">
            <input type="text" class="form-control" id="mapel" placeholder="Nama mapel" name="mapel">
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">batal</button>
          <button class="btn btn-primary" type="submit">Tambah</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Tambah Kelas Modal-->
<div class="modal fade" id="tambahKelasModal" tabindex="-1" role="dialog" aria-labelledby="tambahKelasModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahRoleModal">Tambah Kelas dan Jurusan</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form action="/aplikasi/admin/tambah_kelas" method="POST">
        <?= csrf_field(); ?>
        <div class="modal-body">
          <div class="form-group">
            <input type="text" class="form-control" id="kelas" placeholder="Kelas" name="kelas">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="jurusan" placeholder="Jurusan" name="jurusan">
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">batal</button>
          <button class="btn btn-primary" type="submit">Tambah</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- UBAH Mapel Modal-->
<div class="modal fade" id="ubahMapelModal" tabindex="-1" role="dialog" aria-labelledby="ubahMapelModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ubahMapelModal">Ubah Mapel</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form action="" method="POST" id="ubahMapel">
        <?= csrf_field(); ?>
        <div class="modal-body">
          <div class="form-group">
            <input type="text" class="form-control" id="mapel" placeholder="Nama Mapel" name="mapel">
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">batal</button>
          <button class="btn btn-primary" type="submit">Ubah</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- UBAH KELAS DAN JURUSAN -->
<div class="modal fade" id="ubahKelasModal" tabindex="-1" role="dialog" aria-labelledby="ubahKelasModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ubahKelasModal">Ubah Kelas & Jurusan</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form action="" method="POST" id="ubahKelas">
        <?= csrf_field(); ?>
        <div class="modal-body">
          <div class="form-group">
            <input type="text" class="form-control" id="kelas" placeholder="Kelas" name="kelas">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="jurusan" placeholder="Nama jurusan" name="jurusan">
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">batal</button>
          <button class="btn btn-primary" type="submit">Ubah</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  // HAPUS MENU
  $('a#btnHapusMapel').click(function(e) {
    e.preventDefault();
    swal({
        title: "Apa kamu yakin?",
        text: "PERINGATAN!!! Hapus Seperlunya Saja, Karena Apabila User Telah Terdaftar Pada Mapel/Kelas & Jurusan Tersebut, Maka Terjadi ERROR!!!",
        icon: "warning",
        buttons: ["Batal!", true],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          swal("Ketik 'ya' jika ingin menghapus :", {
              content: "input",
            })
            .then((value) => {
              if (value.toLowerCase() == 'ya') {
                var id = $(this).data('id');
                $.ajax({
                  type: "post",
                  url: "/aplikasi/admin/hapus_mapel",
                  data: {
                    id: id
                  },
                  success: function(r) {
                    swal("Mapel/Kelas & Jurusan berhasil dihapus!", {
                      icon: "success",
                    }).then((dihapus) => {
                      window.location.href = '/aplikasi/admin/mapel';
                    });
                  }
                });
              } else {
                swal('Kode Salah!', 'Kode yang kamu masukan tidak sesuai!', 'error')
              }
            });
        }
      });
  });
</script>

<?= $this->endSection() ?>