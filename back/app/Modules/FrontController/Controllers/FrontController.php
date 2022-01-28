<?php

declare(strict_types=1);

namespace App\Modules\FrontController\Controllers;

use App\Base\Controllers\AbstractController;
use App\Modules\Settings\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FrontController extends AbstractController
{
    public function mainPage()
    {
        return view('main');
    }

    public function regularPage(Page $page)
    {
        
    }

    public function index(Request $request): string
    {
        return File::get(public_path('/index.html'));
    }
}
