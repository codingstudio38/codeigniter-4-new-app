<?php

namespace App\Models;

use CodeIgniter\Model;

class Post extends Model
{
    protected $DBGroup              = 'default';
    protected $primaryKey           = 'id';
    protected $table                = 'post_table';
    protected $allowedFields        = ['userId','constant','files'];
    protected $useTimestamps        = true;
    protected $validationRules      = [];
    protected $validationMessages   = [];
}
