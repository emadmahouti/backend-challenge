<?php
declare(strict_types=1);

use \App\Migration\Migration;

final class UserMigration extends Migration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */

    function up() {
        $this->schema->create('users', function(Illuminate\Database\Schema\Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('password');
            $table->timestamps();
        });

        $rows = [
            [
                'name'  => 'pixy',
                'password' => ''
            ]
        ];

        $this->table('users')->insert($rows)->save();
    }
}
