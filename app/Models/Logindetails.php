<?php

namespace App\Models;

use CodeIgniter\Model;

class Logindetails extends Model
{
    protected $DBGroup              = 'default';
    protected $primaryKey           = 'id';
    protected $table                = 'logindetails';
    protected $allowedFields        = ['login_id','logintime','logouttime','system'];
    protected $useTimestamps        = true;
    protected $validationRules      = [];
    protected $validationMessages   = [];
}
