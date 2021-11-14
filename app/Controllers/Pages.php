<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

class Pages extends BaseController
{
  public function index()
  {
    $data = [
      'title' => 'Yapim Taruna Marelan',
      'artikel' => $this->db->table('artikel')->where(['aktif' => 1])->orderBy('id', 'DESC')->limit(3)->get()->getResult(),
      'db' => \Config\Database::connect(),
      'validation' => \Config\Services::validation(),
    ];
    return view('pages/index', $data);
  }
  public function artikel()
  {
    $keyword = htmlspecialchars($this->request->getPost('keyword'));
    if ($keyword) {
      $artikel = $this->artikelModel->cari_artikel($keyword);
    } else {
      $artikel = $this->artikelModel->where(['aktif' => 1])->orderBy('id', 'DESC');
    }
    $data = [
      'title' => 'Artikel - Yapim Taruna Marelan',
      'artikel' => $artikel->paginate(6, 'artikel'),
      'pager' => $this->artikelModel->pager,
      'db' => \Config\Database::connect()
    ];
    return view('pages/artikel', $data);
  }

  public function detail_artikel($slug)
  {
    $artikel = $this->db->table('artikel')->where(['slug' => $slug])->get()->getRow();
    $data = [
      'title' => 'Artikel - Yapim Taruna Marelan',
      'artikel' => $artikel,
      'user_upload' => $this->db->table('user')->where(['id' => $artikel->user_id])->get()->getRow(),
      'kategori' => $this->db->table('kategori_artikel')->where(['id' => $artikel->kategori_id])->get()->getRow(),
      'komentar' => $this->db->table('komentar_artikel')->where(['artikel_id' => $artikel->id])->countAllResults(),
      'pager' => $this->artikelModel->pager,
      'validation' => \Config\Services::validation(),
      'db' => \Config\Database::connect()
    ];
    return view('pages/detail-artikel', $data);
  }

  public function users($email)
  {
    $user = $this->userModel->where(['email' => $email])->first();
    $data = [
      'title' => $user['nama_lengkap'] . ' - Yapim Taruna Marelan',
      'user' => $user,
      'validation' => \Config\Services::validation(),
      'mapel' => $this->db->table('user_mapel')->where(['id' => $user['mapel_id']])->get()->getRowArray()
    ];
    return view('pages/detail-users', $data);
  }


  // TAMBAH KOMENTAR
  public function add_komentar()
  {
    if (session()->has('e')) {
      $slug = htmlspecialchars($this->request->getPost('slug'));
      if (!$this->validate([
        'text' => 'required',
        'slug' => 'required',
      ])) {
        return redirect()->to('/artikel/' . $slug)->withInput();
      }
      $text = htmlspecialchars($this->request->getPost('text'));
      $artikel = $this->artikelModel->where(['slug' => $slug])->first();
      $user_komen = $this->userModel->getUser($this->id);
      if (empty($artikel)) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel tidak Ditemukan!');
        return redirect()->to('/artikel/' . $slug);
      }
      $id = $artikel['id'];
      $this->komentarArtikel->save([
        'artikel_id' => $id,
        'user_id' => $this->id,
        'text' => $text
      ]);
      $guru = $this->userModel->where(['id' => $artikel['user_id']])->first();
      if ($guru['id'] != $this->id) {
        tambah_notif($guru['id'], '/artikel/' .  $slug, '' . $user_komen['nama_lengkap'] . ' mengomentari artikel kamu.', 'fa-comments');
      }
      session()->setFlashdata('berhasil', 'Komentar Berhasil Ditambahkan!');
      return redirect()->to('/artikel/' . $slug);
    }
  }

  public function laporan()
  {
    if (session()->has('e')) {
      $email = htmlspecialchars($this->request->getPost('email'));
      $alasan = htmlspecialchars($this->request->getPost('alasan'));
      $alasan1 = (htmlspecialchars($this->request->getPost('alasan1')) == null) ? '' : 'Berperilaku buruk, ';
      $alasan2 = (htmlspecialchars($this->request->getPost('alasan2')) == null) ? '' : 'Menyalahgunakan Akun, ';
      $alasan3 = (htmlspecialchars($this->request->getPost('alasan3')) == null) ? '' : 'Berkata tidak sopan, ';
      if (
        $alasan == null &&
        $alasan1 == null &&
        $alasan2 == null &&
        $alasan3 == null
      ) {
        if (!$this->validate([
          'alasan' => 'required|max_length[1000]'
        ])) {
          return redirect()->to('/users/' . $email)->withInput();
        }
      }
      $user_id = htmlspecialchars($this->request->getPost('user_id'));
      $user_lapor_id = htmlspecialchars($this->request->getPost('user_lapor_id'));
      $user_lapor = $this->userModel->where(['id' => $user_lapor_id])->first();
      $admin = $this->userModel->where(['role_id' => 1])->first();
      $alasan = $alasan1 . '' . $alasan2 . '' . $alasan3 . '' . $alasan;
      $this->db->table('laporan')->insert([
        'user_id' => $user_id,
        'user_lapor_id' => $user_lapor_id,
        'alasan' => $alasan,
        'created_at' => time(),
      ]);
      tambah_notif($admin['id'], '/aplikasi/admin/laporan', $user_lapor['nama_lengkap'] . ' Melaporkan Sesuatu, Cek Sekarang!!!', 'fa-exclamation');
      session()->setFlashdata('berhasil', 'Laporan berhasil dikirim, terima kasih sudah melapor');
      return redirect()->to('/users/' . $email);
    } else {
      return redirect()->to('/auth/blocked');
    }
  }

  public function hubungi()
  {
    $nama_lengkap = htmlspecialchars($this->request->getPost('nama_lengkap'));
    $email = htmlspecialchars($this->request->getPost('email'));
    $pesan = htmlspecialchars($this->request->getPost('pesan'));
    if (!$this->validate([
      'nama_lengkap' => [
        'label' => 'Nama lengkap',
        'rules' => 'required'
      ],
      'email' => 'required|valid_email',
      'pesan' => 'required|max_length[1000]',
    ])) {
      session()->setFlashdata('gagal', 'gagal');
      return redirect()->to('/#hubungi')->withInput();
    }

    $admin = $this->userModel->where(['role_id' => 1])->first();
    $this->db->table('hubungi')->insert([
      'nama_lengkap' => $nama_lengkap,
      'email' => $email,
      'pesan' => $pesan,
      'ip_address' => htmlspecialchars($this->request->getIPAddress()),
      'user_agent' => htmlspecialchars($this->request->getUserAgent()->getAgentString()),
      'created_at' => time(),
    ]);
    tambah_notif($admin['id'], '/aplikasi/admin/hubungi', $nama_lengkap . ' Mengirim pesan kepada kamu', 'fas fa-phone');
    session()->setFlashdata('berhasil', 'Terima kasih telah menghubungi, kami akan segera merespon');
    return redirect()->to('/');
  }
}
