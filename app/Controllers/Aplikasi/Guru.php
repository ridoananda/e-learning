<?php

namespace App\Controllers\Aplikasi;

use \CodeIgniter\I18n\Time;
use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;

class Guru extends BaseController
{
  public function index()
  {
    $data = [
      'title' => 'Halaman Utama',
      'user' => $this->userModel->getUser($this->id),
      'db' => \Config\Database::connect(),
    ];
    return view('aplikasi/guru/index', $data);
  }

  public function tugas()
  {
    $data = [
      'title' => 'Tugas Kelas',
      'user' => $this->userModel->getUser($this->id),
      'db' => \Config\Database::connect(),
      'validation' => \Config\Services::validation(),
      'mapel' => $this->db->table('user_mapel')->where(['user_role' => 3])->orderBy('jurusan', 'DESC')->get()->getResultArray(),
      'tugas' => $this->tugasModel->where('user_id', $this->id)->orderBy('id', 'DESC')->findAll(),
    ];
    return view('aplikasi/guru/tugas', $data);
  }

  public function ubah_tugas($id)
  {
    $data = [
      'title' => 'Tugas Kelas',
      'user' => $this->userModel->getUser($this->id),
      'db' => \Config\Database::connect(),
      'validation' => \Config\Services::validation(),
      'file_tugas' => $this->db->table('file_tugas')->where('tugas_id', $id)->get()->getResultArray(),
      'mapel' => $this->db->table('user_mapel')->where(['user_role' => 3])->orderBy('jurusan', 'DESC')->get()->getResultArray(),
      'tugas' => $this->tugasModel->where(['id' => $id, 'user_id' => $this->id])->orderBy('id', 'DESC')->first(),
    ];
    return view('aplikasi/guru/ubah-tugas', $data);
  }

  public function forum_tugas()
  {
    $data = [
      'title' => 'Forum Tugas',
      'user' => $this->userModel->getUser($this->id),
      'db' => \Config\Database::connect(),
    ];
    return view('aplikasi/guru/forum-tugas', $data);
  }

  public function detail_tugas($id)
  {
    $user = $this->userModel->getUser($this->id);
    $user_mapel = $this->db->table('user_mapel')->where('id', $user['mapel_id'])->get()->getRowArray();
    $tugas =  $this->tugasModel->where(['id' => $id, 'mapel' => $user_mapel['mapel']])->first();
    if (empty($tugas)) {
      throw new PageNotFoundException('Tugas tidak ditemukan');
    }
    $data = [
      'title' => 'Tugas - ' . $tugas['judul'],
      'user' => $this->userModel->getUser($this->id),
      'db' => \Config\Database::connect(),
      'tugas' => $tugas,
      'komentar' => $this->db->table('komentar_tugas'),
      'id' => $id,
      'file_tugas' => $this->db->table('file_tugas')->where('tugas_id', $id)->get()->getResultArray(),
      'user_tugas' => $this->userModel->getUser($tugas['user_id']),
      'validation' => \Config\Services::validation()
    ];
    return view('aplikasi/guru/detail-tugas', $data);
  }

  public function absen()
  {
    $absen = $this->db->table('absen')
      ->select('absen.*, user_mapel.kelas, user_mapel.jurusan')
      ->join('user_mapel', 'absen.mapel_id = user_mapel.id')
      ->where('absen.user_id', $this->id)
      ->orderBy('absen.id', 'DESC')
      ->get()
      ->getResultArray();
    $data = [
      'title' => 'Absen Kelas',
      'user' => $this->userModel->getUser($this->id),
      'db' => \Config\Database::connect(),
      'validation' => \Config\Services::validation(),
      'mapel' => $this->db->table('user_mapel')->where(['user_role' => 3])->orderBy('jurusan', 'DESC')->get()->getResultArray(),
      'absen' => $absen,
    ];
    return view('aplikasi/guru/absen', $data);
  }

  public function data_absen($id)
  {
    $data_absen = $this->db->table('data_absen')->where('absen_id', $id)->get()->getRowArray();
    $absen = $this->db->table('absen')
      ->select('absen.*, user_mapel.kelas, user_mapel.jurusan')
      ->join('user_mapel', 'absen.mapel_id = user_mapel.id')
      ->where('absen.id', $data_absen['absen_id'])
      ->get()
      ->getRowArray();
    if ($absen['user_id'] != NULL) {
      if ($absen['user_id'] != $this->id) {
        throw new PageNotFoundException('Data tidak ditemukan!');
      }
    }
    $data = [
      'title' => 'Absen Kelas',
      'user' => $this->userModel->getUser($this->id),
      'db' => \Config\Database::connect(),
      'validation' => \Config\Services::validation(),
      'mapel' => $this->db->table('user_mapel')->where(['user_role' => 3])->orderBy('jurusan', 'DESC')->get()->getResultArray(),
      'data_absen' => $data_absen,
      'absen' => $absen,
      'id' => $id
    ];
    return view('aplikasi/guru/data-absen', $data);
  }
  public function data_tugas($id)
  {
    $data_tugas = $this->db->table('data_tugas')->where('tugas_id', $id)->get()->getRowArray();
    $tugas = $this->db->table('tugas')
      ->select('tugas.*, user_mapel.kelas, user_mapel.jurusan')
      ->join('user_mapel', 'tugas.mapel_id = user_mapel.id')
      ->where('tugas.id', $data_tugas['tugas_id'])
      ->get()
      ->getRowArray();
    if ($tugas['user_id'] != NULL) {
      if ($tugas['user_id'] != $this->id) {
        throw new PageNotFoundException('Data tidak ditemukan!');
      }
    }
    $file_data_tugas = $this->db->table('file_tugas')
      ->select('file_tugas.*, tugas.id')
      ->join('tugas', 'tugas.id = ' . $id)
      ->where(['tugas.id' => $id, 'data_tugas_id' => $data_tugas['id']])
      ->get()->getResultArray();
    $data = [
      'title' => 'Tugas Kelas',
      'user' => $this->userModel->getUser($this->id),
      'db' => \Config\Database::connect(),
      'validation' => \Config\Services::validation(),
      'mapel' => $this->db->table('user_mapel')->where(['user_role' => 3])->orderBy('jurusan', 'DESC')->get()->getResultArray(),
      'file_tugas' => $this->db->table('file_tugas')->where('tugas_id', $id)->get()->getResultArray(),
      'file_data_tugas' => $file_data_tugas,
      'data_tugas' => $data_tugas,
      'tugas' => $tugas,
      'id' => $id
    ];
    return view('aplikasi/guru/data-tugas', $data);
  }

  public function data_tugas_siswa($user_id, $id)
  {
    $data_tugas = $this->db->table('data_tugas')->where(['tugas_id' => $id, 'user_id' => $user_id])->get()->getRowArray();
    $file_data_tugas = $this->db->table('file_tugas')->where(['data_tugas_id' => $data_tugas['id']])->get()->getResultArray();

    $data = [
      'title' => 'Tugas Kelas',
      'user' => $this->userModel->getUser($this->id),
      'db' => \Config\Database::connect(),
      'validation' => \Config\Services::validation(),
      'file_data_tugas' => $file_data_tugas,
      'data_tugas' => $data_tugas,
      'user_tugas' => $this->userModel->where(['id' => $data_tugas['user_id']])->first()
    ];
    return view('aplikasi/guru/data-tugas-siswa', $data);
  }

  public function notifikasi()
  {
    $data = [
      'title' => 'Notifikasi',
      'user' => $this->userModel->getUser($this->id),
      'db' => \Config\Database::connect(),
      'notifikasi' => $this->notifModel->where(['user_id' => $this->id])->orderBy('id', 'DESC')->paginate(10, 'notifikasi'),
      'pager' => $this->notifModel->pager
    ];
    return view('aplikasi/guru/notifikasi', $data);
  }

  public function artikel()
  {
    $data = [
      'title' => 'Artikel',
      'user' => $this->userModel->getUser($this->id),
      'db' => \Config\Database::connect(),
      'artikel' => $this->artikelModel->where(['user_id' => $this->id])->orderBy('id', 'DESC')->paginate(6, 'artikel'),
      'pager' => $this->artikelModel->pager
    ];
    return view('aplikasi/guru/artikel', $data);
  }

  public function buat_artikel()
  {
    $data = [
      'title' => 'Artikel',
      'user' => $this->userModel->getUser($this->id),
      'db' => \Config\Database::connect(),
      'kategori' => $this->db->table('kategori_artikel')->where(['user_id' => $this->id])->orderBy('id', 'DESC')->get()->getResultArray(),
      'validation' => \Config\Services::validation()
    ];
    return view('aplikasi/guru/buat-artikel', $data);
  }

  public function update_artikel($slug)
  {
    $data = [
      'title' => 'Artikel',
      'user' => $this->userModel->getUser($this->id),
      'db' => \Config\Database::connect(),
      'kategori' => $this->db->table('kategori_artikel')->where(['user_id' => $this->id])->orderBy('id', 'DESC')->get()->getResultArray(),
      'artikel' => $this->artikelModel->where(['slug' => $slug, 'user_id' => $this->id])->first(),
      'validation' => \Config\Services::validation()
    ];
    $data['row_kategori'] = $this->db->table('kategori_artikel')->where(['id' => $data['artikel']['kategori_id'], 'user_id' => $this->id])->get()->getRowArray();
    if (empty($data['artikel']) && $data['row_kategori']) {
      throw new PageNotFoundException('Artikel tidak ditemukan');
    }
    return view('aplikasi/guru/update-artikel', $data);
  }

  /* <========================= MENG-ABSEN =========================> */
  public function buat_absen()
  {
    if (!$this->validate([
      'mapel_id' => [
        'label' => 'Kelas',
        'rules' => 'required'
      ],
      'expired' => [
        'label' => 'Batas waktu',
        'rules' => 'required|integer'
      ],
    ])) {
      return redirect()->to('/aplikasi/guru/absen')->withInput();
    }
    $mapel_id = htmlspecialchars($this->request->getPost('mapel_id'));
    $expired = htmlspecialchars($this->request->getPost('expired'));
    $expired = round(time() + ($expired * 60));
    $user = $this->userModel->getUser($this->id);
    $absen = $this->db->table('absen')->where(['mapel_id' => $mapel_id, 'user_id' => $this->id])->orderBy('id', 'DESC')->get()->getRowArray();

    if (tanggal_lengkap($absen['created_at']) == time_lengkap(time())) {
      session()->setFlashdata('warning', 'Batas pengiriman absen pada kelas ini hanya sekali dalam sehari, tunggu besok ya.');
      return redirect()->to('/aplikasi/guru/absen');
    }
    $mapel =  $this->db->table('user_mapel')->where('id', $user['mapel_id'])->get()->getRowArray();
    $data = [
      'user_id' => $this->id,
      'mapel_id' => $mapel_id,
      'mapel' => htmlspecialchars($mapel['mapel']),
      'expired' => $expired,
    ];
    $this->absenModel->save($data);
    $absen = $this->db->table('absen')->where(['mapel_id' => $mapel_id, 'user_id' => $this->id])->orderBy('id', 'DESC')->get()->getRowArray();
    $user_absen = $this->userModel->where(['mapel_id' => $mapel_id])->findAll();
    foreach ($user_absen as $a) {
      sendEmail($a['email'], 'ABSEN ' . strtoupper($mapel['mapel']), 'Hallo ' . $a['nama_lengkap'] . '! mari absen pelajaran, <a href="' . base_url() . '/aplikasi/siswa/absen/' . $absen['id'] . '" target="_blank">Klik disini</a> untuk mengabsen!
      ');
      tambah_notif($a['id'], '/aplikasi/siswa/absen/' . $absen['id'], 'ABSEN ' . $mapel['mapel'] . '! jangan sampai ketinggalan ya.', 'fa-calendar-check');
    }
    session()->setFlashdata('berhasil', 'Absen berhasil terkirim! silahkan beri informasi kepada siswa kamu');
    return redirect()->to('/aplikasi/guru/absen');
  }


  /* <========================= TAMBAH =========================> */
  public function tambah_tugas()
  {
    if (!$this->validate([
      'judul' => [
        'label' => 'Judul tugas',
        'rules' => 'required'
      ],
      'kelas_jurusan' => [
        'label' => 'kelas dan jurusan',
        'rules' => 'required'
      ],
      'kategori' => 'required',
      'deskripsi' => 'required',
      'file' => 'max_size[file,20000]|mime_in[file,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/pdf,image/png,image/jpg,image/jpeg,video/mp4,video/3gpp,video/quicktime,video/MP2T,video/x-msvideo]|ext_in[file,png,jpg,jpeg,gif,pdf,docs,docx,doc,ppt,xlsx,pptx,xls,mp4,3gp,ts,avi,mov]',
    ])) {
      return redirect()->to('/aplikasi/guru/tugas')->withInput();
    }
    $judul = htmlspecialchars($this->request->getPost('judul'));
    $mapel_id = htmlspecialchars($this->request->getPost('kelas_jurusan'));
    $kategori = htmlspecialchars($this->request->getPost('kategori'));
    $deskripsi = htmlspecialchars($this->request->getPost('deskripsi'));
    $file = $this->request->getFiles('file');
    $user = $this->userModel->getUser($this->id);
    $mapel_guru = $this->db->table('user_mapel')->where('id', $user['mapel_id'])->get()->getRowArray();
    $mapel_siswa = $this->db->table('user_mapel')->where('id', $mapel_id)->get()->getRowArray();
    $ditugaskan = htmlspecialchars($this->request->getPost('ditugaskan'));
    $ditugaskan = ($ditugaskan == NULL) ? 0 : 1;

    $this->tugasModel->save([
      'user_id' => $this->id,
      'mapel_id' => $mapel_id,
      'mapel' => $mapel_guru['mapel'],
      'kelas' => $mapel_siswa['kelas'],
      'jurusan' => $mapel_siswa['jurusan'],
      'judul' => $judul,
      'kategori' => $kategori,
      'deskripsi' => $deskripsi,
      'ditugaskan' => $ditugaskan,
    ]);
    $tugas = $this->db->table('tugas')->where('user_id', $this->id)->orderBy('id', 'DESC')->get()->getRowArray();
    $user_tugas = $this->userModel->where(['mapel_id' => $mapel_id])->findAll();
    foreach ($user_tugas as $a) {
      sendEmail($a['email'], 'TUGAS ' . strtoupper($mapel_guru['mapel']), 'Hallo ' . $a['nama_lengkap'] . '! ' . $user['nama_lengkap'] . ' Telah mengupload tugas baru, <a href="' . base_url() . '/aplikasi/siswa/detail-tugas/' . $tugas['id'] . '" target="_blank">Klik disini</a> untuk melihat tugas!
      ');
      tambah_notif($a['id'], '/aplikasi/siswa/detail-tugas/' . $tugas['id'], 'TUGAS ' . $mapel_guru['mapel'] . '! Ayo lihat dan kerjakan sekarang!', 'fa-clipboard-list');
    }
    if ($file) {
      foreach ($file['file'] as $f) {
        if (!$f->getError() == 4) {
          $this->db->table('file_tugas')->insert([
            'tugas_id' => $tugas['id'],
            'name' => $f->getName(),
            'ext' => $f->getExtension(),
          ]);
          $f->move('file/tugas', $f->getName());
        }
      }
    }
    session()->setFlashdata('berhasil', 'Tugas berhasil terkirim! silahkan beri informasi kepada siswa kamu');
    return redirect()->to('/aplikasi/guru/tugas');
  }

  public function tambah_komentar()
  {
    $id = htmlspecialchars($this->request->getPost('id'));
    if (!$this->validate([
      'komentar' => 'required'
    ])) {
      return redirect()->to('/aplikasi/guru/detail-tugas/' . $id)->withInput();
    }
    $komentar = htmlspecialchars($this->request->getPost('komentar'));
    $guru = $this->userModel->getUser($this->id);
    $this->komentarTugas->save([
      'tugas_id' => $id,
      'user_id' => $this->id,
      'komentar' => $komentar
    ]);
    $komentars = $this->db->table('komentar_tugas')->select('user_id')->where(['tugas_id' => $id])->distinct()->get()->getResultArray();
    foreach ($komentars as $k) {
      if ($k['user_id'] != $guru['id']) {
        tambah_notif($k['user_id'], '/aplikasi/siswa/detail-tugas/' .  $id, '' . $guru['nama_lengkap'] . ' mengomentari tugas nya.', 'fa-comments');
      }
    }
    session()->setFlashdata('berhasil', 'Komentar berhasil ditambahkan.');
    return redirect()->to('/aplikasi/guru/detail-tugas/' . $id);
  }

  public function tambah_kategori()
  {
    if ($this->request->isAjax()) {
      if (!$this->validate([
        'kategori' => [
          'label' => 'Nama Kategori',
          'rules' => 'required|is_unique[kategori_artikel.kategori]'
        ],
      ])) {
        return redirect()->withInput();
      }
      $kategori = htmlspecialchars($this->request->getPost('kategori'));
      $data = [
        'user_id' => $this->id,
        'kategori' => $kategori
      ];
      session()->setFlashdata('berhasil', 'Kategori Berhasil ditambahkan!');
      $this->db->table('kategori_artikel')->insert($data);
      return 'oke';
    } else {
      return redirect()->to('/auth/blocked');
    }
  }

  public function tambah_artikel()
  {
    if (!$this->validate([
      'judul' => [
        'label' => 'Judul artikel',
        'rules' => 'required'
      ],
      'kategori_id' => [
        'label' => 'Kategori',
        'rules' => 'required'
      ],
      'text' => 'required',
      'thumbnail' => 'max_size[thumbnail,3000]|is_image[thumbnail]|mime_in[thumbnail,image/png,image/jpg,image/jpeg]|ext_in[thumbnail,png,jpg,jpeg]'
    ])) {
      return redirect()->to('/aplikasi/guru/buat-artikel')->withInput();
    }

    $judul = htmlspecialchars($this->request->getPost('judul'));
    $kategori_id = htmlspecialchars($this->request->getPost('kategori_id'));
    $text = $this->request->getPost('text');
    $thumbnail = $this->request->getFile('thumbnail');
    $aktif = htmlspecialchars($this->request->getPost('aktif'));
    $aktif = ($aktif == NULL) ? 0 : 1;

    if ($thumbnail->getError() == 4) {
      $name = 'default.jpg';
    } else {
      $name = $thumbnail->getRandomName();
      $thumbnail->move('template/img/thumbnail/', $name);
      // \Config\Services::image()
      //   ->withFile('template/img/thumbnail/' . $name)
      //   ->fit(300, 300, 'center')
      //   ->save('template/img/thumbnail/' . $name);
    }

    $this->artikelModel->save([
      'user_id' => $this->id,
      'kategori_id' => $kategori_id,
      'judul' => $judul,
      'slug' => url_title($judul, '-', true),
      'thumbnail' => $name,
      'text' => $text,
      'aktif' => $aktif,
    ]);
    session()->setFlashdata('berhasil', 'Artikel berhasil ditambahkan.');
    return redirect()->to('/aplikasi/guru/artikel');
  }

  public function upload_image_artikel()
  {
    $gambar = $this->request->getFile('image');
    if ($gambar) {
      $image = \Config\Services::image();
      if (!$this->validate([
        'image' => 'max_size[image,3000]|is_image[image]|mime_in[image,image/png,image/jpg,image/jpeg]|ext_in[image,png,jpg,jpeg]'
      ])) {
        $validaton = \Config\Services::validation();
        $data = [
          'error' => $validaton->getError('image')
        ];
        return json_encode($data);
      }
      $name = $gambar->getRandomName();
      $gambar->move('template/img/artikel/', $name);
      return json_encode('/template/img/artikel/' . $name);
    }
  }

  /* <========================= UBAH =========================> */
  public function ubah_absen()
  {
    if ($this->request->isAjax()) {
      if (!$this->validate([
        'expired' => [
          'label' => 'Batas waktu',
          'rules' => 'required|integer'
        ],
      ])) {
        return redirect()->withInput();
      }
      $id = htmlspecialchars($this->request->getPost('id'));
      $expired = htmlspecialchars($this->request->getPost('expired'));
      $expired = round(time() + ($expired * 60));
      session()->setFlashdata('berhasil', 'Absen Berhasil diubah!');
      return $this->db->table('absen')->update(['expired' => $expired], ['id' => $id]);
    } else {
      return redirect()->to('/auth/blocked');
    }
  }

  public function act_ubah_tugas($id)
  {
    if (!$this->validate([
      'judul' => [
        'label' => 'Judul tugas',
        'rules' => 'required'
      ],
      'kelas_jurusan' => [
        'label' => 'kelas dan jurusan',
        'rules' => 'required'
      ],
      'kategori' => 'required',
      'deskripsi' => 'required',
      'file' => 'max_size[file,20000]|mime_in[file,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/pdf,image/png,image/jpg,image/jpeg,video/mp4,video/3gpp,video/quicktime,video/MP2T,video/x-msvideo]|ext_in[file,png,jpg,jpeg,gif,pdf,docs,docx,doc,ppt,xlsx,pptx,xls,mp4,3gp,ts,avi,mov]',
    ])) {
      return redirect()->to('/aplikasi/guru/ubah-tugas/' . $id)->withInput();
    }
    $judul = htmlspecialchars($this->request->getPost('judul'));
    $mapel_id = htmlspecialchars($this->request->getPost('kelas_jurusan'));
    $kategori = htmlspecialchars($this->request->getPost('kategori'));
    $deskripsi = htmlspecialchars($this->request->getPost('deskripsi'));
    $file = $this->request->getFiles('file');
    $file_lama = $this->request->getPost('file_lama');
    $user = $this->userModel->getUser($this->id);
    $mapel_guru = $this->db->table('user_mapel')->where('id', $user['mapel_id'])->get()->getRowArray();
    $mapel_siswa = $this->db->table('user_mapel')->where('id', $mapel_id)->get()->getRowArray();
    $ditugaskan = htmlspecialchars($this->request->getPost('ditugaskan'));
    $ditugaskan = ($ditugaskan == NULL) ? 0 : 1;

    $this->tugasModel->save([
      'id' => $id,
      'user_id' => $this->id,
      'mapel_id' => $mapel_id,
      'mapel' => $mapel_guru['mapel'],
      'kelas' => $mapel_siswa['kelas'],
      'jurusan' => $mapel_siswa['jurusan'],
      'judul' => $judul,
      'kategori' => $kategori,
      'deskripsi' => $deskripsi,
      'ditugaskan' => $ditugaskan,
    ]);
    $tugas = $this->db->table('tugas')->where(['id' => $id, 'user_id' => $this->id])->orderBy('id', 'DESC')->get()->getRowArray();
    if ($file_lama) {
      foreach ($file_lama as $fl) {
        $this->db->table('file_tugas')->update([
          'name' => $fl,
        ], ['tugas_id' => $tugas['id']]);
      }
    }
    if ($file) {
      if ($file_lama) {
        foreach ($file['file'] as $f) {
          if (!$f->getError() == 4) {
            $this->db->table('file_tugas')->update([
              'name' => $f->getName(),
              'ext' => $f->getExtension(),
            ], ['tugas_id' => $tugas['id']]);
            $f->move('file/tugas', $f->getName());
          }
        }
      } else {
        foreach ($file['file'] as $f) {
          if (!$f->getError() == 4) {
            $this->db->table('file_tugas')->insert([
              'tugas_id' => $tugas['id'],
              'name' => $f->getName(),
              'ext' => $f->getExtension(),
            ]);
            $f->move('file/tugas', $f->getName());
          }
        }
      }
    }
    session()->setFlashdata('berhasil', 'Tugas berhasil diubah!');
    return redirect()->to('/aplikasi/guru/tugas');
  }

  public function ubah_artikel($id)
  {
    if (!$this->validate([
      'judul' => [
        'label' => 'Judul artikel',
        'rules' => 'required'
      ],
      'kategori_id' => [
        'label' => 'Kategori',
        'rules' => 'required'
      ],
      'text' => 'required',
      'thumbnail' => 'max_size[thumbnail,3000]|is_image[thumbnail]|mime_in[thumbnail,image/png,image/jpg,image/jpeg]|ext_in[thumbnail,png,jpg,jpeg]'
    ])) {
      return redirect()->to('/aplikasi/guru/update-artikel/' . $id)->withInput();
    }

    $judul = htmlspecialchars($this->request->getPost('judul'));
    if ($judul) {
      $slug = url_title($judul, '-', true);
    } else {
      $slug = $slug_lama = htmlspecialchars($this->request->getPost('slug_lama'));
    }
    $kategori_id = htmlspecialchars($this->request->getPost('kategori_id'));
    $text = $this->request->getPost('text');
    $thumbnail = $this->request->getFile('thumbnail');
    $thumbnail_lama = $this->request->getPost('thumbnail_lama');
    $aktif = htmlspecialchars($this->request->getPost('aktif'));
    $aktif = ($aktif == NULL) ? 0 : 1;

    if ($thumbnail->getError() == 4) {
      $name = $thumbnail_lama;
    } else {
      if ($thumbnail_lama != 'default.jpg') {
        unlink('template/img/thumbnail/' . $thumbnail_lama);
        $name = $thumbnail->getRandomName();
        $thumbnail->move('template/img/thumbnail/', $name);
      } else {
        $name = $thumbnail->getRandomName();
        $thumbnail->move('template/img/thumbnail', $name);
      }
    }

    $this->artikelModel->save([
      'id' => $id,
      'user_id' => $this->id,
      'kategori_id' => $kategori_id,
      'judul' => $judul,
      'slug' => $slug,
      'thumbnail' => $name,
      'text' => $text,
      'aktif' => $aktif,
    ]);
    session()->setFlashdata('berhasil', 'Artikel berhasil diubah.');
    return redirect()->to('/aplikasi/guru/artikel');
  }

  /* <========================= HAPUS =========================> */
  public function hapus_absen()
  {
    if ($this->request->isAjax()) {
      $id = htmlspecialchars($this->request->getPost('id'));
      $this->db->table('absen')->delete(['id' => $id]);
      session()->setFlashdata('berhasil', 'Absen Berhasil dihapus!');
      return $this->db->table('data_absen')->delete(['absen_id' => $id]);
    } else {
      return redirect()->to('/auth/blocked');
    }
  }
  public function hapus_tugas()
  {
    if ($this->request->isAjax()) {
      $id = htmlspecialchars($this->request->getPost('id'));
      $file_tugas = $this->db->table('file_tugas')->where(['tugas_id' => $id])->get()->getResultArray();
      $data_tugas = $this->db->table('data_tugas')->where(['tugas_id' => $id])->get()->getResultArray();
      if ($data_tugas) {
        foreach ($data_tugas as $dt) {
          $file_data_tugas = $this->db->table('file_tugas')->where(['data_tugas_id' => $dt['id']])->get()->getResultArray();
          if ($file_data_tugas) {
            foreach ($file_data_tugas as $fdt) {
              unlink('file/tugas/' . $fdt['name']);
            }
          }
        }
      }
      if ($file_tugas) {
        foreach ($file_tugas as $ft) {
          unlink('file/tugas/' . $ft['name']);
        }
      }
      $this->db->table('tugas')->delete(['id' => $id]);
      $this->db->table('file_tugas')->delete(['tugas_id' => $id]);
      $this->db->table('komentar_tugas')->delete(['tugas_id' => $id]);
      session()->setFlashdata('berhasil', 'Tugas Berhasil dihapus!');
      return $this->db->table('data_tugas')->delete(['tugas_id' => $id]);
    } else {
      return redirect()->to('/auth/blocked');
    }
  }
  public function hapus_notifikasi()
  {
    if ($this->request->isAJAX()) {
      $id = htmlspecialchars($this->request->getPost('id'));
      session()->setFlashdata('berhasil', 'Notifikasi berhasil dihapus!');
      return $this->notifModel->where(['user_id' => $this->id])->delete();
    } else {
      return redirect()->to('/auth/blocked');
    }
  }
  public function hapus_artikel()
  {
    if ($this->request->isAJAX()) {
      $id = htmlspecialchars($this->request->getPost('id'));
      session()->setFlashdata('berhasil', 'Artikel berhasil dihapus!');
      return $this->artikelModel->where(['id' => $id, 'user_id' => $this->id])->delete();
    } else {
      return redirect()->to('/auth/blocked');
    }
  }

  public function delete_image_artikel()
  {
    $src = $this->request->getPost('src');
    $file_name = str_replace(base_url() . '/', '', $src);
    unlink($file_name);
  }


  public function download($name = FALSE)
  {
    if ($name == FALSE) {
      return redirect()->to('/auth/blocked');
    } else {
      return $this->response->download('/file/tugas/', $name, true)->setFileName('File Tugas belajar online - ' . $name);
    }
  }

  public function cek_notif()
  {
    if ($this->request->isAJAX()) {
      $id = htmlspecialchars($this->request->getPost('id'));
      return $this->notifModel->save([
        'id' => $id,
        'is_cek' => 1,
      ]);
    } else {
      return redirect()->to('/auth/blocked');
    }
  }
}
