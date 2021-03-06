<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Requests\Receiver;

use App\Base\Requests\AbstractFormRequest;

class GetReceiverListRequest extends AbstractFormRequest
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
