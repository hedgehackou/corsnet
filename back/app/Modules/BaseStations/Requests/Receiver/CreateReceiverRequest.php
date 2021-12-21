<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Requests\Receiver;

use App\Base\Requests\AbstractFormRequest;
use Illuminate\Validation\Rule;

class CreateReceiverRequest extends AbstractFormRequest
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
            'base_id' => ['integer', 'required', 'exists:base_stations,id'],
            'model' => ['string', 'required'],
            'serial_number' => ['string', 'required'],
            'firmware_version' => ['string', 'required'],
            'satellites' => ['array', 'required'],
            'satellites.*' => ['integer', 'required', 'exists:satellite_systems,id'],
            'cutoff' => ['numeric', 'required'],
            'installed_at' => ['date', 'nullable'],
            'removed_at' => ['date', 'nullable'],
        ];
    }

    protected function prepareForValidation()
    {
        parent::prepareForValidation();
        $this->merge(['base_id' => $this->route('baseStationId')]);
    }

    public function validated()
    {
        $data = parent::validated();

        return $data;
    }
}
