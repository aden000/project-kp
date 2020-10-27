<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtikelModel extends Model
{
    protected $DBGroup = "default";

    protected $table = "artikel";
    protected $primaryKey = "id_artikel";
    protected $returnType = "array";
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $allowedFields = [
        "id_user",
        "id_kategori",
        "judul_artikel",
        "slug",
        "link_gambar",
        "isi_artikel",
        "published_at"
    ];

    public function getNextIncrement()
    {
        $query = $this->db->query("SHOW TABLE STATUS LIKE 'artikel'");
        $result = $query->getRowArray();
        return $result['Auto_increment'];
    }
}
