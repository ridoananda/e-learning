<?php

namespace App\Controllers\Aplikasi;

use App\Controllers\BaseController;

class Admin extends BaseController
{
	public function index()
	{
		$data = [
			'title' => 'Dashboard',
			'user' => $this->userModel->getUser($this->id),
			'db' => \Config\Database::connect(),
		];
		return view('aplikasi/admin/index', $data);
	}

	public function role()
	{
		$data = [
			'title' => 'Role',
			'user' => $this->userModel->getUser($this->id),
			'db' => \Config\Database::connect(),
			'validation' => \Config\Services::validation(),
			'role' => $this->db->table('user_role')->get()->getResultArray(),
		];
		return view('aplikasi/admin/role', $data);
	}

	public function mapel()
	{
		$data = [
			'title' => 'User Mapel',
			'user' => $this->userModel->getUser($this->id),
			'db' => \Config\Database::connect(),
			'validation' => \Config\Services::validation(),
			'mapel' => $this->db->table('user_mapel')
				->select('user_mapel.*, user_role.name')
				->join('user_role', 'user_mapel.user_role = user_role.id')
				->orderBy('user_role.name', 'DESC')
				->orderBy('user_mapel.jurusan', 'ASC')
				->orderBy('user_mapel.kelas', 'ASC')
				->get()->getResultArray(),
		];
		return view('aplikasi/admin/mapel', $data);
	}

	public function role_access($id)
	{
		$data = [
			'title' => 'Role Access',
			'user' => $this->userModel->getUser($this->id),
			'db' => \Config\Database::connect(),
			'validation' => \Config\Services::validation(),
			'menu' => $this->db->table('user_menu')->where('id !=', 1)->get()->getResultArray(),
			'role' => $this->db->table('user_role')->where(['id' => $id])->get()->getRowArray(),
		];
		return view('aplikasi/admin/role-access', $data);
	}

	public function laporan()
	{
		$data = [
			'title' => 'Laporan',
			'user' => $this->userModel->getUser($this->id),
			'db' => \Config\Database::connect(),
			'validation' => \Config\Services::validation(),
			'laporan' => $this->db->table('laporan')->get()->getResultArray(),
		];
		return view('aplikasi/admin/laporan', $data);
	}

	public function hubungi()
	{
		$data = [
			'title' => 'Hubungi',
			'user' => $this->userModel->getUser($this->id),
			'db' => \Config\Database::connect(),
			'validation' => \Config\Services::validation(),
			'hubungi' => $this->db->table('hubungi')->get()->getResultArray(),
		];
		return view('aplikasi/admin/hubungi', $data);
	}



	/* <========================= TAMBAH =========================> */
	public function tambah_role()
	{
		if (!$this->validate([
			'name' => 'required|string',
		])) {
			return redirect()->to('/aplikasi/admin/role')->withInput();
		}
		$name = htmlspecialchars($this->request->getPost('name'));
		$this->db->table('user_role')->insert(['name' => $name]);
		session()->setFlashdata('berhasil', 'Role berhasil ditambahkan!');
		return redirect()->to('/aplikasi/admin/role')->withInput();
	}
	public function tambah_mapel()
	{
		if (!$this->validate([
			'mapel' => 'required|string',
		])) {
			return redirect()->to('/aplikasi/admin/mapel')->withInput();
		}
		$mapel = htmlspecialchars($this->request->getPost('mapel'));
		$this->db->table('user_mapel')->insert([
			'user_role' => 2,
			'mapel' => $mapel
		]);
		session()->setFlashdata('berhasil', 'Mapel berhasil ditambahkan!');
		return redirect()->to('/aplikasi/admin/mapel')->withInput();
	}
	public function tambah_kelas()
	{
		if (!$this->validate([
			'kelas' => 'required',
			'jurusan' => 'required'
		])) {
			return redirect()->to('/aplikasi/admin/mapel')->withInput();
		}
		$kelas = htmlspecialchars($this->request->getPost('kelas'));
		$jurusan = htmlspecialchars($this->request->getPost('jurusan'));
		$this->db->table('user_mapel')->insert([
			'user_role' => 3,
			'kelas' => $kelas,
			'jurusan' => $jurusan
		]);
		session()->setFlashdata('berhasil', 'Kelas & Jurusan berhasil ditambahkan!');
		return redirect()->to('/aplikasi/admin/mapel')->withInput();
	}


	/* <========================= UBAH =========================> */
	public function ubah_role()
	{
		if ($this->request->isAjax()) {
			$role_id = htmlspecialchars($this->request->getPost('role_id'));
			$menu_id = htmlspecialchars($this->request->getPost('menu_id'));

			$data = [
				'role_id' => $role_id,
				'menu_id' => $menu_id
			];

			$result = $this->db->table('user_access_menu')->where($data)->countAllResults();

			if ($result > 0) {
				$this->db->table('user_access_menu')->delete($data);
			} else {
				$this->db->table('user_access_menu')->insert($data);
			}
			session()->setFlashdata('berhasil', 'Role Access Berhasil diubah!');
		} else {
			return redirect()->to('/auth/blocked');
		}
	}
	public function ubah_nama_role()
	{
		if ($this->request->isAjax()) {
			if (!$this->validate([
				'name' => 'required|string',
			])) {
				return redirect()->to('/aplikasi/admin/role')->withInput();
			}
			$id = htmlspecialchars($this->request->getPost('id'));
			$name = htmlspecialchars($this->request->getPost('name'));
			session()->setFlashdata('berhasil', 'Role berhasil diubah!');
			return $this->db->table('user_role')->update(['name' => $name], ['id' => $id]);
		} else {
			return redirect()->to('/auth/blocked');
		}
	}

	public function ubah_mapel()
	{
		if ($this->request->isAjax()) {
			$id = htmlspecialchars($this->request->getPost('id'));
			$mapel = htmlspecialchars($this->request->getPost('mapel'));
			if (!$this->validate([
				'mapel' => 'required'
			])) {
				return redirect()->withInput();
			}
			session()->setFlashdata('berhasil', 'Mapel berhasil diubah!');
			return $this->db->table('user_mapel')->update([
				'mapel' => $mapel
			], ['id' => $id]);
		} else {
			return redirect()->to('/auth/blocked');
		}
	}
	public function ubah_kelas()
	{
		if ($this->request->isAjax()) {
			$id = htmlspecialchars($this->request->getPost('id'));
			$kelas = htmlspecialchars($this->request->getPost('kelas'));
			$jurusan = htmlspecialchars($this->request->getPost('jurusan'));
			if (!$this->validate([
				'kelas' => 'required',
				'jurusan' => 'required'
			])) {
				return redirect()->withInput();
			}
			session()->setFlashdata('berhasil', 'Kelas & Jurusan berhasil diubah!');
			return $this->db->table('user_mapel')->update([
				'kelas' => $kelas,
				'jurusan' => $jurusan
			], ['id' => $id]);
		} else {
			return redirect()->to('/auth/blocked');
		}
	}


	/* <========================= HAPUS =========================> */
	public function hapus_role()
	{
		if ($this->request->isAjax()) {
			$id = htmlspecialchars($this->request->getPost('id'));
			session()->setFlashdata('berhasil', 'Role Access Berhasil dihapus!');
			return $this->db->table('user_role')->delete(['id' => $id]);;
		} else {
			return redirect()->to('/auth/blocked');
		}
	}
	public function hapus_mapel()
	{
		if ($this->request->isAjax()) {
			$id = htmlspecialchars($this->request->getPost('id'));
			session()->setFlashdata('berhasil', 'Mapel/Kelas & Jurusan Berhasil dihapus!');
			return $this->db->table('user_mapel')->delete(['id' => $id]);;
		} else {
			return redirect()->to('/auth/blocked');
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

  public function notifikasi()
  {
    $data = [
      'title' => 'Notifikasi',
      'user' => $this->userModel->getUser($this->id),
      'db' => \Config\Database::connect(),
      'notifikasi' => $this->notifModel->where(['user_id' => $this->id])->orderBy('id', 'DESC')->paginate(10, 'notifikasi'),
      'pager' => $this->notifModel->pager
    ];
    return view('aplikasi/admin/notifikasi', $data);
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
}