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
            'mountpoint' => ["string", 'nullable'],
            'identifier' => ["string", 'nullable'],
            'format' => ["string", 'nullable'],
            'format_details' => ["string", 'nullable'],
            'carrier' => ["integer", 'nullable', Rule::in(array_keys(MountPoint::CARRIERS))],
            'nav_system' => ['string', 'nullable'],
            'network' => ['string', 'nullable'],
            'country' => ['string', 'nullable'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'nmea' => ['integer', 'nullable', Rule::in(array_keys(MountPoint::NMEA))],
            'solution' => ['integer', 'nullable', Rule::in(array_keys(MountPoint::SOLUTION))],
            'generator' => ['string', 'nullable'],
            'compr_encryp' => ['string', 'nullable'],
            'fee' => ['string', 'nullable', Rule::in(array_keys(MountPoint::FEE))],
            'bitrate' => ['integer', 'nullable'],
            'misc'=> ['string', 'nullable'],
        ];
    }

    /**
     * @return void
     */
    protected function prepareForValidation()
    {
        parent::prepareForValidation();
        $this->merge([
            'base_id' => $this->route('baseStationId')
        ]);
    }

    /**
     * @return array
     */
    public function validated()
    {
        $validated = parent::validated();
        $validated['mountpoint'] = $validated['mountpoint'] ?? '';
        $validated['identifier'] = $validated['identifier'] ?? '';
        $validated['format'] = $validated['format'] ?? '';
        $validated['format_details'] = $validated['format_details'] ?? '';
        $validated['carrier'] = $validated['carrier'] ?? 0;
        $validated['nav_system'] = $validated['nav_system'] ?? '';
        $validated['network'] = $validated['network'] ?? '';
        $validated['country'] = $validated['country'] ?? 'AF';
        $validated['latitude'] = $validated['latitude'] ?? 0;
        $validated['longitude'] = $validated['longitude'] ?? 0;
        $validated['nmea'] = $validated['nmea'] ?? 0;
        $validated['solution'] = $validated['solution'] ?? 0;
        $validated['generator'] = $validated['generator'] ?? '';
        $validated['compr_encryp'] = $validated['compr_encryp'] ?? 'none';
        $validated['authentication'] = $validated['authentication'] ?? 'B';
        $validated['fee'] = $validated['fee'] ?? 'N';
        $validated['bitrate'] = $validated['bitrate'] ?? 0;
        $validated['misc'] = $validated['misc'] ?? '';

        return $validated;
    }
}
