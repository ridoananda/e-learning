<?php

namespace App\Controllers\Aplikasi;

use App\Controllers\BaseController;

class Menu extends BaseController
{
  public function index()
  {
    $data = [
      'title' => 'Menu Management',
      'db' => \Config\Database::connect(),
      'user' => $this->userModel->getUser($this->id),
      'menu' => $this->db->table('user_menu')->where(['menu !=' => 'Admin'])->get()->getResultArray(),
      'validation' => \Config\Services::validation()
    ];
    return view('aplikasi/admin/menu', $data);
  }

  public function submenu()
  {
    $submenu = $this->db->table('user_sub_menu')
      ->select('user_sub_menu.*, user_menu.menu')
      ->join('user_menu', 'user_sub_menu.menu_id = user_menu.id')
      ->orderBy('id', 'DESC')
      ->get()
      ->getResultArray();
    $data = [
      'title' => 'Sub Menu Management',
      'db' => \Config\Database::connect(),
      'user' => $this->userModel->getUser($this->id),
      'submenu' => $submenu,
      'menu' => $this->db->table('user_menu')->get()->getResultArray(),
      'validation' => \Config\Services::validation()
    ];
    return view('aplikasi/admin/submenu', $data);
  }

  public function ubah_submenu($id)
  {
    $submenu = $this->db->table('user_sub_menu')
      ->select('user_sub_menu.*, user_menu.menu')
      ->join('user_menu', 'user_sub_menu.menu_id = user_menu.id')
      ->where('user_sub_menu.id', $id)
      ->orderBy('id', 'DESC')
      ->get()
      ->getRowArray();
    $data = [
      'title' => 'Sub Menu Management',
      'db' => \Config\Database::connect(),
      'user' => $this->userModel->getUser($this->id),
      'submenu' => $submenu,
      'menu' => $this->db->table('user_menu')->get()->getResultArray(),
      'validation' => \Config\Services::validation()
    ];
    return view('aplikasi/admin/ubah-submenu', $data);
  }

  /* <========================= TAMBAH =========================> */
  // Tambah menu
  public function addMenu()
  {
    if (!$this->validate([
      'menu' => 'required|is_unique[user_menu.menu]|string',
    ])) {
      return redirect()->to('/aplikasi/menu')->withInput();
    }
    $menu = htmlspecialchars($this->request->getPost('menu'));
    $this->db->table('user_menu')->insert(['menu' => $menu]);
    session()->setFlashdata('berhasil', 'Menu berhasil ditambahkan!');
    return redirect()->to('/aplikasi/menu')->withInput();
  }

  // Tambah Sub Menu
  public function tambah_sub_menu()
  {
    if (!$this->validate([
      'menu_id' => [
        'label' => 'Menu',
        'rules' => 'required|string'
      ],
      'title' => [
        'label' => 'Judul',
        'rules' => 'required'
      ],
      'url' => [
        'label' => 'URL',
        'rules' => 'required'
      ],
      'icon' => 'required',
    ])) {
      return redirect()->to('/aplikasi/menu/submenu')->withInput();
    }
    $data = [
      'menu_id' => htmlspecialchars($this->request->getPost('menu_id')),
      'title' => htmlspecialchars($this->request->getPost('title')),
      'url' => htmlspecialchars($this->request->getPost('url')),
      'icon' => htmlspecialchars($this->request->getPost('icon')),
      'is_active' => htmlspecialchars($this->request->getPost('is_active')),
    ];
    $this->db->table('user_sub_menu')->insert($data);
    session()->setFlashdata('berhasil', 'Submenu berhasil ditambahkan!');
    return redirect()->to('/aplikasi/menu/submenu');
  }


  /* <========================= HAPUS =========================> */

  public function hapus_sub_menu()
  {
    if ($this->request->isAJAX()) {
      $id = $this->request->getPost('id');
      session()->setFlashdata('berhasil', 'Submenu berhasil dihapus!');
      return $this->db->table('user_sub_menu')->delete(['id' => $id]);
    } else {
      return redirect()->to('/auth/blocked');
    }
  }

  public function hapus_menu()
  {
    if ($this->request->isAJAX()) {
      $id = $this->request->getPost('id');
      session()->setFlashdata('berhasil', 'Menu berhasil dihapus!');
      return $this->db->table('user_menu')->delete(['id' => $id]);
    } else {
      return redirect()->to('/auth/blocked');
    }
  }

  /* <========================= UBAH =========================> */
  public function update_sub_menu($id)
  {
    if (!$this->validate([
      'menu_id' => [
        'label' => 'Menu',
        'rules' => 'required|string'
      ],
      'title' => [
        'label' => 'Judul',
        'rules' => 'required'
      ],
      'url' => [
        'label' => 'URL',
        'rules' => 'required'
      ],
      'icon' => 'required',
    ])) {
      return redirect()->to('/aplikasi/menu/ubah_submenu/' . $id)->withInput();
    }
    $is_active = ($this->request->getPost('is_active') == NULL) ? 0 : 1;
    $data = [
      'id' => $id,
      'menu_id' => htmlspecialchars($this->request->getPost('menu_id')),
      'title' => htmlspecialchars($this->request->getPost('title')),
      'url' => htmlspecialchars($this->request->getPost('url')),
      'icon' => htmlspecialchars($this->request->getPost('icon')),
      'is_active' => $is_active,
    ];
    $this->db->table('user_sub_menu')->update($data, ['id' => $id]);
    session()->setFlashdata('berhasil', 'Submenu berhasil diubah!');
    return redirect()->to('/aplikasi/menu/submenu');
  }

  public function ubah_menu($id)
  {
    if ($this->request->isAJAX()) {
      if (!$this->validate([
        'menu' => 'required|string',
      ])) {
        return redirect()->withInput();
      }
      $menu = htmlspecialchars($this->request->getPost('menu'));
      session()->setFlashdata('berhasil', 'Menu berhasil diubah!');
      return $this->db->table('user_menu')->update(['menu' => $menu], ['id' => $id]);
    } else {
      return redirect()->to('/auth/blocked');
    }
  }
}
