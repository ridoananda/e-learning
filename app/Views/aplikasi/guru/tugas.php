<?= $this->extend('aplikasi/layout/template') ?>
<?= $this->section('content') ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-3 text-gray-800">Tugas</h1>

  <a href="#" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#tambahTugasModal">
    <span class="icon text-white-50">
      <i class="fas fa-plus"></i>
    </span>
    <span class="text">Buat Tugas</span>
  </a>
  <div class="row">
    <div class="col-md-8">
      <?php if ($validation->getErrors()) : ?>
        <div class="alert alert-danger">
          <?= $validation->listErrors() ?>
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
      <h6 class="m-0 font-weight-bold text-primary">Riwayat Tugas</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No.</th>
              <th>Kelas</th>
              <th>Judul Tugas</th>
              <th>Deskripsi</th>
              <th>Tanggal Upload</th>
              <th>Ditugaskan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1;
            foreach ($tugas as $t) : ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><?= $t['kelas']; ?> - <?= $t['jurusan']; ?></td>
                <td><?= word_limiter($t['judul'], 6); ?></td>
                <td><?= word_limiter($t['deskripsi'], 6) ?></td>
                <td><?= tanggal_lengkap($t['created_at']); ?> <?= jam($t['created_at']); ?></td>
                <td><?= ($t['ditugaskan'] == 1) ? 'Ya' : 'Tidak' ?></td>
                <td>
                  <?php if ($t['ditugaskan'] == 1) : ?>
                    <a href="/aplikasi/guru/data-tugas/<?= $t['id']; ?>" class="badge badge-info"><i class="fa fa-eye fa-fw"></i> Lihat data</a>
                  <?php endif ?>
                  <a href="/aplikasi/guru/detail-tugas/<?= $t['id']; ?>" class="badge badge-success"><i class="fa fa-eye fa-fw"></i> Lihat tugas</a>
                  <a href="/aplikasi/guru/ubah-tugas/<?= $t['id']; ?>" class="badge badge-warning" id="btnUbahTugas"><i class="fas fa-pen fa-fw"></i> Ubah</a>
                  <a href="#" class="badge badge-danger" id="btnHapusTugas" data-id="<?= $t['id']; ?>"><i class="fa fa-trash fa-fw"></i> Hapus</a>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- /.container-fluid -->

</div>

<!-- Tambah Tugas Modal-->
<div class="modal fade" id="tambahTugasModal" tabindex="-1" role="dialog" aria-labelledby="tambahTugasModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahTugasModal">Tambah Tugas</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form action="/aplikasi/guru/tambah_tugas" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="modal-body">
          <?= csrf_field(); ?>
          <div class="form-group">
            <input type="text" class="form-control" id="judul" placeholder="Judul tugas" name="judul" value="<?= old('judul'); ?>">
          </div>
          <div class="form-group">
            <select class="form-control" name="kelas_jurusan" id="kelas_jurusan">
              <option value="">Pilih Kelas dan Jurusan</option>
              <?php foreach ($mapel as $m) : ?>
                <option value="<?= $m['id']; ?>"><?= $m['kelas'] . ' - ' . $m['jurusan']; ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="kategori" placeholder="Kategori tugas" name="kategori" value="<?= old('kategori'); ?>">
            <small class="form-text text-muted">
              contoh: soal, catatan, materi
            </small>
          </div>
          <div class="form-group">
            <textarea class="form-control" id="text" placeholder="Deskripsi" name="deskripsi" rows="3"><?= old('deskripsi'); ?></textarea>
          </div>
          <div class="form-group">
            <label for="file">Tambahkan File/Foto : </label>
            <div class="custom-file">
              <input type="file" class="custom-file-input <?= ($validation->hasError('file')) ? 'is-invalid' : '' ?>" id="file" name="file[]" multiple>
              <div class="invalid-feedback">
                <?= $validation->getError('file') ?>
              </div>
              <label class="custom-file-label" for="file" id="pilihFile">Pilih File</label>
            </div>
            <div id="namaFile" class="mt-2"></div>
          </div>
          <div class="form-group" id="info">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="customCheck" name="ditugaskan" value="1">
              <label class="custom-control-label" for="customCheck">Ditugaskan</label>
              <i class="far fa-question-circle fa-fw"></i>
            </div>
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


<script>
  const i = document.querySelector('#info i');
  i.addEventListener('click', function(e) {
    swal('Apa itu ditugaskan?', 'Jika kamu mencentang "ditugaskan" maka siswa diwajibkan untuk mengumpul tugas yang kamu berikan.', 'info')
  });
  // HAPUS TUGAS
  $('a#btnHapusTugas').click(function(e) {
    e.preventDefault();
    swal({
        title: "Apa kamu yakin?",
        text: "Jika kamu hapus tugas ini, maka data tugas dari siswa akan terhapus!",
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
                  url: "/aplikasi/guru/hapus_tugas",
                  data: {
                    id: id
                  },
                  success: function(r) {
                    swal("Data berhasil dihapus!", {
                      icon: "success",
                    }).then((dihapus) => {
                      window.location.href = '/aplikasi/guru/tugas';
                    });
                  }
                });
              } else {
                swal('Kode Salah!', 'Kode yang kamu masukan tidak sesuai!', 'error')
              }
            });
        } else {
          swal("Data tugas aman.");
        }
      });
  });
</script>
<?= $this->endSection() ?>