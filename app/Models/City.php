<?php

namespace App\Models;

use CodeIgniter\Model; 

class City extends Model
{
    protected $DBGroup              = 'default';
    protected $primaryKey           = 'id';
    protected $table                = 'bird_cities';
    protected $allowedFields        = [];
    protected $useTimestamps        = true;
    protected $validationRules      = [];
    protected $validationMessages   = [];
}
