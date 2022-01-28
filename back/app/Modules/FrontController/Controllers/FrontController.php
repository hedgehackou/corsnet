<?php

declare(strict_types=1);

namespace App\Modules\FrontController\Controllers;

use App\Base\Controllers\AbstractController;
use App\Modules\FrontController\Services\FrontControllerService;
use App\Modules\Settings\Models\Page;
use App\Modules\Settings\Services\SettingsService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FrontController extends AbstractController
{
    private FrontControllerService $frontControllerService;
    private SettingsService $settingsService;

    /**
     * @param FrontControllerService $frontControllerService
     * @param SettingsService        $settingsService
     */
    public function __construct(FrontControllerService $frontControllerService, SettingsService $settingsService)
    {
        $this->frontControllerService = $frontControllerService;
        $this->settingsService = $settingsService;
    }

    /**
     * @return Application|Factory|View
     */
    public function mainPage()
    {
        $page = Page::where('slug', '')->firstOrFail();
        return view('index', [
            'header' => $this->settingsService->getPageHeader(),
            'footer' => $this->settingsService->getPageFooter(),
            'navigation' => $this->settingsService->getNavigation(),
            'page' => $this->frontControllerService->getPageData($page)
        ]);
    }

    /**
     * @param Page $page
     *
     * @return Application|Factory|View
     */
    public function regularPage(Page $page)
    {
        return view('index', [
            'header' => $this->settingsService->getPageHeader(),
            'footer' => $this->settingsService->getPageFooter(),
            'navigation' => $this->settingsService->getNavigation(),
            'page' => $this->frontControllerService->getPageData($page)
        ]);
    }

    /**
     * @param Request $request
     *
     * @return string
     */
    public function index(Request $request): string
    {
        return File::get(public_path('/index.html'));
    }
}
