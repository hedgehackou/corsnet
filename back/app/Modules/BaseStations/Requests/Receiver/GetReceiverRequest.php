<?php

declare(strict_types=1);

namespace App\Modules\BaseStations\Requests\Receiver;

use App\Base\Requests\AbstractFormRequest;

class GetReceiverRequest extends AbstractFormRequest
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
            'receiver_id' => ['required', 'exists:receivers,id', 'integer']
        ];
    }

    protected function prepareForValidation()
    {
        parent::prepareForValidation();

        $this->merge(['receiver_id' => $this->route('receiverId')]);
    }
}
