<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
	protected $table = 'user';
	protected $allowedFields = ['nama_lengkap', 'slug', 'alamat', 'foto', 'email', 'password', 'cookie', 'role_id', 'mapel_id', 'is_active'];
	protected $useTimestamps = true;

	// ambil data user
	public function getUser($id = false)
	{
		if ($id == false) {
			return $this->findAll();
		}
		return $this->where(['id' => $id])->first();
	}

	// update profil user
	public function updateUser($data)
	{
		return $this->save($data);
	}

	// Add User
	public function addUser($data)
	{
		return $this->save($data);
	}
}
