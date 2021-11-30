<?php

declare(strict_types=1);

namespace App\Modules\Invite\Requests;

use App\Base\Requests\AbstractFormRequest;

class GetInviteListRequest extends AbstractFormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }
}
