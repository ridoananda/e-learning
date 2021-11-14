<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtikelModel extends Model
{
  protected $table = 'artikel';
  protected $allowedFields = ['user_id', 'kategori_id', 'judul', 'slug', 'thumbnail', 'text', 'aktif'];
  protected $useTimestamps = true;

  public function getArtikel($id = false)
  {
    if ($id != false) {
      return $this->where(['id' => $id])->first();
    }
    return $this->findAll();
  }

  public function cari_artikel($keyword)
  {
    // $db = \Config\Database::connect();
    $kategori = $this->db->table('kategori_artikel')->where(['kategori' => $keyword])->get()->getRowArray();
    return ($kategori == null) ? $this->table('artikel')->like('judul', $keyword)->orLike('text', $keyword) : $this->table('artikel')->like('judul', $keyword)->orLike('text', $keyword)->orLike('kategori_id', $kategori['id']);
  }
}
