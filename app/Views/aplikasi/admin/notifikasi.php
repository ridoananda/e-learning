<?= $this->extend('aplikasi/layout/template') ?>
<?= $this->section('content') ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-3 text-gray-800">Notifikasi</h1>
  <?php if ($notifikasi) : ?>
    <div class="row">
      <div class="col-lg-6">
        <?php if (session()->getFlashdata('berhasil')) : ?>
          <div class="alert text-center alert-success mb-3">
            <?= session()->getFlashdata('berhasil') ?>
          </div>
        <?php endif ?>
        <div class="d-flex justify-content-end">
          <button type="button" class="btn btn-danger rounded-pill btn-sm btn btn-icon-split mb-3" id="hapusNotif">
            <span class="icon text-white-50">
              <i class="fas fa-trash fa-sm fa-fw"></i>
            </span>
            <span class="text">Hapus Semua</span>
          </button>
        </div>
        <ul class="list-group">
          <?php foreach ($notifikasi as $n) : ?>
            <li class="list-group-item d-flex justify-content-between align-items-center <?= ($n['is_cek'] == 1) ? '' : 'bg-gray-200'; ?>">
              <span class="mr-1">
                <?= $n['text']; ?> <small class="text-gray-500"><?= waktu_lalu($n['created_at']); ?></small>
              </span>
              <a class="badge badge-info badge-pill" href="#" data-id=" <?= $n['id']; ?>" data-url="<?= $n['url']; ?>" data-menu="guru" id="lihatNotif"><i class="fas fa-eye fa-sm fa-fw"></i> Lihat</a>
            </li>
          <?php endforeach ?>
        </ul>
        <?= $pager->links('notifikasi', 'notifikasi'); ?>
      </div>
    </div>
  <?php else : ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <strong>Notifikasi</strong> tidak tersedia!
    </div>

  <?php endif ?>

</div>
<!-- /.container-fluid -->

<script>
  // HAPUS NOTIFIKASI
  $('#hapusNotif').click(function(e) {
    e.preventDefault();
    swal({
        title: "Apa kamu yakin?",
        text: "Seluruh notifikasi kamu akan terhapus semua!",
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
                  url: "/aplikasi/admin/hapus_notifikasi",
                  data: {
                    id: id
                  },
                  success: function(r) {
                    swal("Semua notifikasi berhasil dihapus!", {
                      icon: "success",
                    }).then((dihapus) => {
                      window.history.back();
                    });
                  }
                });
              } else {
                swal('Kode Salah!', 'Kode yang kamu masukan tidak sesuai!', 'error')
              }
            });
        } else {
          swal("Notifikasi tidak terhapus.");
        }
      });
  });
</script>
<?= $this->endSection() ?>