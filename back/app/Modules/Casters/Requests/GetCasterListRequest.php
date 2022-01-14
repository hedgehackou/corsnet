<?php

declare(strict_types=1);

namespace App\Modules\Casters\Requests;

use App\Base\Requests\AbstractFormRequest;

class GetCasterListRequest extends AbstractFormRequest
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
