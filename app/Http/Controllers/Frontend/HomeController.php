<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Facades\HomeFacade;
use App\Models\CustomPageBuilder;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $data = HomeFacade::getHomeData();
        return view('frontend.home.index', $data);
    }

    public function customPage(string $slug): View
    {
        $page = CustomPageBuilder::where('slug', $slug)->firstOrFail();
        return view('frontend.pages.custom-page', compact('page'));
    }
}
