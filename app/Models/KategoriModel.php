<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $DBGroup = "default";

    protected $table = "kategori";
    protected $primaryKey = "id_kategori";
    protected $returnType = "array";
    protected $allowedFields = [
        "nama_kategori"
    ];
}
