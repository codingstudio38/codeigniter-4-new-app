<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
class Post extends Migration
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
            'userId' =>[
                'type'=>'INT',
                'constraint'=>9,
                'null'=>false
            ],
            'constant' =>[
                'type'=>'VARCHAR',
                'constraint'=>400,
                'null'=>false,
            ],
            'files' =>[
                'type'=>'VARCHAR',
                'constraint'=>100,
                'null'=>false,
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
        $this->forge->createTable('post_table',true);
    }

    public function down()
    {
        $this->forge->dropTable('post_table',true);
    }
}
