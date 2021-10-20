<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Cart
{

    public static function new(Product $product, Request $request)
    {
        // سبد خرید اولیه با مقادیر اولیه صفر برای total_amount and total_items
        $cart = [
            'total_amount' => 0,
            'total_items' => 0
        ];

        // چک کنیم که آیا توی session قبلا سبد خرید ایجاد شده یا نه
        // آیا قبلا سبد خرید داریم یا نه
        if (session()->has('cart'))
        {
            // get session cart => گرفتن و ذخیره سبد خرید
            $cart = session()->get('cart');
        }


        // اگه قبلا این محصولی که الان می خواهیم اضافه کنیم، در سبد خرید بود یعنی خواستیم محصول تکراری اضافه کنیم آنگاه اگه قبلا بود بیا تعداد قبلی را با تعداد جدید جمع کن و در quantity$ بریز
        // اگه قبلا نبود آنگاه بیا همان مقدار قبلی را در quantity$ بریز
        $quantity = isset(session()->get('cart')[$product->id]) ?  ($request->get('quantity') + session()->get('cart')[$product->id]['quantity']) : $request->get('quantity');


        // وقتی که می خواهیم آیتم یا عنصر جدید به انتهای یک آرایه اضافه کنیم از سینتکس زیر استفاده می کنیم
        // اگر یک محصول تکراری قرار بود به سبد خرید اضافه بشود، یکطور خاصی انجام بدهیم که اجازه ندهیم این رکوردهای تکراری توی ایندکس های مختلف قرار بگیرند
        // $cart[$product->id] => یعنی اگر محصولی قرار بود چند بار کلیک و  به سبد خرید اضافه شود آنگاه بیاید جای رکورد قبلی خودش قرار بگیرد
        $cart[$product->id] = [
            'product' => $product,
            'quantity' => $quantity
        ];


        // چون توی سبد خرید همیشه دو تا متغیر total_amount and total_items هست آنگاه برای محاسبه دقیق و صحیح تعداد آیتم ها باید تعداد کل آیتم های سبد را منهای 2 کنیم
        $cart['total_items'] = count($cart)-2;
        $cart['total_amount'] = Cart::totalAmount($cart);


         // اضافه کردن همه محتوایی که وجود دارد به cart یا همان سبد خرید
        session()->put([
            'cart' => $cart
        ]);


    }

    // محاسبه مجموع قیمت محصولات سبد خرید
    public static function totalAmount($cart)
    {

        $totalAmount = 0;


        foreach ($cart as $cartItem) {
            // اگر این دو تا ایندکس وجود داشت
            if (is_array($cartItem) && array_key_exists('product', $cartItem) && array_key_exists('quantity', $cartItem)) {
                // تعداد آن محصول توی سبد خرید * قیمت تخفیف خورده ( یا تخفیف نخورد) محصول =+ قیمت فعلی سبد خرید
                $totalAmount += $cartItem['product']->cost_with_discount * $cartItem['quantity'];
            }
        }

        return $totalAmount;
    }


}
