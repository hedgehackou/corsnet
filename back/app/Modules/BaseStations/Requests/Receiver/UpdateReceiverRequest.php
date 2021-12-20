<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Requests\Receiver;

use App\Base\Requests\AbstractFormRequest;
use Carbon\Carbon;
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
            'satellites' => ['array', 'required'],
            'satellites.*' => ['integer', 'required', 'exists:satellite_systems,id'],
            'cutoff' => ['numeric', 'required'],
            'installed_at' => ['nullable', 'date'],
            'removed_at' => ['nullable', 'date'],
        ];
    }

    protected function prepareForValidation()
    {
        parent::prepareForValidation();
        $this->merge(['base_station_id' => $this->route('baseStationId')]);
        $this->merge(['id' => $this->route('receiverId')]);
    }

    public function validated()
    {
        $data = parent::validated();
        $data['base_id'] = $data['base_station_id'];
        if ($data['installed_at']) {
            $data['installed_at'] = Carbon::parse($data['installed_at'])->format('Y-m-d H:i:s');
        }
        if ($data['removed_at']) {
            $data['removed_at'] = Carbon::parse($data['removed_at'])->format('Y-m-d H:i:s');
        }

        return $data;
    }
}
