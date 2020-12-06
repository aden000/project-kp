<?php

namespace App\Models;

use CodeIgniter\Model;

class DokumenModel extends Model
{
    protected $DBGroup = "default";

    protected $table = "dokumen";
    protected $primaryKey = "id_dokumen";
    protected $returnType = "array";
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';

    protected $allowedFields = [
        "nama_dokumen",
        "file_dokumen",
        "id_user"
    ];
}
