<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Requests\MountPoint;

class UpdateMountPointRequest extends CreateMountPointRequest
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
        return array_merge(parent::rules(),[
            'id' => ['required', 'exists:mount_points,id', 'integer'],
        ]);
    }

    protected function prepareForValidation()
    {
        parent::prepareForValidation();
        $this->merge(['base_id' => $this->route('baseStationId')]);
        $this->merge(['id' => $this->route('mountPointId')]);
    }
}
