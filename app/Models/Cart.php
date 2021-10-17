<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Cart
{
    public static function new(Product $product, Request $request)
    {
        // چک کنیم که آیا توی session قبلا سبد خرید ایجاد شده یا نه
        if (session()->has('cart'))
        {
            // get session cart
            $cart = session()->get('cart');
        }



        // وقتی که می خواهیم آیتم یا عنصر جدید به انتهای یک آرایه اضافه کنیم از سینتکس زیر استفاده می کنیم
        // اگر یک محصول تکراری قرار بود به سبد خرید اضافه بشود، یکطور خاصی انجام بدهیم که اجازه ندهیم این رکوردهای تکراری توی ایندکس های مختلف قرار بگیرند
        // $cart[$product->id] => یعنی اگر محصولی قرار بود چند بار کلیک و  به سبد خرید اضافه شود آنگاه بیاید جای رکورد قبلی خودش قرار بگیرد
        $cart[$product->id] = [
            'product' => $product,
            'quantity' => $request->get('quantity')
        ];






        // اضافه کردن همه محتوایی که وجود دارد به cart
        session()->put([
            'cart' => $cart
        ]);
    }
}
