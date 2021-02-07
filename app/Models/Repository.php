<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Repository
 * @property integer id
 * @property integer rep_id
 * @property integer user_id
 * @property string rep_name
 * @property string rep_description
 * @property string rep_url
 * @property boolean active
 * @property string updated_at
 * @property string created_at
 */
class Repository extends Model
{
    protected $table = 'repositories';

    protected $fillable = ['rep_id', 'user_id', 'rep_name', 'rep_description', 'rep_url'];

    function tags() {
        return $this->hasMany(Tag::class, 'rep_id');
    }
}