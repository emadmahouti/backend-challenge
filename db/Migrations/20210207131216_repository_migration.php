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
    function up()
    {
        $this->schema->create('repositories', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('rep_id');
            $table->integer('user_id');
            $table->string('rep_name');
            $table->string('language')->nullable(true);
            $table->string('rep_description')
                ->charset('utf8mb4')
                ->collation('utf8mb4_unicode_ci')
                ->nullable(true);
            $table->string('rep_url');
            $table->timestampsTz();
        });

        $this->table('repositories')
            ->addIndex(['user_id', 'rep_id'])
            ->save();
    }
}
