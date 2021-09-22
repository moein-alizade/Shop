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
}
