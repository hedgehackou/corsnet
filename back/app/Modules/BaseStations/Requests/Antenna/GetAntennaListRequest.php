<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Requests\Antenna;

use App\Base\Requests\AbstractFormRequest;

class GetAntennaListRequest extends AbstractFormRequest
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
