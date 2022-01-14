<?php

declare(strict_types=1);

namespace App\Modules\Countries\Controllers;

use App\Base\Controllers\AbstractController;
use App\Modules\Countries\Resources\CountryResource;
use App\Modules\Countries\Services\CountryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CountryController extends AbstractController
{
    private CountryService $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function getCountries(Request $request): JsonResponse
    {
        return response()->json([
            'list' => CountryResource::collection($this->countryService->getCountries()),
        ]);
    }
}
