<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Repository
 * @property integer id
 * @property string name
 * @property string password
 * @property boolean active
 * @property string updated_at
 * @property string created_at
 */
class User extends Model
{
    protected $table = 'users';
}