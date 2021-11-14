<?php

namespace App\Controllers\Aplikasi;

use App\Controllers\BaseController;

class Data extends BaseController
{
  public function index()
  {
    $data = [
      'title' => 'Guru',
      'user' => $this->userModel->getUser($this->id),
      'db' => \Config\Database::connect(),
      'validation' => \Config\Services::validation(),
      'guru' => $this->userModel->where(['role_id' => 2])->findAll(),
      'user_mapel' => $this->db->table('user_mapel')->where(['user_role' => 2])->get()->getResultArray()
    ];
    return view('aplikasi/data/index', $data);
  }
  public function ubah_data($id)
  {
    $data = [
      'title' => 'Guru',
      'user' => $this->userModel->getUser($this->id),
      'db' => \Config\Database::connect(),
      'validation' => \Config\Services::validation(),
      'guru' => $this->userModel->where(['role_id' => 2, 'id' => $id])->first(),
      'user_mapel' => $this->db->table('user_mapel')->where(['user_role' => 2])->get()->getResultArray()
    ];
    return view('aplikasi/data/ubah-data', $data);
  }
  public function ubah_siswa($id)
  {
    $data = [
      'title' => 'Siswa',
      'user' => $this->userModel->getUser($this->id),
      'db' => \Config\Database::connect(),
      'validation' => \Config\Services::validation(),
      'siswa' => $this->userModel->where(['role_id' => 3, 'id' => $id])->first(),
      'user_mapel' => $this->db->table('user_mapel')->where(['user_role' => 3])->orderBy('kelas', 'DESC')->get()->getResultArray()
    ];
    return view('aplikasi/data/ubah-siswa', $data);
  }

  public function siswa()
  {
    $data = [
      'title' => 'Siswa',
      'user' => $this->userModel->getUser($this->id),
      'db' => \Config\Database::connect(),
      'validation' => \Config\Services::validation(),
      'siswa' => $this->userModel->where(['role_id' => 3])->orderBy('mapel_id', 'DESC')->findAll(),
      'user_mapel' => $this->db->table('user_mapel')->where(['user_role' => 3])->get()->getResultArray()
    ];
    return view('aplikasi/data/siswa', $data);
  }


  public function artikel()
  {
    $data = [
      'title' => 'Artikel',
      'user' => $this->userModel->getUser($this->id),
      'db' => \Config\Database::connect(),
      'validation' => \Config\Services::validation(),
      'artikel' => $this->artikelModel->orderBy('id', 'DESC')->findAll(),
      'user_mapel' => $this->db->table('user_mapel')->where(['user_role' => 3])->get()->getResultArray()
    ];
    return view('aplikasi/data/artikel', $data);
  }





  /* <========================= TAMBAH =========================> */
  public function add_data()
  {
    if (!$this->validate([
      'nama_lengkap' => [
        'label' => 'Nama lengkap',
        'rules' => 'required|max_length[35]|string'
      ],
      'email' => 'required|is_unique[user.email]|valid_email',
      'mapel_id' =>  [
        'label' => 'Mata Pelajaran/Kelas dan Jurusan',
        'rules' => 'required'
      ],
      'alamat' => 'required',
    ])) {
      return redirect()->to('/aplikasi/data')->withInput();
    }

    $password = strtolower('sekolahkita123');
    $slug = url_title($this->request->getPost('nama_lengkap', FILTER_SANITIZE_STRING), '-', TRUE);
    $cookie = base64_encode($this->request->getPost('email', FILTER_SANITIZE_EMAIL));
    $data = [
      'nama_lengkap' => $this->request->getPost('nama_lengkap', FILTER_SANITIZE_STRING),
      'slug' => $slug,
      'alamat' => $this->request->getPost('alamat', FILTER_SANITIZE_STRING),
      'foto' => 'default.jpg',
      'email' => $this->request->getPost('email', FILTER_SANITIZE_STRING),
      'password' => password_hash($password, PASSWORD_DEFAULT),
      'cookie' => hash('sha256', $cookie),
      'role_id' => ($this->request->getPost('r') == 'g') ? 2 : 3,
      'mapel_id' => $this->request->getPost('mapel_id', FILTER_VALIDATE_INT),
      'is_active' => 1,
    ];
    $this->userModel->save($data);
    session()->setFlashdata('berhasil', 'Akun Berhasil Ditambahkan! Dengan password <b>' . $password . '</b>');
    $redirect = ($this->request->getPost('r') == 'g') ? '/aplikasi/data' : '/aplikasi/data/siswa';
    return redirect()->to($redirect);
  }


  /* <========================= UBAH DATA =========================> */

  public function update_data($id)
  {
    $email = htmlspecialchars($this->request->getPost('email'));
    $user = $this->userModel->getUser($id);
    if ($email == $user['email']) {
      $rules = 'required|valid_email';
    } else {
      $rules = 'required|is_unique[user.email]|valid_email';
    }

    if (!$this->validate([
      'nama_lengkap' => [
        'label' => 'Nama lengkap',
        'rules' => 'required|max_length[35]|string'
      ],
      'email' => $rules,
      'mapel_id' => 'required',
      'alamat' => 'required',
    ])) {
      return redirect()->to('/aplikasi/data/ubah-data/' . $id)->withInput();
    }

    $password = $this->request->getPost('password');
    if ($password == NULL) {
      $password = $this->request->getPost('password_lama');
    } else {
      $password = password_hash(strtolower($password), PASSWORD_DEFAULT);
    }
    $slug = url_title($this->request->getPost('nama_lengkap', FILTER_SANITIZE_STRING), '-', TRUE);
    $cookie = base64_encode($this->request->getPost('email', FILTER_SANITIZE_EMAIL));
    $data = [
      'id' => $id,
      'nama_lengkap' => $this->request->getPost('nama_lengkap', FILTER_SANITIZE_STRING),
      'slug' => $slug,
      'alamat' => $this->request->getPost('alamat', FILTER_SANITIZE_STRING),
      'foto' => 'default.jpg',
      'email' => $this->request->getPost('email', FILTER_SANITIZE_STRING),
      'password' => $password,
      'cookie' => hash('sha256', $cookie),
      'mapel_id' => $this->request->getPost('mapel_id', FILTER_VALIDATE_INT),
      'is_active' => ($this->request->getPost('is_active') != NULL) ? 1 : 0,
    ];
    $this->userModel->save($data);
    session()->setFlashdata('berhasil', 'Akun Berhasil Diubah!');
    $redirect = ($user['role_id'] == 2) ? '/aplikasi/data' : '/aplikasi/data/siswa';
    return redirect()->to($redirect);
  }
  /* <========================= HAPUS =========================> */
  public function hapus_data()
  {
    if ($this->request->isAJAX()) {
      $id = htmlspecialchars($this->request->getPost('id'));
      session()->setFlashdata('berhasil', 'Berhasil dihapus!');
      $this->db->table('user')->delete(['id' => $id]);
      $this->db->table('artikel')->delete(['user_id' => $id]);
      $this->db->table('komentar_tugas')->delete(['user_id' => $id]);
      $this->db->table('komentar_artikel')->delete(['user_id' => $id]);
      $this->db->table('absen')->delete(['user_id' => $id]);
      $this->db->table('tugas')->delete(['user_id' => $id]);
      $this->db->table('log_aktivitas')->delete(['user_id' => $id]);
      $this->db->table('notifikasi')->delete(['user_id' => $id]);
      $this->db->table('kategori_artikel')->delete(['user_id' => $id]);
      return true;
    } else {
      return redirect()->to('/auth/blocked');
    }
  }

  public function hapus_artikel()
  {
    if ($this->request->isAJAX()) {
      $id = htmlspecialchars($this->request->getPost('id'));
      session()->setFlashdata('berhasil', 'Artikel Berhasil dihapus!');
      $this->db->table('komentar_artikel')->delete(['artikel_id' => $id]);
      return $this->db->table('artikel')->delete(['id' => $id]);
    } else {
      return redirect()->to('/auth/blocked');
    }
  }
}
