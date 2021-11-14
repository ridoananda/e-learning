<div id="content-wrapper" class="d-flex flex-column">

  <!-- Main Content -->
  <div id="content">

    <!-- Topbar -->
    <?php
    $notifModel = new \App\Models\NotifikasiModel();
    $notifikasiRow = $notifModel->getRow(session()->get('id'));

    if (session()->get('role_id') == 1) {
      $menu = 'admin';
    } else if (session()->get('role_id') == 2) {
      $menu = 'guru';
    } else {
      $menu = 'siswa';
    }
    ?>
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

      <!-- Sidebar Toggle (Topbar) -->
      <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
      </button>

      <!-- Topbar Navbar -->
      <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
          <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell fa-fw"></i>
            <!-- Counter - Alerts -->
            <?php if ($notifikasiRow) : ?>
              <span class="badge badge-danger badge-counter">
                <?= ($notifikasiRow > 100) ? '100+' : $notifikasiRow; ?>
              </span>
            <?php endif ?>
          </a>
          <!-- Dropdown - Alerts -->
          <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
            <h6 class="dropdown-header">
              Notifikasi
            </h6>
            <?php foreach ($notifModel->getResult(session()->get('id')) as $notif) : ?>
              <a class="dropdown-item d-flex align-items-center <?= ($notif['is_cek'] == 1) ? '' : 'bg-gray-200'; ?>" href="#" data-id=" <?= $notif['id']; ?>" data-url="<?= $notif['url']; ?>" data-menu="<?= $menu; ?>" id="lihatNotif">
                <div class="mr-3">
                  <div class="icon-circle bg-info">
                    <i class="fas fa-fw <?= $notif['icon']; ?> text-white"></i>
                  </div>
                </div>
                <div>
                  <div class="small text-gray-500"><?= waktu_lalu($notif['created_at']); ?></div>
                  <span><?= $notif['text']; ?></span>
                </div>
              </a>
            <?php endforeach ?>
            <?php if (empty($notifModel->getResult(session()->get('id')))) : ?>
              <a href="#" class="dropdown-item text-center">
                Notifikasi tidak tersedia.
              </a>
            <?php endif ?>
            <a class="dropdown-item text-center small text-gray-500" href="/aplikasi/<?= $menu; ?>/notifikasi">Lihat Semua</a>
          </div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $user['nama_lengkap']; ?></span>
            <img class="img-profile rounded-circle" src="/template/img/profil/<?= $user['foto'] ?>">
          </a>
          <!-- Dropdown - User Information -->
          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
              Keluar
            </a>
          </div>
        </li>

      </ul>

    </nav>
    <!-- End of Topbar -->