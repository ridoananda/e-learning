<?php

namespace App\Controllers;

class Auth extends BaseController
{

	public function index()
	{
		if (session()->get('role_id') == 1) {
			return redirect()->to('/aplikasi/admin');
		} else if (session()->get('role_id') == 2) {
			return redirect()->to('/aplikasi/guru');
		} else {
			return redirect()->to('/aplikasi/siswa');
		}
		return redirect()->to('/masuk');
	}

	public function masuk()
	{
		// cek apakah ada session
		if (session()->has('id') && session()->has('e')) {
			return redirect()->to('/auth');
		} else {
			// cek apakah ada cookie, kalau ada tambah session
			if (get_cookie('e') && get_cookie('ui')) {
				$userModel = new \App\Models\UserModel();
				$logModel = new \App\Models\LogModel();
				$user = $userModel->where(['id' => get_cookie('ui')])->first();
				if (!$user) {
					delete_cookie('e');
					delete_cookie('ui');
					session()->destroy();
					return redirect()->to('/masuk')->withCookies();
				}
				// cek kalau cookie email nya gak sama
				if (get_cookie('e') != $user['cookie']) {
					session()->setFlashdata('pesan', 'COOKIE Tidak Benar!');
					return redirect()->to('/masuk');
				} else {
					$request = \Config\Services::request();
					// ambil data user berdasarkan user_id
					$data = [
						'id' => $user['id'],
						'e' => $user['email'],
						'role_id' => $user['role_id']
					];
					session()->set($data);
					$log = [
						'user_id' => $user['id'],
						'ip_address' => htmlspecialchars($request->getIPAddress()),
						'user_agent' => htmlspecialchars($request->getUserAgent()->getAgentString()),
					];
					$logModel->addUserLog($log);
					if ($user['role_id'] == 1) {
						return redirect()->to('/aplikasi/admin');
					} else if ($user['role_id'] == 2) {
						return redirect()->to('/aplikasi/guru');
					} else {
						return redirect()->to('/aplikasi/siswa');
					}
				}
			}
		}
		$data = [
			'validation' => \Config\Services::Validation()
		];

		return view('aplikasi/auth/login', $data);
	}
	public function daftar()
	{
		$data = [
			'validation' => \Config\Services::Validation(),
			'mapel' => $this->db->table('user_mapel')->where('user_role', 3)->get()->getResultArray()
		];
		return view('aplikasi/auth/daftar', $data);
	}

	// Validasi Login
	public function validasi()
	{

		if (!$this->validate([
			'email' => 'required|valid_email',
			'password' => 'required|min_length[6]'
		])) {
			return redirect()->to('/masuk')->withInput();
		} else {
			return $this->_cekLogin();
		}
	}

	// Cek login
	private function _cekLogin()
	{
		$email = $this->request->getPost('email');
		$password = $this->request->getPost('password');
		$ingat = $this->request->getPost('ingat');
		$user = $this->userModel->where(['email' => $email])->first();

		// Kalau Ada user
		if ($user) {

			// kalau password nya benar
			if (password_verify($password, $user['password'])) {
				//kalau user nya aktif
				if ($user['is_active'] == 1) {
					// kalau klik ingat saya
					if ($ingat == TRUE) {
						// buat cookie dan session
						$user['email'] = base64_encode($user['email']);
						set_cookie('e', hash('sha256', $user['email']), 22118400);
						set_cookie('ui', $user['id'], 22118400);
						$data = [
							'id' => $user['id'],
							'e' => $user['email'],
							'role_id' => $user['role_id']
						];
						session()->set($data);

						// tambahkan log aktivitas user
						$log = [
							'user_id' => $user['id'],
							'ip_address' => htmlspecialchars($this->request->getIPAddress()),
							'user_agent' => htmlspecialchars($this->request->getUserAgent()->getAgentString()),
						];
						$this->logModel->addUserLog($log);
						if ($user['role_id'] == 1) {
							return redirect()->to('/aplikasi/admin')->withCookies();
						} else if ($user['role_id'] == 2) {
							return redirect()->to('/aplikasi/guru')->withCookies();
						} else {
							return redirect()->to('/aplikasi/siswa')->withCookies();
						}
					} else {
						// tambahkan log aktivitas user
						$log = [
							'user_id' => $user['id'],
							'ip_address' => $this->request->getIPAddress(),
							'user_agent' => htmlspecialchars($this->request->getUserAgent()->getAgentString())
						];
						$this->logModel->addUserLog($log);
						// buat session saja
						$data = [
							'id' => $user['id'],
							'e' => $user['email'],
							'role_id' => $user['role_id']
						];
						session()->set($data);
						if ($user['role_id'] == 1) {
							return redirect()->to('/aplikasi/admin')->withCookies();
						} else if ($user['role_id'] == 2) {
							return redirect()->to('/aplikasi/guru')->withCookies();
						} else {
							return redirect()->to('/aplikasi/siswa')->withCookies();
						}
					}
				} else {
					session()->setFlashdata('pesan', 'Akun kamu belum aktif, Silahkan aktifasi akun dahulu.');
					return redirect()->to('/masuk')->withInput();
				}
			} else {
				session()->setFlashdata('pesan', 'Password salah.');
				return redirect()->to('/masuk')->withInput();
			}
		} else {
			session()->setFlashdata('pesan', 'Email tidak terdaftar.');
			return redirect()->to('/masuk')->withInput();
		}
	}

	// validasi Daftar
	public function validasi_daftar()
	{

		if (!$this->validate([
			'namaLengkap' => [
				'label' => 'Nama lengkap',
				'rules' => 'required|max_length[35]|string'
			],
			'mapel_id' => [
				'label' => 'Kelas dan Jurusan',
				'rules' => 'required|max_length[35]|string'
			],
			'email' => 'required|is_unique[user.email]|valid_email',
			'alamat' => 'required',
			'password' => 'required|min_length[6]',
			'konfPassword' => [
				'label' => 'Konfirmasi password',
				'rules' => 'required|matches[password]'
			]
		])) {
			return redirect()->to('/daftar')->withInput();
		} else {
			$password = strtolower($this->request->getPost('password', FILTER_SANITIZE_STRING));
			$slug = url_title($this->request->getPost('namaLengkap', FILTER_SANITIZE_STRING), '-', TRUE);
			$cookie = base64_encode($this->request->getPost('email', FILTER_SANITIZE_EMAIL));
			$email = $this->request->getPost('email', FILTER_SANITIZE_STRING);
			$data = [
				'nama_lengkap' => $this->request->getPost('namaLengkap', FILTER_SANITIZE_STRING),
				'slug' => $slug,
				'alamat' => $this->request->getPost('alamat', FILTER_SANITIZE_STRING),
				'foto' => 'default.jpg',
				'email' => $email,
				'password' => password_hash($password, PASSWORD_DEFAULT),
				'cookie' => hash('sha256', $cookie),
				'role_id' => 3,
				'mapel_id' => $this->request->getPost('mapel_id', FILTER_VALIDATE_INT),
				'is_active' => 0,
			];
			$this->userModel->addUser($data);
			$siswa_daftar = $this->userModel->where(['email' => $email])->first();
			$admin = $this->userModel->where(['role_id' => 1])->first();
			tambah_notif($admin['id'], '/aplikasi/data/ubah-siswa/' . $siswa_daftar['id'], $siswa_daftar['nama_lengkap'] . ' Telah mendaftarkan diri, Silahkan KONFIRMASI SEKARANG!!!', 'fa-user-plus');
			session()->setFlashdata('berhasil', 'Berhasil Daftar! Tunggu Konfirmasi Dari Admin...');
			return redirect()->to('/masuk');
		}
	}


	// block access
	public function blocked()
	{
		return view('aplikasi/auth/blocked');
	}

	// Keluar
	public function keluar()
	{
		delete_cookie('e');
		delete_cookie('ui');
		session()->destroy();
		return redirect()->to('/masuk')->withCookies();
	}
}
