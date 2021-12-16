<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Requests\BaseStation;

use App\Base\Requests\AbstractFormRequest;

class GetBaseStationListRequest extends AbstractFormRequest
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
