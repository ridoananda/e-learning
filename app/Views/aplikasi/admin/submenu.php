<?= $this->extend('aplikasi/layout/template') ?>
<?= $this->section('content') ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
  <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahSubMenuModal"><i class="fas fa-plus-circle fa-fw"></i> Tambah Sub Menu</button>
  <!-- Content Row -->
  <div class="row">

    <div class="col-xl-12 col-md-12 mb-2">
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
          <h6 class="m-0 font-weight-bold text-primary">Daftar Menu</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Judul</th>
                  <th>Menu</th>
                  <th>URL</th>
                  <th>Icon</th>
                  <th>Aktif</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($submenu as $sm) : ?>
                  <tr>
                    <td scope="row"><?= $no++; ?></td>
                    <td><?= $sm['title']; ?></td>
                    <td><?= $sm['menu']; ?></td>
                    <td><?= $sm['url']; ?></td>
                    <td><i class="<?= $sm['icon']; ?>"></i> ( <?= $sm['icon']; ?> )</td>
                    <td>
                      <?= ($sm['is_active'] == 1) ? 'Ya' : 'Tidak'; ?>
                    </td>
                    <td>
                      <a class="badge badge-info" href="/aplikasi/menu/ubah_submenu/<?= $sm['id']; ?>" id="btnEditSubMenu"><i class="fas fa-pen fa-fw"></i> Edit</a>
                      <a class="badge badge-danger" href="#" data-id="<?= $sm['id']; ?>" id="btnHapusSubMenu"><i class="fas fa-trash fa-fw"></i> Hapus</a>
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



<!-- Tambah SubMenu Modal-->
<div class="modal fade" id="tambahSubMenuModal" tabindex="-1" role="dialog" aria-labelledby="tambahSubMenuModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahSubMenuModal">Tambah Sub Menu</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/aplikasi/menu/tambah_sub_menu" method="POST">
          <?= csrf_field(); ?>
          <div class="form-group">
            <input type="text" class="form-control" id="title" placeholder="Judul submenu" name="title" value="<?= old('title'); ?>">
          </div>
          <div class="form-group">
            <select class="form-control" name="menu_id" id="menu_id">
              <option value="">Pilih Menu</option>
              <?php foreach ($menu as $m) : ?>
                <option value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="url" placeholder="URL submenu" name="url" value="<?= old('url'); ?>">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="icon" placeholder="Icon submenu" name="icon" value="<?= old('icon'); ?>">
          </div>
          <div class="form-group">
            <div class="form-check">
              <label class="form-check-label">
                <input type="checkbox" class="form-check-input" name="is_active" id="is_active" value="1" checked>
                Ini aktif?
              </label>
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
</div>


<script>
  // HAPUS SUBMENU
  $('a#btnHapusSubMenu').click(function(e) {
    e.preventDefault();
    swal({
        title: "Apa kamu yakin?",
        text: "Jika kamu menghapus Sub Menu ini, maka seluruh Sub Menu pada user akan terhapus!!",
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
                  url: "/aplikasi/menu/hapus_sub_menu",
                  data: {
                    id: id
                  },
                  success: function(r) {
                    swal("Submenu berhasil dihapus!", {
                      icon: "success",
                    }).then((dihapus) => {
                      window.location.href = '/aplikasi/menu/submenu';
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