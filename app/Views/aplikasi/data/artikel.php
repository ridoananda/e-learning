<?= $this->extend('aplikasi/layout/template') ?>
<?= $this->section('content') ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
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
          <h6 class="m-0 font-weight-bold text-primary">Daftar Seluruh Artikel</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Judul</th>
                  <th>Nama Pengupload</th>
                  <th>Kategori</th>
                  <th>text</th>
                  <th>Aktif</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($artikel as $a) :
                  $user_upload = $db->table('user')->where(['id' => $a['user_id']])->get()->getRowArray();
                  $kategori = $db->table('kategori_artikel')->where(['id' => $a['kategori_id']])->get()->getRowArray();
                ?>
                  <tr>
                    <td scope="row"><?= $no++; ?></td>
                    <td><?= $a['judul']; ?></td>
                    <td><?= $user_upload['nama_lengkap']; ?></td>
                    <td><?= $kategori['kategori']; ?></td>
                    <td><?= word_limiter($a['text'], 10); ?></td>
                    <td>
                      <?= ($a['aktif'] == 1) ? 'Ya' : 'Tidak'; ?>
                    </td>
                    <td>
                      <a class="badge badge-success" href="/artikel/<?= $a['slug']; ?>"><i class="fas fa-eye fa-sm fa-fw"></i> Lihat</a>
                      <a class="badge badge-danger" href="#" data-id="<?= $a['id']; ?>" id="btnHapusData"><i class="fas fa-trash fa-fw"></i> Hapus</a>
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


<script>
  // HAPUS ABSEN
  $('a#btnHapusData').click(function(e) {
    e.preventDefault();
    swal({
        title: "Apa kamu yakin?",
        text: "Jika kamu Hapus artikel ini, maka seluruh komentar dari artikel ini akan terhapus!",
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
                  url: "/aplikasi/data/hapus_artikel",
                  data: {
                    id: id
                  },
                  success: function(r) {
                    swal("Artikel berhasil dihapus!", {
                      icon: "success",
                    }).then((dihapus) => {
                      window.location.href = '/aplikasi/data/artikel';
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