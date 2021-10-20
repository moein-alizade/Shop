<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Cart
{
    public static function new(Product $product, Request $request)
    {
        $cart = [
            'total_amount' => 0,
            'total_items' => 0
        ];

        // چک کنیم که آیا توی session قبلا سبد خرید ایجاد شده یا نه
        if (session()->has('cart'))
        {
            // get session cart
            $cart = session()->get('cart');
        }


        $quantity = isset(session()->get('cart')[$product->id]) ?  ($request->get('quantity') + session()->get('cart')[$product->id]['quantity']) : $request->get('quantity');


        // وقتی که می خواهیم آیتم یا عنصر جدید به انتهای یک آرایه اضافه کنیم از سینتکس زیر استفاده می کنیم
        // اگر یک محصول تکراری قرار بود به سبد خرید اضافه بشود، یکطور خاصی انجام بدهیم که اجازه ندهیم این رکوردهای تکراری توی ایندکس های مختلف قرار بگیرند
        // $cart[$product->id] => یعنی اگر محصولی قرار بود چند بار کلیک و  به سبد خرید اضافه شود آنگاه بیاید جای رکورد قبلی خودش قرار بگیرد
        $cart[$product->id] = [
            'product' => $product,
            'quantity' => $quantity
        ];



        $cart['total_items'] = count($cart)-2;
        $cart['total_amount'] = Cart::totalAmount($cart);


        // اضافه کردن همه محتوایی که وجود دارد به cart
        session()->put([
            'cart' => $cart
        ]);


    }



    public static function totalAmount($cart)
    {
        $totalAmount = 0;

//        if(!session()->get('cart'))
//        {
//            return $totalAmount;
//        }



        foreach ($cart as $cartItem) {

            // اگر این دو تا ایندکس وجود داشت
            if (is_array($cartItem) && array_key_exists('product', $cartItem) && array_key_exists('quantity', $cartItem)) {
                $totalAmount += $cartItem['product']->cost_with_discount * $cartItem['quantity'];
            }
        }

        return $totalAmount;
    }


}
