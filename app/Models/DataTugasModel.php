<?php

namespace App\Models;

use CodeIgniter\Model;

class DataTugasModel extends Model
{
  protected $table = 'data_tugas';
  protected $allowedFields = ['tugas_id', 'user_id', 'deskripsi', 'is_kumpul'];
  protected $useTimestamps = true;

  // ambil data tugas
  public function getDataTugas($id = false)
  {
    if ($id != false) {
      return $this->where(['id' => $id])->first();
    }
    return $this->findAll();
  }
}
