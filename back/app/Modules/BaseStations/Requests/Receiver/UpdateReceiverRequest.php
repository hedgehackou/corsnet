<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Requests\Receiver;

use App\Base\Requests\AbstractFormRequest;
use Illuminate\Validation\Rule;

class UpdateReceiverRequest extends AbstractFormRequest
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
            'id' => ['required', 'exists:receivers,id', 'integer'],
            'base_station_id' => ['integer', 'required', 'exists:base_stations,id'],
            'model' => ['string', 'required'],
            'serial_number' => ['string', 'required'],
            'firmware_version' => ['string', 'required'],
            'satellite_systems' => ['array', 'required'],
            'satellite_systems.*' => ['integer', 'required', 'exists:satellite_systems,id'],
            'cutoff' => ['integer', 'required'],
            'installed_at' => ['integer', 'required', 'date_format:Y-m-d H:i:s'],
            'removed_at' => ['integer', 'required', 'date_format:Y-m-d H:i:s'],
        ];
    }

    protected function prepareForValidation()
    {
        parent::prepareForValidation();
        $this->merge(['is_online' => (bool) $this->get('is_online', false)]);
    }
}
