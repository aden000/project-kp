<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $DBGroup = 'default';

    protected $table = 'user';
    protected $primaryKey = 'id_user';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField = 'deleted_at';
    protected $allowedFields = [
        'username',
        'nama_user',
        'role',
        'password'
    ];
}
