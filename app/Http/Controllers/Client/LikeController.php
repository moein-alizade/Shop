<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('client.likes.index', [
            'products' => auth()->user()->likes
        ]);
    }

    public function store(Request $request, Product $product)
    {

        auth()->user()->like($product);

        // response(['content'], 'status code')
        return response(['mst' => 'liked'], '200');
    }
}
