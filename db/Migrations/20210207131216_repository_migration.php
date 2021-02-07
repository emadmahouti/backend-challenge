<?php
declare(strict_types=1);

use \App\Migration\Migration;

final class RepositoryMigration extends Migration
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
        $this->schema->create('repositories', function(Illuminate\Database\Schema\Blueprint $table){
            $table->increments('id');
            $table->integer('rep_id')
                ->nullable(false);
            $table->integer('user_id')
                ->nullable(false);
            $table->string('rep_name');
            $table->string('rep_description');
            $table->string('rep_url');
            $table->timestampsTz();
        });

        $this->table('repositories')
            ->addIndex(['user_id', 'rep_id'])
            ->save();
    }
}
