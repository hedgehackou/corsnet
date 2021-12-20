<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Requests\Antenna;

use App\Base\Requests\AbstractFormRequest;

class CreateAntennaRequest extends AbstractFormRequest
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
            'base_station_id' => ['integer', 'required', 'exists:base_stations,id'],
            'model' => ['string', 'required'],
            'serial_number' => ['string', 'required'],
            'up_eccentricity' => ['numeric', 'required'],
            'north_eccentricity' => ['numeric', 'required'],
            'east_eccentricity' => ['numeric', 'required'],
            'alignment' => ['numeric', 'required'],
            'installed_at' => ['date', 'nullable'],
            'removed_at' => ['date', 'nullable'],
        ];
    }

    protected function prepareForValidation()
    {
        parent::prepareForValidation();
        $this->merge(['base_station_id' => $this->route('baseStationId')]);
    }
}
