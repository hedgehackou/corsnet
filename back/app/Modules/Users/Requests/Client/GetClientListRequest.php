<?php

declare(strict_types=1);

namespace App\Modules\Users\Requests\Client;

use App\Base\Requests\AbstractFormRequest;

class GetClientListRequest extends AbstractFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [];
    }
}
