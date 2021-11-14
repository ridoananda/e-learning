<?php

namespace App\Models;

use CodeIgniter\Model;

class KomentarArtikelModel extends Model
{
  protected $table = 'komentar_artikel';
  protected $allowedFields = ['artikel_id', 'user_id', 'text'];
  protected $useTimestamps = true;
}
