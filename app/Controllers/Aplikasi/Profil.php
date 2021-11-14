<?php

namespace App\Controllers\Aplikasi;

use App\Controllers\BaseController;

class Profil extends BaseController
{
  public function index()
  {
    $user = $this->userModel->getUser($this->id);
    $data = [
      'title' => 'Profil Saya',
      'user' => $user,
      'db' => \Config\Database::connect(),
      'user_mapel' => $this->db->table('user_mapel')->where('id', $user['mapel_id'])->get()->getRowArray(),
    ];
    return view('aplikasi/profil/index', $data);
  }

  public function edit()
  {
    $data = [
      'title' => 'Edit Profil',
      'user' => $this->userModel->getUser($this->id),
      'db' => \Config\Database::connect(),
      'validation' => \Config\Services::validation(),
    ];
    return view('aplikasi/profil/edit', $data);
  }

  public function log_aktivitas()
  {
    // $time = Time::parse('2020-10-23 11:40:14');
    $data = [
      'title' => 'Log Aktivitas',
      'db' => \Config\Database::connect(),
      'user' => $this->userModel->getUser($this->id),
      'log' => $this->logModel->where(['user_id' => $this->id])->orderBy('id', 'desc')->findAll(),
    ];
    return view('aplikasi/profil/log-aktivitas', $data);
  }

  public function ubah_password()
  {
    $data = [
      'title' => 'Ubah Password',
      'db' => \Config\Database::connect(),
      'user' => $this->userModel->getUser($this->id),
      'validation' => \Config\Services::validation(),
    ];
    return view('aplikasi/profil/ubah-password', $data);
  }



  /* <========================= UBAH =========================> */
  public function update_profil()
  {
    if (!$this->validate([
      'nama_lengkap' => [
        'label' => 'Nama lengkap',
        'rules' => 'required|string'
      ],
      'alamat' => [
        'label' => 'Alamat',
        'rules' => 'required'
      ],
      'image' => [
        'label' => 'Foto',
        'rules' => 'max_size[image,3000]|mime_in[image,image/png,image/jpeg,image/jpg]|is_image[image]'
      ]
    ])) {
      return redirect()->to('/aplikasi/profil/edit')->withInput();
    }
    $image = $this->request->getFile('image');
    $foto_lama = $this->request->getPost('foto_lama');


    if ($this->request->getFile('image')->getError() == 4) {
      $foto = $foto_lama;
    } else {
      if ($foto_lama != 'default.jpg') {
        unlink('template/img/profil/' . $this->request->getPost('foto_lama'));
        $foto = $image->getRandomName();
        $image->move('template/img/profil', $foto);
      } else {
        $foto = $image->getRandomName();
        $image->move('template/img/profil', $foto);
      }
    }
    $data = [
      'id' => $this->id,
      'slug' => url_title($this->request->getPost('nama_lengkap', FILTER_SANITIZE_STRING), '-', TRUE),
      'nama_lengkap' => htmlspecialchars($this->request->getPost('nama_lengkap')),
      'alamat' => htmlspecialchars($this->request->getPost('alamat')),
      'foto' => $foto
    ];
    $this->userModel->updateUser($data);
    session()->setFlashdata('berhasil', 'Profil berhasil diubah');
    return redirect()->to('/aplikasi/profil');
  }

  public function update_password()
  {
    if (!$this->validate([
      'password_lama' => [
        'label' => 'Password lama',
        'rules' => 'required|min_length[6]'
      ],
      'password_baru' => [
        'label' => 'Password baru',
        'rules' => 'required|min_length[6]'
      ],
      'konf_password_baru' => [
        'label' => 'Konfirmasi password baru',
        'rules' => 'required|min_length[6]|matches[password_baru]'
      ]
    ])) {
      return redirect()->to('/aplikasi/profil/ubah-password')->withInput();
    }
    $user = $this->userModel->getUser($this->id);
    if (password_verify($this->request->getPost('password_lama'), $user['password'])) {
      $data = [
        'id' => $this->id,
        'password' => password_hash(htmlspecialchars($this->request->getPost('password_baru')), PASSWORD_DEFAULT),
      ];
      $this->userModel->updateUser($data);
      session()->setFlashdata('berhasil', 'Password berhasil diubah!');
      return redirect()->to('/aplikasi/profil');
    } else {
      session()->setFlashdata('gagal', 'Password lama salah!');
      return redirect()->to('/aplikasi/profil/ubah-password');
    }
  }
}
