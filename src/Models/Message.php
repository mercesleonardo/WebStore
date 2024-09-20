<?php

declare(strict_types = 1);

namespace App\Models;

use Core\Database\Pinguim\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $source
 * @property string $message
 *
 * @method static Message find(int | string $id)
 * @method static Message[] all()
 * @method static Message create(array $attributes)
 */
class Message extends Model
{
    //    public bool $timestamps = false;

    protected array $fillable = [
        'name',
        'email',
        'source',
        'message',
    ];
}
