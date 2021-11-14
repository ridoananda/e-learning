<?php

namespace App\Controllers\Aplikasi;

use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;

class Siswa extends BaseController
{
	public function index()
	{
		$data = [
			'title' => 'Halaman Utama',
			'user' => $this->userModel->getUser($this->id),
			'db' => \Config\Database::connect(),
		];
		return view('aplikasi/siswa/index', $data);
	}

	public function tugas($id)
	{
		$user = $this->userModel->getUser($this->id);
		$user_mapel = $this->db->table('user_mapel')->where('id', $user['mapel_id'])->get()->getRowArray();
		$data = [
			'title' => 'Forum Tugas',
			'user' => $user,
			'tugas' => $this->tugasModel->where(['user_id' => $id, 'kelas' => $user_mapel['kelas'], 'jurusan' => $user_mapel['jurusan']])->orderBy('id', 'DESC')->findAll(),
			'komentar' => $this->db->table('komentar_tugas'),
			'db' => \Config\Database::connect(),
		];
		if (empty($data['tugas'])) {
			throw new PageNotFoundException('Data tidak ditemukan!');
		}
		return view('aplikasi/siswa/tugas', $data);
	}

	public function forum_tugas()
	{
		$user = $this->userModel->getUser($this->id);
		$data = [
			'title' => 'Forum Tugas',
			'user' => $user,
			'db' => \Config\Database::connect(),
			'tugas' => $this->db->table('tugas')->select('mapel, user_id')->where('mapel_id', $user['mapel_id'])->distinct()->get()->getResultArray()
		];
		return view('aplikasi/siswa/forum-tugas', $data);
	}

	public function detail_tugas($id)
	{
		$user = $this->userModel->getUser($this->id);
		$user_mapel = $this->db->table('user_mapel')->where('id', $user['mapel_id'])->get()->getRowArray();
		$tugas =  $this->tugasModel->where(['id' => $id, 'kelas' => $user_mapel['kelas'], 'jurusan' => $user_mapel['jurusan']])->first();
		// CEK KALAU TUGAS TIDAK SESUAI DENGAN KELAS DAN JURUSAN USER
		if (empty($tugas)) {
			throw new PageNotFoundException('Tugas tidak ditemukan');
		}
		$data_tugas = $this->db->table('data_tugas')->where(['tugas_id' => $id, 'user_id' => $user['id']])->get()->getRowArray();
		$file_data_tugas = $this->db->table('file_tugas')
			->select('file_tugas.*, tugas.id')
			->join('tugas', 'tugas.id = ' . $id)
			->where(['tugas.id' => $id, 'data_tugas_id' => $data_tugas['id']])
			->get()->getResultArray();

		$data = [
			'title' => 'Forum Tugas',
			'user' => $this->userModel->getUser($this->id),
			'db' => \Config\Database::connect(),
			'tugas' => $tugas,
			'file_tugas' => $this->db->table('file_tugas')->where('tugas_id', $id)->get()->getResultArray(),
			'file_data_tugas' => $file_data_tugas,
			'data_tugas' => $data_tugas,
			'komentar' => $this->db->table('komentar_tugas'),
			'id' => $id,
			'user_tugas' => $this->userModel->getUser($tugas['user_id']),
			'validation' => \Config\Services::validation()
		];
		return view('aplikasi/siswa/detail-tugas', $data);
	}

	public function absen($id = false)
	{
		if ($id == false) {
			$data = [
				'title' => 'Absen Kelas',
				'user' => $this->userModel->getUser($this->id),
				'db' => \Config\Database::connect(),
				'validation' => \Config\Services::validation(),
				'data_absen' => $this->db->table('data_absen')->where('user_id', $this->id)->orderBy('id', 'DESC')->get()->getResultArray()
			];
			return view('aplikasi/siswa/absen', $data);
		} else {

			$user = $this->userModel->getUser($this->id);
			$data = [
				'title' => 'Absen Kelas',
				'user' => $this->userModel->getUser($this->id),
				'db' => \Config\Database::connect(),
				'validation' => \Config\Services::validation(),
				'absen' => $this->db->table('absen')->where(['id' => $id], ['mapel_id' => $user['mapel_id']])->get()->getRowArray(),
			];
			$data['data_absen'] = $this->db->table('data_absen')->where(['user_id' => $this->id, 'absen_id' => $id, 'is_absen' => 1])->get()->getRowArray();
			return view('aplikasi/siswa/detail-absen', $data);
		}
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
		return view('aplikasi/siswa/notifikasi', $data);
	}


	/* <========================= ABSEN =========================> */
	public function mengabsen()
	{
		$keterangan = htmlspecialchars($this->request->getPost('keterangan'));
		if ($keterangan == false || $keterangan == 'hadir') {
			if (!$this->validate([
				'keterangan' => 'required',
			])) {
				return redirect()->to('/aplikasi/siswa/absen')->withInput();
			}
		} else {
			if (!$this->validate([
				'keterangan' => 'required',
				'alasan' => 'required'
			])) {
				return redirect()->to('/aplikasi/siswa/absen')->withInput();
			}
		}

		$absen_id = $this->request->getPost('absen_id');
		$absen = $this->absenModel->where(['id' => $absen_id])->first();
		if (time() >= $absen['expired']) {
			session()->setFlashdata('warning', 'Batas waktu absen sudah berakhir!');
			return redirect()->to('/aplikasi/siswa/absen');
		}

		$user_absen = $this->db->table('absen')->select('user_id')->where(['id' => $absen_id])->get()->getRowArray();
		$guru = $this->userModel->where(['id' => $user_absen['user_id']])->first();
		$siswa = $this->userModel->where(['id' => $this->id])->first();
		$mapel = htmlspecialchars($this->request->getPost('mapel'));
		if ($keterangan == 'hadir') {
			$data = [
				'absen_id' => $absen_id,
				'user_id' => $this->id,
				'mapel' => $mapel,
				'keterangan' => $keterangan,
				'alasan' => '-',
				'is_absen' => 1,
			];
			$this->dataAbsenModel->save($data);
			tambah_notif($guru['id'], '/aplikasi/guru/data-absen/' .  $absen_id, '' . $siswa['nama_lengkap'] . ' telah mengabsen', 'fa-calendar-check');
			session()->setFlashdata('berhasil', 'Kamu berhasil absen pelajaran ' . $mapel);
			return redirect()->to('/aplikasi/siswa/absen');
		}
		$absen_id = $this->request->getPost('absen_id');
		$user_absen = $this->db->table('absen')->select('user_id')->where(['id' => $absen_id])->get()->getRowArray();
		$guru = $this->userModel->where(['id' => $user_absen['user_id']])->first();
		$siswa = $this->userModel->where(['id' => $this->id])->first();
		if ($keterangan == 'sakit' || $keterangan == 'izin') {
			$data = [
				'absen_id' => $this->request->getPost('absen_id'),
				'user_id' => $this->id,
				'mapel' => $mapel,
				'keterangan' => $keterangan,
				'alasan' => htmlspecialchars($this->request->getPost('alasan')),
				'is_absen' => 1,
			];
			$this->dataAbsenModel->save($data);
			tambah_notif($guru['id'], '/aplikasi/guru/data-absen/' .  $absen_id, '' . $siswa['nama_lengkap'] . ' telah mengabsen', 'fa-calendar-check');
			session()->setFlashdata('berhasil', 'Kamu berhasil absen pelajaran ' . $mapel);
			return redirect()->to('/aplikasi/siswa/absen');
		}
	}

	/* <========================= TAMBAH =========================> */

	public function tambah_komentar()
	{
		$tugas_id = htmlspecialchars($this->request->getPost('id'));
		if (!$this->validate([
			'komentar' => 'required'
		])) {
			return redirect()->to('/aplikasi/siswa/detail-tugas/' . $tugas_id)->withInput();
		}
		$komentar = htmlspecialchars($this->request->getPost('komentar'));
		$tugas = $this->db->table('tugas')->select('user_id')->where(['id' => $tugas_id])->get()->getRowArray();
		$guru = $this->userModel->where(['id' => $tugas['user_id']])->first();
		$siswa = $this->userModel->where(['id' => $this->id])->first();
		$this->komentarTugas->save([
			'tugas_id' => $tugas_id,
			'user_id' => $this->id,
			'komentar' => $komentar
		]);

		tambah_notif($guru['id'], '/aplikasi/guru/detail-tugas/' .  $tugas_id, '' . $siswa['nama_lengkap'] . ' mengomentari tugas kamu.', 'fa-comments');
		$komentars = $this->db->table('komentar_tugas')->select('user_id')->where(['tugas_id' => $tugas_id])->distinct()->get()->getResultArray();
		foreach ($komentars as $k) {
			if ($k['user_id'] != $siswa['id'] && $k['user_id'] != $tugas['user_id']) {
				tambah_notif($k['user_id'], '/aplikasi/siswa/detail-tugas/' .  $tugas_id, '' . $siswa['nama_lengkap'] . ' mengomentari tugas ' . $guru['nama_lengkap'] . '.', 'fa-comments');
			}
		}
		session()->setFlashdata('berhasil', 'Komentar berhasil ditambahkan.');
		return redirect()->to('/aplikasi/siswa/detail-tugas/' . $tugas_id);
	}

	public function serah_tugas()
	{
		$id = htmlspecialchars($this->request->getPost('id'));
		$deskripsi = htmlspecialchars($this->request->getPost('deskripsi'));
		$file = $this->request->getFiles('file');

		if (!$this->validate([
			'file' => 'uploaded[file]|max_size[file,20000]|mime_in[file,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/pdf,image/png,image/jpg,image/jpeg,video/mp4,video/3gpp,video/quicktime,video/MP2T,video/x-msvideo]|ext_in[file,png,jpg,jpeg,gif,pdf,docs,docx,doc,ppt,xlsx,pptx,xls,mp4,3gp,ts,avi,mov]',
		])) {
			return redirect()->to('/aplikasi/siswa/detail-tugas/' . $id)->withInput();
		}

		$this->dataTugasModel->save([
			'tugas_id' => $id,
			'user_id' => $this->id,
			'deskripsi' => $deskripsi,
			'is_kumpul' => 1
		]);
		$data_tugas = $this->dataTugasModel->where('user_id', $this->id)->orderBy('id', 'DESC')->first();
		$tugas = $this->tugasModel->where(['id' => $id])->first();
		$guru = $this->userModel->where(['id' => $tugas['user_id']])->first();
		$siswa = $this->userModel->getUser($this->id);
		if ($file) {
			foreach ($file['file'] as $f) {
				if (!$f->getError() == 4) {
					$this->db->table('file_tugas')->insert([
						'data_tugas_id' => $data_tugas['id'],
						'name' => $f->getName(),
						'ext' => $f->getExtension(),
					]);
					$f->move('file/tugas', $f->getName());
				}
			}
		}
		tambah_notif($guru['id'], '/aplikasi/guru/data-tugas-siswa/' . $siswa['id'] . '/' . $id, '' . $siswa['nama_lengkap'] . ' mengumpulkan tugas pelajaran! cek disini sekarang.', 'fa-clipboard-list');
		session()->setFlashdata('berhasil', 'Tugas berhasil diserahkan!');
		return redirect()->to('/aplikasi/siswa/detail-tugas/' . $id);
	}

	/* <========================= HAPUS =========================> */
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
