<?php

namespace App\Models;

use CodeIgniter\Model;

class DataAbsenModel extends Model
{
  protected $table = 'data_absen';
  protected $allowedFields = ['absen_id', 'user_id', 'mapel', 'keterangan', 'alasan', 'is_absen'];
  protected $useTimestamps = true;

  // ambil data absen
  public function getDataAbsen($id = false)
  {
    if ($id != false) {
      return $this->where(['id' => $id])->first();
    }
    return $this->findAll();
  }
}
