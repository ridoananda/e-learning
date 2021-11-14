<?= $this->extend('aplikasi/layout/template') ?>
<?= $this->section('content') ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
  <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahRoleModal"><i class="fas fa-plus-circle fa-fw"></i> Tambah Role</button>
  <!-- Content Row -->
  <div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-8 col-md-10 mb-2">
      <?php if (session()->getFlashdata('berhasil')) : ?>
        <div class="alert alert-success">
          <small><?= session()->getFlashdata('berhasil') ?></small>
        </div>
      <?php endif ?>
      <?php if ($validation->hasError('role')) : ?>
        <div class="alert alert-danger">
          <?= $validation->getError('role') ?>
        </div>
      <?php endif ?>
      <div class="card shadow mt-3 mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Role</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Role</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($role as $r) : ?>
                  <tr>
                    <td scope="row"><?= $no++; ?></td>
                    <td><?= $r['name']; ?></td>
                    <td>
                      <a class="badge badge-warning" href="/aplikasi/admin/role_access/<?= $r['id']; ?>"><i class="fas fa-user-shield fa-sm fa-fw"></i> Akses</a>
                      <?php if ($r['id'] != 1) : ?>
                        <a class="badge badge-info" href="#" id="btnUbahRole" data-id="<?= $r['id'] ?>" data-name="<?= $r['name'] ?>" data-target="#ubahRoleModal"><i class=" fas fa-pen fa-sm fa-fw"></i> Edit</a>
                        <a class="badge badge-danger" href="#" id="btnHapusRole" data-id="<?= $r['id'] ?>"><i class="fa fa-trash fa-sm fa-fw"></i> Hapus</a>
                      <?php endif ?>
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
<div class="modal fade" id="tambahRoleModal" tabindex="-1" role="dialog" aria-labelledby="tambahRoleModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahRoleModal">Tambah Role</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form action="/aplikasi/admin/tambah_role" method="POST">
        <?= csrf_field(); ?>
        <div class="modal-body">
          <div class="form-group">
            <input type="text" class="form-control" id="role" placeholder="Nama Role" name="name">
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

<!-- UBAH Role Modal-->
<div class="modal fade" id="ubahRoleModal" tabindex="-1" role="dialog" aria-labelledby="ubahRoleModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ubahRoleModal">Ubah Role</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form action="" method="POST" id="ubahRole">
        <?= csrf_field(); ?>
        <div class="modal-body">
          <div class="form-group">
            <input type="text" class="form-control" id="role" placeholder="Nama Role" name="name">
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
  // HAPUS Role
  $('a#btnHapusRole').click(function(e) {
    e.preventDefault();
    swal({
        title: "Apa kamu yakin?",
        text: "Jika kamu menghapus role ini, maka seluruh user dengan role tersebut akan terhapus!",
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
                  url: "/aplikasi/admin/hapus_role",
                  data: {
                    id: id
                  },
                  success: function(r) {
                    swal("Role berhasil dihapus!", {
                      icon: "success",
                    }).then((dihapus) => {
                      window.location.href = '/aplikasi/admin/role';
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