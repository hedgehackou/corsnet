<?php

declare(strict_types=1);

namespace App\Modules\Countries\Services;

use App\Base\Services\AbstractService;
use App\Modules\Countries\Models\Country;

class CountryService extends AbstractService
{
    /**
     * @return Country[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getCountries()
    {
        return Country::all();
    }
}
