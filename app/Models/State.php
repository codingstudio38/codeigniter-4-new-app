<?php

namespace App\Models;

use CodeIgniter\Model;

class State extends Model
{
    protected $DBGroup              = 'default';
    protected $primaryKey           = 'id';
    protected $table                = 'bird_states';
    protected $allowedFields        = [];
    protected $useTimestamps        = true;
    protected $validationRules      = [];
    protected $validationMessages   = [];
}
