<?= $this->extend('aplikasi/layout/template') ?>
<?= $this->section('content') ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
  <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahMenuModal"><i class="fas fa-plus-circle fa-fw"></i> Tambah Menu</button>
  <!-- Content Row -->
  <div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-8 col-md-10 mb-2">
      <?php if (session()->getFlashdata('berhasil')) : ?>
        <div class="alert alert-success">
          <?= session()->getFlashdata('berhasil') ?>
        </div>
      <?php endif ?>
      <?php if ($validation->getErrors()) : ?>
        <div class="alert alert-danger">
          <?= $validation->getError('menu') ?>
        </div>
      <?php endif ?>
      <div class="card shadow mt-3 mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Daftar Menu</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Menu</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($menu as $m) : ?>
                  <tr>
                    <td scope="row"><?= $no++; ?></td>
                    <td><?= $m['menu']; ?></td>
                    <td>
                      <a class="badge badge-info" href="#" id="btnUbahMenu" data-id="<?= $m['id']; ?>" data-menu="<?= $m['menu']; ?>"><i class="fas fa-pen fa-fw"></i> Edit</a>
                      <a class="badge badge-danger" href="#" data-id="<?= $m['id']; ?>" id="btnHapusMenu"><i class="fas fa-trash fa-fw"></i> Hapus</a>
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

<!-- Tambah Menu Modal-->
<div class="modal fade" id="tambahMenuModal" tabindex="-1" role="dialog" aria-labelledby="tambahMenuModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahMenuModal">Tambah Menu</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form action="/aplikasi/menu/addMenu" method="POST">
        <?= csrf_field(); ?>
        <div class="modal-body">
          <div class="form-group">
            <input type="text" class="form-control" id="menu" placeholder="Nama Menu" name="menu" value="<?= old('icon'); ?>">
          </div>
        </div>
        <div class=" modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">batal</button>
          <button class="btn btn-primary" type="submit">Tambah</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- UBAH SubMenu Modal-->
<div class="modal fade" id="ubahMenuModal" tabindex="-1" role="dialog" aria-labelledby="ubahMenuModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ubahMenuModal">Ubah Menu</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form action="/aplikasi/menu/hapus_menu" method="POST" id="ubahMenu">
        <?= csrf_field(); ?>
        <div class="modal-body">
          <div class="form-group">
            <input type="text" class="form-control" id="menu" placeholder="Nama Menu" name="menu">
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
  $('a#btnHapusMenu').click(function(e) {
    e.preventDefault();
    swal({
        title: "Apa kamu yakin?",
        text: "Jika kamu menghapus Menu ini, maka seluruh Menu pada user akan terhapus!!",
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
                  url: "/aplikasi/menu/hapus_menu",
                  data: {
                    id: id
                  },
                  success: function(r) {
                    swal("Menu berhasil dihapus!", {
                      icon: "success",
                    }).then((dihapus) => {
                      window.location.href = '/aplikasi/menu';
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