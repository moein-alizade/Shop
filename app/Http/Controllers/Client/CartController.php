<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request, Product $product)
    {
        // وقتی که یک رکورد جدید می خواهیم اضافه کنیم باید اطلاعات کامل محصول را داشته باشیم
        // بدون route model binding
        // $product = Product::find($request->get('productId'));


        // ایجاد سبد خرید جدید طبق محصول و اطلاعات فرستاده شده مربوط به آن
        Cart::new($product, $request);



        return response([
            'msg' => 'successful',
            'cart' => session()->get('cart')
        ], '200');
    }
}
