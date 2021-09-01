<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // send $categories to view and
        // to have access to categories in that view
        return view('client.home', [
            // فقط دسته بندی های اصلی که والد ندارند رو می فرستیم
            'categories' => Category::query()->where('category_id', null)->get()
        ]);
    }
}
