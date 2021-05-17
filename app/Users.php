<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = "tbkodepo";
    protected $fillable = [
        'role_id',
        'username',
        'password',
        'created_at',
        'updated_at',
    ];
}
