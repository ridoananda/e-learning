<?php

namespace App\Models;

use CodeIgniter\Model;

class KomentarTugasModel extends Model
{
  protected $table = 'komentar_tugas';
  protected $allowedFields = ['tugas_id', 'user_id', 'komentar'];
  protected $useTimestamps = true;
}
