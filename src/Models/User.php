<?php

namespace App\Models;

use Core\Database\Pinguim\Model;
use Core\Database\Query\Builder;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $role
 * @property string $password
 * @property string $created_at
 * @property string $updated_at
 *
 * @method static User find(int $id)
 * @method static User first()
 * @method static Builder query()
 */

class User extends Model
{
    protected array $fillable = [
        'name',
        'email',
        'role',
        'password',
    ];
}