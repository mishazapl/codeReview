<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';

    public $timestamps = false;

    public function users()
    {
        return $this->hasMany(Users::class, 'role_id', 'id');
    }
}
