<?= $this->extend('aplikasi/layout/template') ?>
<?= $this->section('content') ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Artikel Saya</h1>

  <div class="row">
    <div class="col-md-6">
      <?php if (session()->getFlashdata('berhasil')) : ?>
        <div class="alert alert-success text-center">
          <?= session()->getFlashdata('berhasil') ?>
        </div>
      <?php endif ?>
      <a href="/aplikasi/guru/buat-artikel" class="btn btn-primary btn btn-icon-split mt-2">
        <span class="icon text-white-50">
          <i class="fas fa-plus-circle fa-sm fa-fw"></i>
        </span>
        <span class="text">Tambah artikel</span>
      </a>
    </div>
  </div>

  <div class="row mt-4">
    <!-- Content Row -->
    <?php foreach ($artikel as $art) :
      $kategori = $db->table('kategori_artikel')->where(['id' => $art['kategori_id']])->get()->getRowArray() ?>
      <div class="col-md-4 col-sm-6">
        <div class="card mb-3">
          <img src="/template/img/thumbnail/<?= $art['thumbnail']; ?>" class="card-img-top" alt="Thumbnail artikel">
          <div class="card-body">
            <h4 class="text-gray-800"><?= $art['judul']; ?></h4>
            <p class="card-text mb-1">
              <small class="text-muted d-inline">
                <span><i class="far fa-user fa-fw"></i> <?= $user['nama_lengkap']; ?></span>
                <span class="mr-2"><i class="far fa-folder-open fa-fw"></i> <?= $kategori['kategori']; ?></span>
                <span class="d-block"><i class="far fa-clock fa-fw"></i> <?= tanggal_lengkap($art['created_at']) ?></span>
              </small>
            </p>
            <p class="card-text"><?php // word_limiter($art['text'], 10); ?></p>
            <div class="d-flex justify-content-end">
              <a href="/artikel/<?= $art['slug']; ?>" class="btn btn-primary btn-sm mr-2"><i class="fas fa-eye fa-sm fa-fw"></i> Lihat</a>
              <a href="/aplikasi/guru/update-artikel/<?= $art['slug']; ?>" class="btn btn-warning btn-sm mr-2"><i class="fas fa-edit fa-sm fa-fw"></i> Ubah</a>
              <a href="#" class="btn btn-danger btn-sm" id="btnHapusArtikel" data-id="<?= $art['id']; ?>"><i class="fa fa-trash fa-fw fa-sm"></i> Hapus</a>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach ?>
  </div>
  <?= $pager->links('artikel', 'artikel'); ?>
</div>
<!-- /.container-fluid -->
<script>
  // HAPUS ABSEN
  $('a#btnHapusArtikel').click(function(e) {
    e.preventDefault();
    swal({
        title: "Apa kamu yakin?",
        text: "Jika kamu hapus artikel ini, maka komentar juga akan terhapus!",
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
                  url: "/aplikasi/guru/hapus_artikel",
                  data: {
                    id: id
                  },
                  success: function(r) {
                    swal("Artikel berhasil dihapus!", {
                      icon: "success",
                    }).then((dihapus) => {
                      window.location.href = '/aplikasi/guru/artikel';
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