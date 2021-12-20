<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Requests\Antenna;

use App\Base\Requests\AbstractFormRequest;

class GetAntennaRequest extends AbstractFormRequest
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
            'antenna_id' => ['required', 'exists:antennas,id', 'integer']
        ];
    }

    protected function prepareForValidation()
    {
        parent::prepareForValidation();

        $this->merge(['antenna_id' => $this->route('antennaId')]);
    }
}
