<?= $this->extend('aplikasi/layout/template') ?>
<?= $this->section('content') ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
  <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahSubMenuModal"><i class="fas fa-plus-circle fa-fw"></i> Tambah Akun Guru</button>
  <!-- Content Row -->
  <div class="row">

    <div class="col-md-12 mb-2">
      <?php if (session()->getFlashdata('berhasil')) : ?>
        <div class="alert alert-success">
          <?= session()->getFlashdata('berhasil') ?>
        </div>
      <?php endif ?>

      <?php if ($validation->getErrors()) : ?>
        <div class="alert alert-danger">
          <?= $validation->listErrors() ?>
        </div>
      <?php endif ?>
      <div class="card shadow mt-3 mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Daftar Akun Guru</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nama Lengkap</th>
                  <th>Email</th>
                  <th>Mata Pelajaran</th>
                  <th>Aktif</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($guru as $g) :
                  $mapel = $db->table('user_mapel')->where(['id' => $g['mapel_id']])->get()->getRowArray();
                ?>
                  <tr>
                    <td scope="row"><?= $no++; ?></td>
                    <td><?= $g['nama_lengkap']; ?></td>
                    <td><?= $g['email']; ?></td>
                    <td><?= $mapel['mapel']; ?></td>
                    <td>
                      <?= ($g['is_active'] == 1) ? 'Ya' : 'Tidak'; ?>
                    </td>
                    <td>
                      <a class="badge badge-info" href="/aplikasi/data/ubah-data/<?= $g['id']; ?>" id="btnEditSubMenu"><i class="fas fa-pen fa-fw"></i> Edit</a>

                      <a class="badge badge-danger" href="#" data-id="<?= $g['id']; ?>" id="btnHapusData"><i class="fas fa-trash fa-fw"></i> Hapus</a>
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



<!-- Tambah AKUN guru Modal-->
<div class="modal fade" id="tambahSubMenuModal" tabindex="-1" role="dialog" aria-labelledby="tambahSubMenuModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahSubMenuModal">Tambah Akun Guru</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/aplikasi/data/add_data" method="POST">
          <?= csrf_field(); ?>
          <input type="hidden" name="r" value="g">
          <div class="form-group">
            <input type="text" class="form-control" id="nama_lengkap" placeholder="Nama lengkap" name="nama_lengkap" value="<?= old('nama_lengkap'); ?>">
          </div>
          <div class="form-group">
            <select class="form-control" name="mapel_id" id="mapel_id">
              <option value="">Pilih Mata Pelajaran</option>
              <?php foreach ($user_mapel as $m) : ?>
                <option value="<?= $m['id']; ?>"><?= $m['mapel']; ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="email" placeholder="email" name="email" value="<?= old('email'); ?>">
          </div>

          <div class="form-group">
            <input type="text" class="form-control" id="alamat" placeholder="Alamat" name="alamat" value="<?= old('alamat'); ?>">
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">batal</button>
            <button class="btn btn-primary" type="submit">Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<script>
  // HAPUS ABSEN
  $('a#btnHapusData').click(function(e) {
    e.preventDefault();
    swal({
        title: "Apa kamu yakin?",
        text: "Jika kamu Hapus User ini, maka data dari user ini akan terhapus!",
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
                  url: "/aplikasi/data/hapus_data",
                  data: {
                    id: id
                  },
                  success: function(r) {
                    swal("Data berhasil dihapus!", {
                      icon: "success",
                    }).then((dihapus) => {
                      window.location.href = '/aplikasi/data';
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