<?= $this->extend('aplikasi/layout/template') ?>
<?= $this->section('content') ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-3 text-gray-800">Absen</h1>
  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary btn btn-icon-split mb-3" data-toggle="modal" data-target="#buatAbsen">
    <span class="icon text-white-50">
      <i class="fas fa-plus"></i>
    </span>
    <span class="text">Buat absen</span>
  </button>



  <div class="row">
    <div class="col-md-8">
      <?php if ($validation->getErrors()) : ?>
        <div class="alert alert-danger">
          <?= $validation->listErrors() ?>
        </div>
      <?php endif ?>

      <?php if (session()->getFlashdata('warning')) : ?>
        <div class="alert alert-warning">
          <?= session()->getFlashdata('warning') ?>
        </div>
      <?php endif ?>
      <?php if (session()->getFlashdata('berhasil')) : ?>
        <div class="alert alert-success">
          <?= session()->getFlashdata('berhasil') ?>
        </div>
      <?php endif ?>
    </div>
  </div>


  <div class="card shadow mt-3 mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Riwayat Absensi</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No.</th>
              <th>Kelas</th>
              <th>Batas Waktu</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1;
            foreach ($absen as $a) : ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><?= $a['kelas']; ?> - <?= $a['jurusan']; ?></td>
                <td><?= tanggal_lengkap($a['created_at']); ?> <?= date('H:i', $a['expired']); ?></td>
                <td>
                  <a href="/aplikasi/guru/data-absen/<?= $a['id']; ?>" class="badge badge-info"><i class="fa fa-eye fa-fw"></i> Lihat data</a>
                  <a href="#" class="badge badge-warning" id="btnUbahAbsen" data-toggle="modal" data-target="#ubahAbsenModal" data-id="<?= $a['id']; ?>" data-kelas="<?= $a['kelas']; ?>" data-jurusan="<?= $a['jurusan']; ?>"><i class="fas fa-pen fa-fw"></i> Ubah</a>
                  <a href="#" class="badge badge-danger" id="btnHapusAbsen" data-id="<?= $a['id']; ?>"><i class="fa fa-trash fa-fw"></i> Hapus</a>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>


</div>
<!-- /.container-fluid -->

<!-- Modal Buat Absen-->
<div class="modal fade" id="buatAbsen" tabindex="-1" role="dialog" aria-labelledby="buatAbsen">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Buat absen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/aplikasi/guru/buat_absen" method="POST">
          <?= csrf_field(); ?>
          <div class="form-group">
            <select class="form-control" name="mapel_id" id="mapel_id">
              <option value="">Pilih Kelas</option>
              <?php foreach ($mapel as $m) : ?>
                <option value="<?= $m['id']; ?>"><?= $m['kelas']; ?> - <?= $m['jurusan']; ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="form-group">
            <label for="expired">Batas waktu</label>
            <input type="text" class="form-control" id="expired" placeholder="Menit" name="expired" value="<?= old('expired'); ?>" autocomplete="off">
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">batal</button>
            <button class="btn btn-primary" type="submit">Buat</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Ubah Absen-->
<div class="modal fade" id="ubahAbsenModal" tabindex="-1" role="dialog" aria-labelledby="buatAbsen">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ubah absen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/aplikasi/guru/buat_absen" method="POST" id="ubahAbsen">
          <?= csrf_field(); ?>
          <div class="form-group">
            <select class="form-control" name="mapel_id" id="mapel_id">
              <option value=""></option>
            </select>
          </div>
          <div class="form-group">
            <label for="expired">Batas waktu</label>
            <input type="text" class="form-control" id="expired" placeholder="Menit" name="expired" value="<?= old('expired'); ?>" autocomplete="off">
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">batal</button>
            <button class="btn btn-primary" type="submit">Buat</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  // HAPUS ABSEN
  $('a#btnHapusAbsen').click(function(e) {
    e.preventDefault();
    swal({
        title: "Apa kamu yakin?",
        text: "Jika kamu hapus absen ini, maka data absen dari siswa akan terhapus!",
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
                  url: "/aplikasi/guru/hapus_absen",
                  data: {
                    id: id
                  },
                  success: function(r) {
                    swal("Data berhasil dihapus!", {
                      icon: "success",
                    }).then((dihapus) => {
                      window.location.href = '/aplikasi/guru/absen';
                    });
                  }
                });
              } else {
                swal('Kode Salah!', 'Kode yang kamu masukan tidak sesuai!', 'error')
              }
            });
        } else {
          swal("Data absen aman.");
        }
      });
  });
</script>
<?= $this->endSection() ?>