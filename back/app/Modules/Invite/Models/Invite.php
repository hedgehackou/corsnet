<?php

declare(strict_types=1);

namespace App\Modules\Invite\Models;

use App\Base\Models\AbstractModel;

/**
 * @property int $id
 * @property string $email
 * @property string $token
 * @property boolean $is_admin
 * @property boolean $is_accepted
 */
class Invite extends AbstractModel
{
    protected string $table = 'invites';
    protected array $fillable = [
        'email',
        'token',
        'is_admin',
        'is_accepted',
    ];
    protected array $casts = [
        'is_admin' => 'boolean',
        'is_accepted' => 'boolean',
    ];
}
