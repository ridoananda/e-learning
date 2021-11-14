<?php namespace App\Models;

use CodeIgniter\Model;

class LogModel extends Model
{
	protected $table = 'log_aktivitas';
	protected $allowedFields = ['user_id', 'ip_address', 'user_agent'];
	protected $useTimestamps = true;
	
	// ambil data user
	public function getUserLog($id = false){
		if ($id != false) {
			return $this->where(['user_id' => $id])->first();
		}
		return $this->findAll();
	}
	
	// Add Log aktivitas
	public function addUserLog($data){
		return $this->save($data);
	}
	
	
	
	
}