<?php

namespace App\Models;

use CodeIgniter\Model;


class NotifikasiModel extends Model
{
  protected $table = 'notifikasi';
  protected $allowedFields = ['user_id', 'url', 'text', 'icon', 'is_cek'];
  protected $useTimestamps = true;

  public function getRow($user_id)
  {
    $row = $this->db->table($this->table)->where(['user_id' => $user_id, 'is_cek' => 0])->countAllResults();
    if (empty($row)) {
      return 0;
    } else {
      return $row;
    }
  }

  public function getResult($user_id)
  {
    return $this->db->table($this->table)->where(['user_id' => $user_id])->orderBy('id', 'DESC')->limit(5)->get()->getResultArray();
  }
}
