<?php

namespace App\Models;

use CodeIgniter\Model;

class Profiles extends Model
{
    protected $DBGroup              = 'default';
    protected $primaryKey           = 'id';
    protected $table                = 'profiles';
    protected $allowedFields        = ['user_id','address','city','state','country','thumbnail'];
    protected $useTimestamps        = true;
    protected $validationRules      = [];
    protected $validationMessages   = [];
}
