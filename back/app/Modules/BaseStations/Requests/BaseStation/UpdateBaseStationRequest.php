<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Requests\BaseStation;

use App\Base\Requests\AbstractFormRequest;
use App\Modules\BaseStations\Models\BaseStation;
use Illuminate\Validation\Rule;

class UpdateBaseStationRequest extends AbstractFormRequest
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
            'name' => ['required', 'string'],
            'city' => ['required', 'string'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'height' => ['required', 'numeric'],
            'status' => ['required', Rule::in(['active', 'disabled'])],
        ];
    }

    public function validated(): array
    {
        $data = parent::validated();
        $data['status_id'] = BaseStation::STATUSES[$data['status']];

        return $data;
    }
}
