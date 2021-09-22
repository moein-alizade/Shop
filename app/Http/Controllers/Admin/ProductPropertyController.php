<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductPropertyController extends Controller
{
    // Product $product => product یک محصول از جنس مذل
    public function index(Product $product)
    {
        return view('admin.productProperty.index', [
            'product' => $product
        ]);
    }


    public function store(Request $request, Product $product)
    {
        // sync() => و همه ی این موارد از همین صفحه استفاده بکنیم و صفحه دیگه استفاده نمی کنیم store and edit دلیل استفاده ازش این هست که قراره ما برای
        $product->properties()->sync($request->get('properties'));

        return redirect()->back();
    }
}
