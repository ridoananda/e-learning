<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsenModel extends Model
{
  protected $table = 'absen';
  protected $allowedFields = ['user_id', 'mapel_id', 'mapel', 'expired'];
  protected $useTimestamps = true;

  public function getAbsen($id = false)
  {
    if ($id != false) {
      return $this->where(['id' => $id])->first();
    }
    return $this->findAll();
  }
}
