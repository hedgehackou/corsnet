<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Requests\Antenna;

use App\Base\Requests\AbstractFormRequest;
use Carbon\Carbon;

class UpdateAntennaRequest extends AbstractFormRequest
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
            'id' => ['required', 'exists:antennas,id', 'integer'],
            'base_id' => ['integer', 'required', 'exists:base_stations,id'],
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
        $this->merge(['base_id' => $this->route('baseStationId')]);
        $this->merge(['id' => $this->route('antennaId')]);
    }

    public function validated()
    {
        $data = parent::validated();
        if ($data['installed_at']) {
            $data['installed_at'] = Carbon::parse($data['installed_at'])->format('Y-m-d H:i:s');
        }
        if ($data['removed_at']) {
            $data['removed_at'] = Carbon::parse($data['removed_at'])->format('Y-m-d H:i:s');
        }

        return $data;
    }
}
