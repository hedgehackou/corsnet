<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Requests\BaseStation;

use App\Base\Requests\AbstractFormRequest;

class GetBaseStationRequest extends AbstractFormRequest
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
        return [
            'base_station_id' => ['required', 'exists:base_stations,id', 'integer']
        ];
    }

    protected function prepareForValidation()
    {
        parent::prepareForValidation();

        $this->merge(['base_station_id' => $this->route('baseStationId')]);
    }
}
