<?php

declare(strict_types=1);

namespace App\Modules\Settings\Requests;

use App\Base\Requests\AbstractFormRequest;

class SavePagesRequest extends AbstractFormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            '*' => ['required']
        ];
    }
}
