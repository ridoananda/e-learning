    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon">
          <img class="rounded-circle" src="/template/img/logo.jpg" width="60">
        </div>
        <div class="sidebar-brand-text mx-3">Yapim Taruna</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-2">

      <!-- Query Menu -->

      <?php
      $roleId = session()->get('role_id');
      $menu = $db->table('user_menu')
        ->select('user_menu.id, menu')
        ->join('user_access_menu', 'user_menu.id = user_access_menu.menu_id')
        ->where('user_access_menu.role_id', $roleId)
        ->get()
        ->getResultArray();
      foreach ($menu as $m) : ?>

        <div class="sidebar-heading">
          <?= $m['menu']; ?>
        </div>

        <?php
        $menuId = $m['id'];
        $subMenu = $db->table('user_sub_menu')
          ->select('*')
          ->where('menu_id', $menuId)
          ->where('is_active', 1)
          ->get()->getResultArray();
        foreach ($subMenu as $sm) : ?>
          <!-- Query Submenu -->
          <?php if ($title == $sm['title']) : ?>
            <li class="nav-item active">
            <?php else : ?>
            <li class="nav-item">
            <?php endif ?>
            <a class="nav-link pb-0" href="/aplikasi/<?= $sm['url']; ?>">
              <i class="<?= $sm['icon']; ?>"></i>
              <span><?= $sm['title']; ?></span>
            </a>
            </li>
          <?php endforeach ?>

          <hr class="sidebar-divider my-3">
        <?php endforeach ?>

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>