<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Repository
 * @property integer id
 * @property integer rep_id
 * @property string title
 * @property boolean active
 * @property string updated_at
 * @property string created_at
 */
class Tag extends Model
{
    protected $table = 'tags';

    function repository() {
        return $this->belongsTo(Repository::class, 'rep_id', 'id');
    }
}