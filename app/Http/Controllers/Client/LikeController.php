<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request, Product $product)
    {

        auth()->user()->like($product);

        // response(['content'], 'status code')
        return response(['mst' => 'liked'], '200');
    }
}
