<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        return view('client.products.show', [
            'product' => $product,
            // فقط دسته بندی های اصلی که والد ندارند رو می فرستیم
            'categories' => Category::query()->where('category_id', null)->get(),
            'brands' => Brand::all()
        ]);
    }
}
