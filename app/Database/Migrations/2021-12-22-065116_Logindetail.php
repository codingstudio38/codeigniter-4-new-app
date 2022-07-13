<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\I18n\Time;

class Logindetail extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'=>'INT',
                'constraint'=> 9,
                'auto_increment'=> true,
                'unsigned'=> true,
            ],
            'login_id' =>[
                'type'=>'INT',
                'constraint'=>9,
                'unsigned'=>true
            ],
            'logintime' =>[
                'type'=>'VARCHAR',
                'constraint'=>200,
                'null'=> true,
            ],
            'logouttime' =>[
                'type'=>'VARCHAR',
                'constraint'=>100,
                'null'=> true,
            ],
            'system' =>[
                'type'=>'VARCHAR',
                'constraint'=>100,
                'null'=> true,
            ],
            'created_at' =>[
                'type'=>'TIMESTAMP',
                 null=> true,
            ],
            'updated_at' =>[
                'type'=>'TIMESTAMP',
                 null=> true,
                 'default'=> NULL,
            ],
            'deleted_at' =>[
                'type'=>'TIMESTAMP',
                 null=> true,
                'default'=> NULL,
            ],
        ]);
        $this->forge->addKey('id',true);
        $this->forge->createTable('logindetails',true);
    }

    public function down()
    {
        $this->forge->dropTable('logindetails',true);
    }
}
