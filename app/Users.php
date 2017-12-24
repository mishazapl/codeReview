<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login', 'email', 'password', 'role_id', 'token'
    ];

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

}
