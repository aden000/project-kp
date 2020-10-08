<?php

namespace App\Models;

use CodeIgniter\Model;

class KomentarModel extends Model
{
    protected $DBGroup = "default";

    protected $table = "komentar";
    protected $primaryKey = "id_komentar";
    protected $returnType = "array";
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $allowedFields = [
        "id_artikel",
        "refer_id",
        "nama_komentar",
        "email_komentar",
        "isi_komentar"
    ];
}
