<?php

namespace App\Models;

use CodeIgniter\Model;

class GaleriModel extends Model
{
    protected $DBGroup = "default";

    protected $table = "galeri";
    protected $primaryKey = "id_galeri";
    protected $returnType = "array";
    protected $allowedFields = [
        "id_user",
        "nama_gambar",
    ];
}
