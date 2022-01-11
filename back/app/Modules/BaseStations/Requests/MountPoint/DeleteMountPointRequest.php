<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Requests\MountPoint;

use App\Base\Requests\AbstractFormRequest;

class DeleteMountPointRequest extends AbstractFormRequest
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
            'mount_point_id' => ['required', 'exists:mount_points,id', 'integer']
        ];
    }

    protected function prepareForValidation()
    {
        parent::prepareForValidation();

        $this->merge(['mount_point_id' => $this->route('mountPointId')]);
    }
}
