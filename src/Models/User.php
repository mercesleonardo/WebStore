<?php

namespace App\Models;

use Core\Database\Pinguim\Model;

class User extends Model
{
    protected array $fillable = [
        'name',
        'email',
        'role',
        'password',
    ];
}