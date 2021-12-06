<?php

declare(strict_types=1);

namespace App\Modules\Users\Requests;

use App\Base\Requests\AbstractFormRequest;

class GetUserListRequest extends AbstractFormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [];
    }
}
