<?php
declare(strict_types=1);

use \App\Migration\Migration;

final class TagMigration extends Migration
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
        $this->schema->create('tags', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->increments('id');
            $table->integer('rep_id')
                ->nullable(false);
            $table->string('title');
            $table->timestampsTz();
        });
    }
}
