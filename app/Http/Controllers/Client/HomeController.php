<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\FeaturedCategory;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // check information data's user is logged in website
        // dd(auth()->user());

        // send $categories to view and
        // to have access to categories in that view
        return view('client.home', [
            'featuredCategory' => FeaturedCategory::query()->first()->category,
            'slides' => Slider::all()
        ]);
    }
}
