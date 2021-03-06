<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Requests\Receiver;

use App\Base\Requests\AbstractFormRequest;

class GetSatelliteSystemListRequest extends AbstractFormRequest
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
        return [];
    }
}
