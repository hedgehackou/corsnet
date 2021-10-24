<?php

declare(strict_types=1);

namespace App\Modules\Auth\Requests;

use App\Base\Requests\AbstractFormRequest;

class FetchProfileRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [];
    }
}
