<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Requests\MountPoint;

use App\Base\Requests\AbstractFormRequest;
use App\Modules\BaseStations\Models\MountPoint;
use Illuminate\Validation\Rule;

class CreateMountPointRequest extends AbstractFormRequest
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
            'name' => ['string', 'required'],
            'user_name' => ['string', 'required'],
            'password' => ['string', 'required'],
            'ntrip_version' => ['string', Rule::in(MountPoint::NTRIP_VERSIONS)],
            'is_encrypted' => ['boolean'],
        ];
    }

    protected function prepareForValidation()
    {
        parent::prepareForValidation();
        $this->merge([
            'base_id' => $this->route('baseStationId')
        ]);
    }
}
